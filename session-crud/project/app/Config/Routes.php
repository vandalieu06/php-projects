<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Protected routes (require login)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Main::index');
    $routes->get('/insertarEquip', 'Main::insertarEquip');
    $routes->post('/insertarEquip', 'Main::insertarEquip');
    $routes->get('/mostrarEquips', 'Main::mostrarEquips');
    $routes->get('/eliminarEquip', 'Main::eliminarEquip');
    $routes->post('/eliminarEquip', 'Main::eliminarEquip');
    $routes->get('/insertarJugador', 'Main::insertarJugador');
    $routes->post('/insertarJugador', 'Main::insertarJugador');
    $routes->get('/mostrarJugadors', 'Main::mostrarJugadors');
    $routes->get('/eliminarJugador', 'Main::eliminarJugador');
    $routes->post('/eliminarJugador', 'Main::eliminarJugador');
    $routes->get('/senseModel', 'Main::senseModel');
    $routes->get('/mostrarFoto/(:any)', 'Main::mostrarFoto/$1');
});

// Public routes (no login required)
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/testdb', 'TestDb::index');