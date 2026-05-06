<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        // Tampilkan teks sementara
        echo "Selamat datang, " . session()->get('nama') . "!";
        echo "<br>Role kamu adalah: " . session()->get('role');
        echo "<br><a href='/logout'>Logout</a>";
    }
}