<?php

namespace App\Models;

use CodeIgniter\Model;

class KulinerModel extends Model
{
    protected $table            = 'tempat_kuliner';
    protected $primaryKey       = 'id';
    
    // Ini daftar kolom yang boleh diisi (WAJIB SAMA dengan database)
    protected $allowedFields    = [
        'user_id', 
        'kategori_id', 
        'nama', 
        'alamat', 
        'deskripsi', 
        'lat', 
        'lon', 
        'status'
    ];

    // Pengaturan waktu otomatis (created_at & updated_at)
    protected $useTimestamps    = false;
    //protected $createdField     = 'created_at';
    //protected $updatedField     = 'updated_at';
}