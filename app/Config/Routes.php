<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Absensi::index');

//absensi
$routes->get('/absensi', 'Absensi::index');
$routes->post('/absensi/(:any)', 'Absensi::$1');

//login admin
$routes->get('/login', 'Login::index');
$routes->post('/login/(:any)', 'Login::$1');
$routes->get('/login/(:any)', 'Login::$1');

//dashboard
$routes->get('/dashboard', 'Dashboard::index');

//pegawai
$routes->get('/pegawai', 'Pegawai::index');
$routes->post('/pegawai/(:any)', 'Pegawai::$1');
$routes->get('/pegawai/(:any)', 'Pegawai::$1');

//gaji
$routes->get('/gaji', 'Gaji::index');
$routes->post('/gaji/(:any)', 'Gaji::$1');
$routes->get('/gaji/(:any)', 'Gaji::$1');

//jam kerja
$routes->get('/jamkerja', 'JamKerja::index');
$routes->post('/jamkerja/(:any)', 'JamKerja::$1');
$routes->get('/jamkerja/(:any)', 'JamKerja::$1');

//laporan absensi
$routes->get('/lapabsensi', 'LapAbsensi::index');
$routes->post('/lapabsensi/(:any)', 'LapAbsensi::$1');
$routes->get('/lapabsensi/(:any)', 'LapAbsensi::$1');

//identitas
$routes->get('/identitas', 'Identitas::index');
$routes->post('/identitas/(:any)', 'Identitas::$1');
$routes->get('/identitas/(:any)', 'Identitas::$1');