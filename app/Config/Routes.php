<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Esta ruta conecta con la pagina inicio
$routes->get('/inicioPagina', 'Home::index');

// ---------------------------------Rutas Registro Inicio sesion--------------------------------------------
// Rutas para el proceso de registro (agrupadas bajo el prefijo 'registro')
// Todas las URLs de registro comenzarán con /registro/...
$routes->group('registro', function ($routes) {

    // Paso 1: Mostrar el formulario de email y selección de rol
    // Acceso: http://localhost/RoarMot/public/registro/paso1
    $routes->get('paso1', 'AuthController::registroPaso1');

    // Procesar el formulario del Paso 1 (método POST)
    // Acceso: http://localhost/RoarMot/public/registro/procesarPaso1
    $routes->post('procesarPaso1', 'AuthController::procesarPaso1');

    // Paso 2: Mostrar el formulario de validación de código (método GET)
    // Acceso: http://localhost/RoarMot/public/registro/paso2
    $routes->get('paso2', 'AuthController::registroPaso2');

    // Procesar la validación del código del Paso 2 (método POST)
    // Acceso: http://localhost/RoarMot/public/registro/validarCodigo
    $routes->post('validarCodigo', 'AuthController::validarCodigo');

    // Ruta para reenviar el código (usada por AJAX en la vista del Paso 2)
    // Acceso: POST a http://localhost/RoarMot/public/registro/reenviar-codigo
    $routes->post('reenviar-codigo', 'AuthController::reenviarCodigo');

    // Paso 3: Mostrar el formulario de datos personales y contraseña (método GET)
    // Acceso: http://localhost/RoarMot/public/registro/paso3
    $routes->get('paso3', 'AuthController::registroPaso3');

    // Procesar el formulario final del registro (Paso 3) (método POST)
    // Acceso: http://localhost/RoarMot/public/registro/completar
    $routes->post('completar', 'AuthController::completeRegistro');
});


// Una ruta para dirigirnos a Login o inicio de sessión
$routes->get('iniciarSesion','AuthController::login');

// Una ruta para el ProcesoLogin Http post
$routes->post('procesoLogin','AuthController::loginProcess');


// Una ruta adicional para simplificar el acceso al inicio del registro si solo ponen /registro
$routes->get('registro', 'AuthController::registroPaso1');

// Cierre sesion
$routes->get('cerrarSesion','AuthController::logout');


// ---------------------------------Rutas DashBoard --------------------------------------------

$routes->group('DashBoard', function($routes) {

    // Mostrar el dashboard 
    $routes->get('dashboard','DashBoardController::index');

    // Ruta para traer la información form datos básicos moto

});
// ------------------------------- Rutas DashBoard Vendedor ------------------------------------

$routes->get('dashBoardVendedor','DashBoardControllerVen::index');

// --- RUTAS PARA EL DASHBOARD DEL VENDEDOR ---
$routes->group('panel', function($routes) {
    $routes->get('panelInicio', 'DashBoardControllerVen::panelDashboard'); // Ruta principal del panel
    $routes->get('addProduct', 'DashboardControllerVen::addProduct'); // Ruta para AñadirProducto
    // --- NUEVA RUTA PARA PROCESAR EL FORMULARIO ---
    $routes->post('ProductProcess', 'DashboardControllerVen::addProductProcess'); // Método Post para almacenar datos agregado en el form añadir produto

    // Ruta para vista EditProdut
    $routes->get('editarProduct', 'DashboardControllerVen::editProduct');
    // ---  RUTAS POST PARA PROCESAR EDICIÓN Y ELIMINACIÓN ---
    $routes->post('editProductProceso', 'DashboardControllerVen::editProductProcess'); 
    $routes->post('deleteProductProceso', 'DashboardControllerVen::deleteProductProcess'); 

    // Descargamos exel
    $routes->get('descargarExcel', 'DashboardControllerVen::descargarProductosExcel');

    //$routes->get('edit-product', 'SellerDashboardController::editProduct');
    //$routes->get('orders', 'SellerDashboardController::orders');
    //$routes->get('profile', 'SellerDashboardController::profile');
});
