<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KulinerModel; 

class AdminController extends BaseController
{
    public function index()
    {
        // 1. Panggil model kuliner
        $model = new KulinerModel();
        
        // 2. Siapkan data yang mau dikirim ke tampilan (View)
        $data = [
            'nama_user'      => session()->get('nama'),
            'role_user'      => session()->get('role'),
            'tempat_kuliner' => $model->findAll() // Ambil semua data dari tabel
        ];

        return view('dashboard', $data);
    }
    // 1. Fungsi untuk nampilin form
    public function create()
    {
        return view('tambah_kuliner');
    }

    // 2. Fungsi untuk nyimpen data ke database
    public function store()
    {
        $model = new KulinerModel();
        
        $data = [
            // Ambil ID user yang lagi login (kalau kosong, anggap user ID 1)
            'user_id'     => session()->get('id') ?? 1, 
            'kategori_id' => 1, 
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'lat'         => $this->request->getPost('lat'),
            'lon'         => $this->request->getPost('lon'),
            'status'      => 'approved'
        ];

        // Masukkan data ke database
        $model->insert($data);

        // Balik ke dashboard bawa pesan sukses (Flashdata)
        return redirect()->to('/dashboard')->with('pesan', 'Mantap! Data Kuliner baru berhasil ditambahkan.');
    }
}