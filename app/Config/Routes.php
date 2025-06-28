<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Esta ruta conecta con la pagina inicio
$routes->get('/inicioPagina', 'Home::index');
// Conectamos a la ruta de iniciarSesion
$routes->get('iniciarSesion', 'Home::inicioSesion');


