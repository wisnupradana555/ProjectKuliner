<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KulinerSeeder extends Seeder
{
    public function run()
    {
        // 1. Data Users
        $this->db->table('users')->insertBatch([
            [
                'nama'       => 'Aditya Wisnu Pradana',
                'email'      => 'aditya@gmail.com',
                'password'   => password_hash('123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Mahasiswa Kontributor',
                'email'      => 'user@gmail.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'kontributor',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ]);

        // 2. Data Kategori
        $this->db->table('kategori')->insertBatch([
            ['nama_kategori' => 'Warteg'],
            ['nama_kategori' => 'Kafe'],
            ['nama_kategori' => 'Street Food']
        ]);

        // 3. Data Tags
        $this->db->table('tags')->insertBatch([
            ['nama_tag' => 'Halal'],
            ['nama_tag' => 'Murah'],
            ['nama_tag' => 'WiFi'],
            ['nama_tag' => 'Parkir Luas']
        ]);

        // 4. Data Tempat Kuliner Realistis
        $this->db->table('tempat_kuliner')->insertBatch([
            [
                'user_id'     => 1,
                'kategori_id' => 1,
                'nama'        => 'Burjo Sari Asih 2',
                'alamat'      => 'Kawasan Semarang',
                'deskripsi'   => 'Tempat makan andalan mahasiswa. Menu mie ayam, bakso, nasi telur, dll.',
                'lat'         => '-6.9822',
                'lon'         => '110.4091',
                'status'      => 'approved',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'     => 2,
                'kategori_id' => 3,
                'nama'        => 'Oti Fried Chicken',
                'alamat'      => 'Sekitar Area Kampus',
                'deskripsi'   => 'Ayam geprek dan fried chicken murah meriah porsi kuli.',
                'lat'         => '-6.9811',
                'lon'         => '110.4088',
                'status'      => 'approved',
                'created_at'  => date('Y-m-d H:i:s'),
            ]
        ]);
        
        // 5. Data Relasi Tags (Pivot)
        $this->db->table('tempat_tags')->insertBatch([
            ['tempat_id' => 1, 'tag_id' => 1], // Burjo Sari Asih 2 - Halal
            ['tempat_id' => 1, 'tag_id' => 2], // Burjo Sari Asih 2 - Murah
            ['tempat_id' => 2, 'tag_id' => 1], // Oti - Halal
            ['tempat_id' => 2, 'tag_id' => 2], // Oti - Murah
        ]);
    }
}