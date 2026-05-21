<?php

namespace App\Models;

use CodeIgniter\Model;

class KulinerModel extends Model
{
    protected $table            = 'tempat_kuliner';
    protected $primaryKey       = 'id';
    
    // Ini daftar kolom yang boleh diisi
    protected $allowedFields    = [
        'user_id', 
        'kategori_id', 
        'nama', 
        'alamat', 
        'deskripsi', 
        'lat', 
        'lon', 
        'status',
        'gambar'
    ];

    // Pengaturan waktu otomatis
    protected $useTimestamps    = true;
}