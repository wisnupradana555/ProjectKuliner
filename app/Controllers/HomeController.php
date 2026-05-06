<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $kuliner = $db->table('tempat_kuliner tk')
            ->select('tk.id, tk.nama, tk.alamat, tk.deskripsi, tk.lat, tk.lon, k.nama_kategori as kategori')
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
}
