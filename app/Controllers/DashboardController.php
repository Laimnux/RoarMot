<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class DashboardController extends BaseController
{
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Verificar si el usuario está logueado
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error_message', 'Debes iniciar sesión para acceder al dashboard.');
        }

        // Obtener datos del usuario de la sesión
        $data = [
            'ID_USUARIO'   => $this->session->get('ID_USUARIO'),
            'NOMBRE_USUARIO' => $this->session->get('NOMBRE_USUARIO'),
            'EMAIL_USUARIO'  => $this->session->get('EMAIL_USUARIO'),
            'ROL_ID_ROL'   => $this->session->get('ROL_ID_ROL'),
            'rol_nombre'   => ($this->session->get('ROL_ID_ROL') == 1) ? 'Motero' : 'Vendedor', // Asumiendo 1=Motero, 2=Vendedor
        ];
        
        return view('Dashboard', $data);
    }
}