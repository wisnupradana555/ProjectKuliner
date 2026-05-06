<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_tag' => 'Halal'],
            ['nama_tag' => 'Murah'],
            ['nama_tag' => 'AC'],
            ['nama_tag' => 'WiFi'],
            ['nama_tag' => 'Parkir'],
            ['nama_tag' => 'Buka 24 Jam'],
            ['nama_tag' => 'Pesan Antar'],
            ['nama_tag' => 'Outdoor']
        ];
        
        $this->db->table('tags')->insertBatch($data);
    }
}
