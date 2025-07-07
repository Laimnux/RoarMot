<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\ProductModel;

class DashboardControllerVen extends BaseController
{
    protected $session;
    protected $productModel; // Propiedad para el modelo de producto (asegúrate de que sea $productModel con 'p' minúscula)

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->productModel = new ProductModel(); // Instancia el modelo (asegúrate de que sea $this->productModel con 'p' minúscula)
        helper(['form', 'url']); // Asegúrate de cargar el helper 'form' para la validación de archivos
    }

    public function index()
    {
        // Verificar si el usuario está logueado y si su rol es Vendedor (ROL_ID_ROL = 2)
        if (!$this->session->get('isLoggedIn') || $this->session->get('ROL_ID_ROL') != 2) {
            // Si no está logueado o no es vendedor, redirigir al login o a un dashboard apropiado
            return redirect()->to(base_url('login'))->with('error_message', 'Acceso no autorizado para este rol.');
        }

        // Obtener datos del usuario de la sesión
        $data = [
            'ID_USUARIO'   => $this->session->get('ID_USUARIO'),
            'NOMBRE_USUARIO' => $this->session->get('NOMBRE_USUARIO'),
            'EMAIL_USUARIO'  => $this->session->get('EMAIL_USUARIO'),
            'ROL_ID_ROL'   => $this->session->get('ROL_ID_ROL'),
            'rol_nombre'   => 'Vendedor', // Aquí ya sabemos que es vendedor
        ];

        // Cargar la vista del dashboard del vendedor
        return view('DashBoardVendedor', $data);
    }


    // Vamos a redireccionar a panel 
    public function panelDashboard()
    {
        // Verificar si el usuario está logueado y si su rol es Vendedor (ROL_ID_ROL = 2)
        if (!$this->session->get('isLoggedIn') || $this->session->get('ROL_ID_ROL') != 2) {
            return redirect()->to(base_url('login'))->with('error_message', 'Acceso no autorizado para este rol.');
        }

        // Obtener datos del usuario de la sesión
        $data = [
            'ID_USUARIO'   => $this->session->get('ID_USUARIO'),
            'NOMBRE_USUARIO' => $this->session->get('NOMBRE_USUARIO'),
            'EMAIL_USUARIO'  => $this->session->get('EMAIL_USUARIO'),
            'ROL_ID_ROL'   => $this->session->get('ROL_ID_ROL'),
            'rol_nombre'   => 'Vendedor',
            'title'        => 'Inicio - Panel Proveedor' // Título específico para esta vista
        ];

        // Cargar la vista específica del panel del vendedor
        return view('Panel', $data);
    }

    // Añadir producto vista

    public function addProduct()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('ROL_ID_ROL') != 2) {
            return redirect()->to(base_url('login'))->with('error_message', 'Acceso no autorizado.');
        }
        $data = [
            'ID_USUARIO'   => $this->session->get('ID_USUARIO'),
            'NOMBRE_USUARIO' => $this->session->get('NOMBRE_USUARIO'),
            'EMAIL_USUARIO'  => $this->session->get('EMAIL_USUARIO'),
            'ROL_ID_ROL'   => $this->session->get('ROL_ID_ROL'),
            'rol_nombre'   => 'Vendedor',
            'title'        => 'Agregar Producto - Panel Proveedor' // Título para esta vista
        ];
        // --- CAMBIO CLAVE AQUÍ: Cargar la vista AddProduct.php ---
        return view('AddProduc', $data); 
    }


    // --- NUEVO MÉTODO PARA PROCESAR EL FORMULARIO DE AGREGAR PRODUCTO ---
    public function addProductProcess()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('ROL_ID_ROL') != 2) {
            return redirect()->to(base_url('login'))->with('error_message', 'Acceso no autorizado.');
        }

        $validationRules = [
            'nombre'       => 'required|max_length[45]',
            'marca'        => 'required|max_length[15]',
            'cantidad'     => 'required|integer|greater_than_equal_to[0]',
            'precio_venta' => 'required|numeric|greater_than[0]',
            'categoria'    => 'required|max_length[50]',
            'subcategoria' => 'required|max_length[70]',
            'imagen'       => 'uploaded[imagen]|max_size[imagen,2048]|ext_in[imagen,jpg,jpeg,png,gif]',
        ];

        $validationMessages = [
            'nombre' => ['required' => 'El nombre del producto es obligatorio.'],
            'marca'  => ['required' => 'La marca es obligatoria.'],
            'cantidad' => [
                'required'             => 'La cantidad es obligatoria.',
                'integer'              => 'La cantidad debe ser un número entero.',
                'greater_than_equal_to' => 'La cantidad no puede ser negativa.'
            ],
            'precio_venta' => [
                'required'        => 'El precio de venta es obligatorio.',
                'numeric'         => 'El precio de venta debe ser un número.',
                'greater_than'    => 'El precio de venta debe ser mayor que cero.'
            ],
            'categoria' => ['required' => 'La categoría es obligatoria.'],
            'subcategoria' => ['required' => 'La subcategoría es obligatoria.'],
            'imagen' => [
                'uploaded' => 'Debes subir al menos una imagen para el producto.',
                'max_size' => 'El tamaño de la imagen no debe exceder 2MB.',
                'ext_in'   => 'Solo se permiten imágenes JPG, JPEG, PNG y GIF.'
            ]
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $files = $this->request->getFiles();
        $imageNames = []; 

        if ($files && isset($files['imagen'])) {
            foreach ($files['imagen'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName(); 
                    $uploadPath = ROOTPATH . 'public/uploads/products/'; 

                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    if ($file->move($uploadPath, $newName)) {
                        $imageNames[] = $newName;
                    } else {
                        log_message('error', 'Error al mover el archivo de imagen: ' . $file->getErrorString());
                        session()->setFlashdata('error', 'Error al subir una de las imágenes: ' . $file->getErrorString());
                        return redirect()->back()->withInput();
                    }
                } else {
                    log_message('error', 'Archivo de imagen no válido o ya movido: ' . $file->getErrorString());
                    session()->setFlashdata('error', 'Una de las imágenes no es válida o ya fue procesada.');
                    return redirect()->back()->withInput();
                }
            }
        }

        $productData = [
            'NOMBRE'       => $this->request->getPost('nombre'),
            'DESCRIPCION'  => $this->request->getPost('descripcion'),
            'MARCA'        => $this->request->getPost('marca'),
            'IMAGEN'       => implode(',', $imageNames), 
            'TALLA'        => $this->request->getPost('talla') ?: 'No aplica', 
            'LOTE'         => $this->request->getPost('lote'),
            'CANTIDAD'     => $this->request->getPost('cantidad'),
            'PRECIO'       => $this->request->getPost('precio_venta'),
            'CATEGORIA'    => $this->request->getPost('categoria'),
            'SUBCATEGORIA' => $this->request->getPost('subcategoria'),
            'ID_USUARIO'   => $this->session->get('ID_USUARIO'),
        ];

        try {
            if ($this->productModel->insert($productData)) {
                session()->setFlashdata('success', 'Producto guardado correctamente.');
                return redirect()->to(base_url('vendor/add-product')); 
            } else {
                // --- CORRECCIÓN CLAVE AQUÍ: Acceder a errors() en minúscula ---
                log_message('error', 'Error al insertar producto en DB: ' . json_encode($this->productModel->errors()));
                session()->setFlashdata('error', 'Error al guardar el producto en la base de datos.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            log_message('error', 'Excepción al guardar producto: ' . $e->getMessage());
            session()->setFlashdata('error', 'Ocurrió un error inesperado al guardar el producto.');
            return redirect()->back()->withInput();
        }
    }

    // Proceso para Editar un producto
    public function editProduct()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('ROL_ID_ROL') != 2) {
            return redirect()->to(base_url('login'))->with('error_message', 'Acceso no autorizado.');
        }

        $id_proveedor = $this->session->get('ID_USUARIO'); // Asumiendo que el ID del vendedor está en la sesión
        
        // Obtener solo los productos del vendedor logueado
        // Asegúrate de que tu tabla 'PRODUCTO' tenga una columna para el ID del vendedor, por ejemplo 'ID_VENDEDOR'
        $productos = $this->productModel->where('ID_USUARIO', $id_proveedor)->findAll(); 

        $data = [
            'ID_USUARIO'   => $this->session->get('ID_USUARIO'),
            'NOMBRE_USUARIO' => $this->session->get('NOMBRE_USUARIO'),
            'EMAIL_USUARIO'  => $this->session->get('EMAIL_USUARIO'),
            'ROL_ID_ROL'   => $this->session->get('ROL_ID_ROL'),
            'rol_nombre'   => 'Vendedor',
            'title'        => 'Editar Producto - Panel Proveedor',
            'productos'    => $productos // Pasa los productos a la vista
        ];
        return view('EditProduct', $data); 
    }
}