<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Siswa::index');

// Routes untuk CRUD Siswa
$routes->get('/siswa', 'Siswa::index');
$routes->get('/siswa/create', 'Siswa::create');
$routes->post('/siswa/store', 'Siswa::store');
$routes->get('/siswa/detail/(:num)', 'Siswa::detail/$1');
$routes->get('/siswa/edit/(:num)', 'Siswa::edit/$1');
$routes->post('/siswa/update/(:num)', 'Siswa::update/$1');
$routes->get('/siswa/delete/(:num)', 'Siswa::delete/$1');

// Routes untuk tabungan
$routes->post('/siswa/setor/(:num)', 'Siswa::setorTabungan/$1');
$routes->post('/siswa/tarik/(:num)', 'Siswa::tarikTabungan/$1');
$routes->get('/siswa/riwayat/(:num)', 'Siswa::riwayatTabungan/$1');
