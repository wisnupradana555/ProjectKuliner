<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $kuliner = $db->table('tempat_kuliner tk')
            ->select('tk.id, tk.nama, tk.alamat, tk.deskripsi, tk.lat, tk.lon, k.nama_kategori as kategori, tk.created_at')
            ->join('kategori k', 'k.id = tk.kategori_id')
            ->where('tk.status', 'approved')
            ->get()->getResultArray();

        $kategori = $db->table('kategori')->get()->getResultArray();

        $data = [
            'kuliner'  => $kuliner,
            'kategori' => $kategori,
        ];

        return view('home', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();

        $kuliner = $db->table('tempat_kuliner tk')
            ->select('tk.id, tk.nama, tk.alamat, tk.deskripsi, tk.lat, tk.lon, tk.created_at, k.nama_kategori as kategori, ft.file_foto')
            ->join('kategori k', 'k.id = tk.kategori_id', 'left')
            ->join('foto_tempat ft', 'ft.tempat_id = tk.id', 'left')
            ->where('tk.id', $id)
            ->where('tk.status', 'approved')
            ->get()->getRowArray();

        if (!$kuliner) {
            return redirect()->to('/')->with('error', 'Tempat kuliner tidak ditemukan.');
        }

        return view('detail_kuliner', ['kuliner' => $kuliner]);
    }
}
