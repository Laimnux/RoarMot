<?php

// En este controller AuthController maneja la autenticación (registro, inicio y cierre de sesión)
namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class AuthController extends BaseController
{
    protected $usuarioModel;
    protected $request;
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->usuarioModel = new UsuarioModel();
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
    }

    public function registroPaso1()
    {
        $data = [];
        if ($this->session->getFlashdata('validation')) {
            $data['validation'] = $this->session->getFlashdata('validation');
        }
        return view('RegistroPasoOne', $data);
    }

    public function procesarPaso1()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[USUARIO.CORREO_USUARIO]',
            'rol'   => 'required|in_list[comprador,vendedor]',
        ];
        $messages = [
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, ingresa un formato de correo electrónico válido.',
                'is_unique'   => 'Este correo electrónico ya está registrado.'
            ],
            'rol' => [
                'required' => 'Debes seleccionar un rol.',
                'in_list'  => 'El rol seleccionado no es válido.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            $this->session->setFlashdata('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        $email = $this->request->getPost('email');
        $rol   = $this->request->getPost('rol');

        $codigoVerificacion = mt_rand(100000, 999999);
        $this->session->setFlashdata('codigo_verificacion', $codigoVerificacion);
        
        $this->session->set('email_registro_persistente', $email); 
        $this->session->set('rol_registro_persistente', $rol);    

        log_message('debug', 'Código de verificación generado para ' . $email . ': ' . $codigoVerificacion);

        return redirect()->to(base_url('registro/paso2'));
    }

    public function registroPaso2()
    {
        $email = $this->session->get('email_registro_persistente');
        $rol   = $this->session->get('rol_registro_persistente');

        if (empty($email) || empty($rol)) {
            return redirect()->to(base_url('registro/paso1'))
                             ->with('error_message', 'Acceso no autorizado al Paso 2. Por favor, comienza desde el Paso 1.');
        }

        $this->session->setFlashdata('codigo_verificacion', $this->session->getFlashdata('codigo_verificacion'));

        $data = [
            'email' => $email,
            'rol'   => $rol,
            'validation' => $this->session->getFlashdata('validation') ?? null
        ];

        return view('RegistroPasoTwo', $data);
    }

    public function validarCodigo()
    {
        $codigoIngresado = $this->request->getPost('codigo');
        $codigoCorrecto  = $this->session->getFlashdata('codigo_verificacion');
        
        $email           = $this->session->get('email_registro_persistente');
        $rol             = $this->session->get('rol_registro_persistente');

        $this->session->setFlashdata('codigo_verificacion', $codigoCorrecto); 

        $rules = [
            'codigo' => [
                'rules' => 'required|exact_length[6]|is_natural_no_zero',
                'errors' => [
                    'required'            => 'El código es obligatorio.',
                    'exact_length'        => 'El código debe tener exactamente 6 dígitos.',
                    'is_natural_no_zero' => 'El código debe contener solo números.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('validation', $this->validator);
            return redirect()->back()->withInput()
                             ->with('error_message', 'Por favor, corrige los errores en el código.');
        }

        if ($codigoIngresado === (string)$codigoCorrecto) {
            return redirect()->to(base_url('registro/paso3'))
                             ->with('success_message', 'Código validado correctamente. Por favor, completa tu registro.');
        } else {
            return redirect()->back()
                             ->withInput()
                             ->with('error_message', 'El código ingresado es incorrecto. Por favor, intenta nuevamente.');
        }
    }

    public function reenviarCodigo()
    {
        if (!$this->request->isAJAX() || !$this->request->is('post')) {
            return $this->response->setStatusCode(405)->setJSON(['success' => false, 'message' => 'Método no permitido.']);
        }

        $input = $this->request->getJSON(true);
        $email = $input['email'] ?? null;

        if (empty($email)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email no proporcionado para reenviar.']);
        }

        $rol = $this->session->get('rol_registro_persistente'); 

        $nuevoCodigo = mt_rand(100000, 999999);
        $this->session->setFlashdata('codigo_verificacion', $nuevoCodigo);

        log_message('debug', 'Nuevo código de verificación reenviado para ' . $email . ': ' . $nuevoCodigo);

        return $this->response->setJSON(['success' => true, 'message' => 'Nuevo código enviado con éxito.']);
    }

    public function registroPaso3()
    {
        $email = $this->session->get('email_registro_persistente');
        $rol   = $this->session->get('rol_registro_persistente');

        if (empty($email) || empty($rol)) {
            return redirect()->to(base_url('registro/paso1'))
                             ->with('error_message', 'Acceso no autorizado al Paso 3. Por favor, comienza desde el Paso 1.');
        }
        
        $data = [
            'email' => $email,
            'rol'   => $rol,
            'validation' => $this->session->getFlashdata('validation') ?? null
        ];

        return view('RegistroPasoTres', $data);
    }

    public function completeRegistro()
    {
        $email = $this->session->get('email_registro_persistente');
        $rol   = $this->session->get('rol_registro_persistente');

        if (empty($email) || empty($rol)) {
            return redirect()->to(base_url('registro/paso1'))
                             ->with('error_message', 'Error: Datos de registro incompletos. Por favor, comienza desde el Paso 1.');
        }

        $rules = [
            'nombre'             => 'required|alpha_space|max_length[45]',
            'apellido'           => 'required|alpha_space|max_length[45]',
            'telefono'           => 'required|numeric|exact_length[10]',
            'password'           => 'required|min_length[8]',
            'confirm_password'   => 'required_with[password]|matches[password]',
            'email'              => 'required|valid_email',
            'rol'                => 'required|in_list[comprador,vendedor]',
            'terminos'           => 'required',
        ];

        if ($rol === 'vendedor') {
            $rules['nombre_empresa'] = 'required|alpha_numeric_space|max_length[100]';
        }

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
            'password' => [
                'required'    => 'La contraseña es obligatoria.',
                'min_length'  => 'La contraseña debe tener al menos 8 caracteres.',
            ],
            'confirm_password' => [
                'required_with' => 'Debes confirmar la contraseña.',
                'matches'       => 'Las contraseñas no coinciden.',
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, ingresa un correo electrónico válido.',
            ],
            'rol' => [
                'required' => 'El rol es obligatorio.',
                'in_list'  => 'El rol seleccionado no es válido.',
            ],
            'terminos' => [
                'required' => 'Debes aceptar los términos y condiciones.',
            ],
            'nombre_empresa' => [
                'required'            => 'El nombre de la empresa es obligatorio para vendedores.',
                'alpha_numeric_space' => 'El nombre de la empresa solo puede contener letras, números y espacios.',
                'max_length'          => 'El nombre de la empresa no puede exceder los 100 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            $this->session->setFlashdata('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        $rolMapping = [
            'comprador' => 1,
            'vendedor'  => 2
        ];
        $rolId = $rolMapping[$rol];

        $userDataToInsert = [
            'CORREO_USUARIO'   => $email,
            'CONTRASENA'       => $this->request->getPost('password'),
            'NOMBRE_USUARIO'   => $this->request->getPost('nombre'),
            'APELLIDO_USUARIO' => $this->request->getPost('apellido'),
            'TEL_USUARIO'      => $this->request->getPost('telefono'),
            'ROL_ID_ROL'       => $rolId,
            'ESTADO_USUARIO'   => 'Activo',
            'FECHA_CREACION'   => date('Y-m-d H:i:s'), // --- CAMBIO CLAVE: Añadir FECHA_CREACION manualmente ---
        ];
        
        if ($rol === 'vendedor') {
            $userDataToInsert['NOMBRE_EMPRESA'] = $this->request->getPost('nombre_empresa');
        }

        // --- ELIMINAR LÍNEA DE DEPURACIÓN dd($sql); ---
        // La línea dd($sql); ya no es necesaria aquí y causaría que la inserción no se ejecute.

        if ($this->usuarioModel->insert($userDataToInsert)) {
            $this->session->remove('email_registro_persistente');
            $this->session->remove('rol_registro_persistente');
            $this->session->remove('codigo_verificacion'); 

            return redirect()->to(base_url('iniciarSesion'))->with('success_message', '¡Registro completado con éxito! Ahora puedes iniciar sesión.');
        } else {
            // Si falla la inserción en la DB, mostrar errores detallados
            log_message('error', 'Error al insertar usuario en completeRegistro: ' . json_encode($this->usuarioModel->errors()));
            log_message('error', 'Error de DB: ' . json_encode($this->usuarioModel->db()->error()));
            // Aquí puedes descomentar dd($this->usuarioModel->db()->getLastQuery()); si aún necesitas ver la consulta en caso de fallo.
            return redirect()->back()->withInput()->with('error_message', 'Hubo un error al completar tu registro. Por favor, inténtalo de nuevo.');
        }
    }

    public function login()
    {
        return view('Login');
    }

    public function loginProcess()
    {
        $rules = [
            'email' => 'required|valid_email',
            'contrasena' => 'required|min_length[8]',
        ];

        $messages = [
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, ingresa un correo electrónico válido.',
            ],
            'contrasena' => [
                'required'    => 'La contraseña es obligatoria.',
                'min_length'  => 'La contraseña debe tener al menos 8 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('contrasena');

        $user = $this->usuarioModel->where('CORREO_USUARIO', $email)->first();

        if ($user) {
            if (password_verify($password, $user['CONTRASENA'])) {
                //dd($user); // <--- AÑADE ESTA LÍNEA AQUÍ hacemos debug para verificar los datos que estamos enviando de la base  de datos 
                $sessionData = [
                    'ID_USUARIO'   => $user['ID_USUARIO'],
                    'NOMBRE_USUARIO' => $user['NOMBRE_USUARIO'],
                    'EMAIL_USUARIO'  => $user['CORREO_USUARIO'],
                    'ROL_ID_ROL'   => $user['ROL_ID_ROL'],
                    'isLoggedIn'     => true,
                ];
                $this->session->set($sessionData);

                // --- CAMBIO CLAVE AQUÍ: Redirección condicional por rol ---
                if ($user['ROL_ID_ROL'] == 1) { // Rol de Motero/Comprador
                    return redirect()->to(base_url('DashBoard/dashboard'))->with('success_message', '¡Has iniciado sesión como Motero!');
                } elseif ($user['ROL_ID_ROL'] == 2) { // Rol de Vendedor
                    return redirect()->to(base_url('dashBoardVendedor'))->with('success_message', '¡Has iniciado sesión como Vendedor!');
                } else {
                    // Rol desconocido, redirigir a un lugar por defecto o mostrar error
                    return redirect()->to(base_url('login'))->with('error_message', 'Rol de usuario desconocido. Por favor, contacta al soporte.');
                }
                // --- FIN CAMBIO CLAVE ---

            } else {
                return redirect()->back()->withInput()->with('error_message', 'Correo electrónico o contraseña incorrectos.');
            }
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Correo electrónico o contraseña incorrectos.');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('/inicioPagina'))->with('success_message', 'Has cerrado sesión.');
    }
}