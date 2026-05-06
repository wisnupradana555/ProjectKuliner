<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- ROUTE PUBLIK (Bisa diakses tanpa login) ---
$routes->get('/', 'AuthController::login'); // Jadikan halaman login sebagai halaman utama dulu
$routes->get('/login', 'AuthController::login');
$routes->post('/loginProcess', 'AuthController::loginProcess');

// --- ROUTE TERPROTEKSI (Wajib login) ---
// Kita bungkus menggunakan filter 'auth'
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'AdminController::index');
    $routes->get('/logout', 'AuthController::logout');
});