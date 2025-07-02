<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Esta ruta conecta con la pagina inicio
$routes->get('/inicioPagina', 'Home::index');

// Conectamos a la ruta de iniciarSesion
$routes->get('iniciarSesion', 'Home::inicioSesion');

//conectamos al botón Registrate 
$routes->get('RegistroPasoOne', 'Home::registroPaso1');

//---------------------------------------------------------------------------------------------------

// Ruta para mostrar el formulario de inicio de sesión
$routes->get('iniciarSesion', 'AuthController::login'); // Cambiado para usar AuthController::login

// Ruta para procesar el formulario de inicio de sesión (POST)
$routes->post('auth/loginProcess', 'AuthController::loginProcess');

// Ruta para cerrar sesión
$routes->get('auth/logout', 'AuthController::logout');

//---------------------------------------------------------------------------------------------------

// Ruta para mostrar el formulario de registro paso 1
$routes->get('registro', 'AuthController::registerStep1');

// Ruta para procesar el formulario de registro paso 1 (POST)
$routes->post('registro/paso1', 'AuthController::registerProcessStep1');

// ... tus rutas de registro ...


