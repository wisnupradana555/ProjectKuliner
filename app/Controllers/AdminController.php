<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KulinerModel;

class AdminController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data = [
            'total_approved'  => $db->table('tempat_kuliner')->where('status', 'approved')->countAllResults(),
            'total_pending'   => $db->table('tempat_kuliner')->where('status', 'pending')->countAllResults(),
            'total_kategori'  => $db->table('kategori')->countAllResults(),
            'total_tag'       => $db->table('tags')->countAllResults(),
            'pending_kuliner' => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.status, k.nama_kategori, u.nama as user_nama')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->join('users u', 'u.id = tk.user_id', 'left')
                ->where('tk.status', 'pending')
                ->get()->getResultArray(),
            'semua_kuliner'   => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.status, k.nama_kategori, u.nama as user_nama')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->join('users u', 'u.id = tk.user_id', 'left')
                ->orderBy('tk.id', 'DESC')
                ->get()->getResultArray(),
        ];

        return view('admin/dashboard', $data);
    }
<<<<<<< HEAD
=======

    // Dashboard untuk kontributor
    public function dashboard()
    {
        $db  = \Config\Database::connect();
        $uid = session()->get('user_id');

        $data = [
            'total_submisi' => $db->table('tempat_kuliner')->where('user_id', $uid)->countAllResults(),
            'total_approved'=> $db->table('tempat_kuliner')->where('user_id', $uid)->where('status', 'approved')->countAllResults(),
            'total_pending' => $db->table('tempat_kuliner')->where('user_id', $uid)->where('status', 'pending')->countAllResults(),
            'kuliner_saya'  => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.alamat, tk.status, k.nama_kategori')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->where('tk.user_id', $uid)
                ->orderBy('tk.id', 'DESC')
                ->get()->getResultArray(),
        ];

        return view('kontributor/dashboard', $data);
    }
>>>>>>> 7e6af2dc1c5ef0133f3d576cd31885e46b1d8775

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