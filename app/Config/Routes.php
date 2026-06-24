<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- ROUTE PUBLIK (Bisa diakses tanpa login) ---
$routes->get('/', 'HomeController::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/loginProcess', 'AuthController::loginProcess');
$routes->get('/register', 'AuthController::register');
$routes->post('/registerProcess', 'AuthController::registerProcess');

// --- WEBSERVICE SERVER (API Endpoint - Point 6) ---
$routes->get('/api/kuliner', 'ApiController::kuliner');
$routes->get('/api/kuliner/(:num)', 'ApiController::detail/$1');
$routes->get('/api/kategori', 'ApiController::kategori');

// --- ROUTE TERPROTEKSI (Wajib login) ---
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'AdminController::dashboard');
    $routes->get('/admin', 'AdminController::index');
    $routes->get('/logout', 'AuthController::logout');
    
    // 1. CREATE (Menampilkan form & Memproses simpan)
    $routes->get('/tambah-kuliner', 'AdminController::create');
    $routes->post('/simpan-kuliner', 'AdminController::store');

    // 2. UPDATE (Menampilkan form edit & Memproses update)
    // Parameter (:num) berguna untuk menangkap ID tempat kuliner yang diklik
    $routes->get('/edit-kuliner/(:num)', 'AdminController::edit/$1');
    $routes->post('/update-kuliner/(:num)', 'AdminController::update/$1');

    // 3. DELETE (Memproses hapus data)
    $routes->get('/hapus-kuliner/(:num)', 'AdminController::delete/$1');

    // 4. APPROVE (Opsional untuk fitur verifikasi admin)
    $routes->get('/approve-kuliner/(:num)', 'AdminController::approve/$1');
});