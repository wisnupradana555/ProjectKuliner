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

// --- ROUTE TERPROTEKSI (Wajib login) ---
// Kita bungkus menggunakan filter 'auth'
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'AdminController::index');
    $routes->get('/logout', 'AuthController::logout');
    // Untuk menampilkan halaman form
    $routes->get('/tambah-kuliner', 'AdminController::create');
    // Untuk memproses data yang dikirim dari form
    $routes->post('/simpan-kuliner', 'AdminController::store');
});