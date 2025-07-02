<?php

/**
 * Este controlador AuthController manejará toda la lógica de los pasos de registro 
 * (Validaciones, guardar detos)
 */

namespace App\Controllers;

use App\Models\UsuarioModel; // Importa tu modelo de usuario
use CodeIgniter\Controller;

class AuthController extends Controller
{
    // Propiedad para almacenar el modelo de usuario
    protected $usuarioModel;

    // Constructor para inicializar el modelo
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // Método para mostrar el Paso 1 del registro (ingreso de correo)
    public function registerStep1()
    {
        // Carga la vista del Paso 1
        return view('registro');
    }

    // Método para manejar la validación del correo y pasar al Paso 2
    public function registerProcessStep1()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[usuario.CORREO_USUARIO]',
        ];

        $messages = [
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, ingresa un correo electrónico válido.',
                'is_unique'   => 'Este correo electrónico ya está registrado. Por favor, inicia sesión o usa otro correo.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            // Si la validación falla, redirige de nuevo al Paso 1 con los errores
            return view('registro', [
                'validation' => $this->validator,
                'oldInput'   => $this->request->getPost(), // Mantener los datos ingresados
            ]);
        }

        // Si el correo es válido y único, pasamos al Paso 2
        // Puedes pasar el correo en la sesión o en la URL (query string)
        $email = $this->request->getPost('email');
        
        // Redirige al Paso 2, pasando el email como parámetro en la URL
        // o si prefieres, puedes usar la sesión para datos sensibles.
        return redirect()->to(base_url('registro-paso2') . '?email=' . urlencode($email));
    }

    // Método para mostrar el Paso 2 del registro (selección de rol)
    public function registerStep2()
    {
        // Obtiene el email de la URL (o sesión)
        $email = $this->request->getGet('email'); 

        // Puedes añadir una validación aquí para asegurar que el email existe en la sesión/URL y es válido
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to(base_url('registro'))->with('error', 'Falta el correo electrónico para el registro.');
        }

        return view('registro-paso2', ['email' => $email]);
    }

    // Método para manejar la selección de rol y pasar al Paso 3
    public function registerProcessStep2()
    {
        $rules = [
            'email' => 'required|valid_email', // Revalidar el email por seguridad
            'rol'   => 'required|in_list[comprador,vendedor]', // Asegura que el rol es válido
        ];

        $messages = [
            'rol' => [
                'required'  => 'Debes seleccionar un rol (comprador o vendedor).',
                'in_list'   => 'El rol seleccionado no es válido.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            // Si la validación falla, redirige de nuevo al Paso 2 con los errores
            // Aquí hay que tener cuidado de no perder el email
            $email = $this->request->getPost('email');
            return view('registro-paso2', [
                'validation' => $this->validator,
                'email'      => $email,
                'oldInput'   => $this->request->getPost(),
            ]);
        }

        $email = $this->request->getPost('email');
        $rol   = $this->request->getPost('rol');

        // Redirige al Paso 3, pasando el email y el rol
        return redirect()->to(base_url('registro-paso3') . '?email=' . urlencode($email) . '&rol=' . urlencode($rol));
    }


    // Método para mostrar el Paso 3 del registro (datos personales y contraseña)
    public function registerStep3()
    {
        // Obtiene el email y el rol de la URL (o sesión)
        $email = $this->request->getGet('email');
        $rol   = $this->request->getGet('rol');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($rol)) {
            return redirect()->to(base_url('registro'))->with('error', 'Falta información para completar el registro.');
        }
        
        return view('registro-paso3', ['email' => $email, 'rol' => $rol]);
    }

    // Método para manejar el envío del formulario del Paso 3 y guardar en la BD
    public function completeRegistration()
    {
        $rules = [
            'nombre'         => 'required|alpha_space|max_length[45]',
            'apellido'       => 'required|alpha_space|max_length[45]',
            'telefono'       => 'required|numeric|exact_length[10]', // Asumiendo 10 dígitos
            'contrasena'     => 'required|min_length[8]',
            'confirm_contrasena' => 'required_with[contrasena]|matches[contrasena]', // Para confirmar contraseña
            'email'          => 'required|valid_email', // Revalidar siempre el email por seguridad
            'rol'            => 'required|in_list[comprador,vendedor]', // Revalidar el rol
            'terminos'       => 'required', // Campo para aceptar términos
        ];

        $messages = [
            'nombre' => [
                'required'    => 'El nombre es obligatorio.',
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
                'max_length'  => 'El nombre no puede exceder los 45 caracteres.',
            ],
            'apellido' => [
                'required'    => 'El apellido es obligatorio.',
                'alpha_space' => 'El apellido solo puede contener letras y espacios.',
                'max_length'  => 'El apellido no puede exceder los 45 caracteres.',
            ],
            'telefono' => [
                'required'     => 'El teléfono es obligatorio.',
                'numeric'      => 'El teléfono solo puede contener números.',
                'exact_length' => 'El teléfono debe tener exactamente 10 dígitos.',
            ],
            'contrasena' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
            ],
            'confirm_contrasena' => [
                'required_with' => 'Debes confirmar la contraseña.',
                'matches'       => 'Las contraseñas no coinciden.',
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, ingresa un correo electrónico válido.',
            ],
            'rol' => [
                'required'  => 'El rol es obligatorio.',
                'in_list'   => 'El rol seleccionado no es válido.',
            ],
            'terminos' => [
                'required' => 'Debes aceptar los términos y condiciones.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            // Si la validación falla, redirige de nuevo al Paso 3 con los errores
            $email = $this->request->getPost('email');
            $rol = $this->request->getPost('rol');
            return view('registro-paso3', [
                'validation' => $this->validator,
                'email'      => $email,
                'rol'        => $rol,
                'oldInput'   => $this->request->getPost(),
            ]);
        }

        // Mapear el rol de texto a ID si tu tabla ROL_ID_ROL espera un INT
        // Suponiendo: comprador = 1, vendedor = 2.
        $rolMapping = [
            'comprador' => 1, 
            'vendedor'  => 2
        ];
        $rolId = $rolMapping[$this->request->getPost('rol')];


        // Preparar los datos para insertar en la base de datos
        $data = [
            'CORREO_USUARIO'   => $this->request->getPost('email'),
            'CONTRASEÑA'       => $this->request->getPost('contrasena'), // El modelo lo hasheará
            'NOMBRE_USUARIO'   => $this->request->getPost('nombre'),
            'APELLIDO_USUARIO' => $this->request->getPost('apellido'),
            'TEL_USUARIO'      => $this->request->getPost('telefono'),
            'ROL_ID_ROL'       => $rolId, // Usamos el ID mapeado
            'ESTADO_USUARIO'   => 'Activo', // Valor por defecto
            // TIPO_DOCUMENTO y NUMERO_USUARIO se insertarán como NULL porque son NULLABLE ahora y no los pedimos.
            // FECHA_CREACION se auto-llenará por la DB.
        ];

        // Intentar guardar el usuario
        if ($this->usuarioModel->insert($data)) {
            // Registro exitoso, redirigir al dashboard o página de éxito
            return redirect()->to(base_url('dashboard'))->with('success', '¡Registro completado con éxito! Ahora puedes iniciar sesión.');
        } else {
            // Error al guardar, redirigir de nuevo al Paso 3 con un mensaje de error
            return redirect()->to(base_url('registro-paso3') . '?email=' . urlencode($this->request->getPost('email')) . '&rol=' . urlencode($this->request->getPost('rol')))->with('error', 'Hubo un error al registrar el usuario. Por favor, inténtalo de nuevo.');
        }
    }

    //método para mostrar la vista de inicio de sesión
    public function login()
    {
        return view('inicioSesion'); // Asegúrate que 'inicioSesion' sea el nombre correcto de tu vista .php
    }

    // Nuevo método para procesar el intento de inicio de sesión
    public function loginProcess()
    {
        $rules = [
            'email' => 'required|valid_email',
            'contrasena' => 'required|min_length[8]', // Asegúrate que 'contrasena' coincida con el atributo 'name' del input
        ];

        $messages = [
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, ingresa un correo electrónico válido.',
            ],
            'contrasena' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            // Si la validación falla, redirige de nuevo a la vista de login con los errores
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('contrasena');

        // Buscar al usuario por email en la base de datos
        $user = $this->usuarioModel->where('CORREO_USUARIO', $email)->first();

        if ($user) {
            // Verificar la contraseña hasheada
            if (password_verify($password, $user['CONTRASEÑA'])) {
                // Contraseña correcta, iniciar sesión
                $session = session();
                $sessionData = [
                    'ID_USUARIO'   => $user['ID_USUARIO'],
                    'NOMBRE_USUARIO' => $user['NOMBRE_USUARIO'],
                    'EMAIL_USUARIO'  => $user['CORREO_USUARIO'],
                    'ROL_ID_ROL'   => $user['ROL_ID_ROL'], // Guarda el rol
                    'isLoggedIn'     => true,
                ];
                $session->set($sessionData);

                // Redirigir al dashboard o a la página de inicio
                return redirect()->to(base_url('dashboard'))->with('success', '¡Has iniciado sesión con éxito!');

            } else {
                // Contraseña incorrecta
                return redirect()->back()->withInput()->with('error', 'Correo electrónico o contraseña incorrectos.');
            }
        } else {
            // Usuario no encontrado
            return redirect()->back()->withInput()->with('error', 'Correo electrónico o contraseña incorrectos.');
        }
    }

    // Método para cerrar sesión
    public function logout()
    {
        $session = session();
        $session->destroy(); // Elimina todos los datos de la sesión
        return redirect()->to(base_url('iniciarSesion'))->with('success', 'Has cerrado sesión.');
    }

    // Otros métodos de autenticación (login, logout) irán aquí más adelante


}