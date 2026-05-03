<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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
$routes->get('/testdb', 'TestDb::index');