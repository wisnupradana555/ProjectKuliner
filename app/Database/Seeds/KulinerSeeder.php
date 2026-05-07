<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KulinerSeeder extends Seeder
{
    public function run()
    {
        $kuliner = [];
        $udinusLat = -6.9822;
        $udinusLon = 110.4091;

        $names = [
            ['Burjo Sari Asih 2', 1, 'Nasi, mie ayam, bakso, dan aneka lauk murah meriah.'],
            ['Oti Fried Chicken', 3, 'Ayam geprek dan fried chicken porsi mahasiswa.'],
        ];

        foreach ($names as $i => $item) {
            $kuliner[] = [
                'user_id'     => 1,
                'kategori_id' => $item[1],
                'nama'        => $item[0],
                'alamat'      => 'Jl. Nakula I No.' . ($i + 1) . ', Pendrikan Kidul, Semarang Tengah',
                'deskripsi'   => $item[2],
                'lat'         => (string)($udinusLat + (rand(-100, 100) / 100000)),
                'lon'         => (string)($udinusLon + (rand(-100, 100) / 100000)),
                'status'      => 'approved',
                'created_at'  => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('tempat_kuliner')->insertBatch($kuliner);

        $pivot = [];
        for ($i = 1; $i <= 20; $i++) {
            $pivot[] = ['tempat_id' => $i, 'tag_id' => rand(1, 4)];
            $pivot[] = ['tempat_id' => $i, 'tag_id' => rand(5, 8)];
        }
        $this->db->table('tempat_tags')->insertBatch($pivot);
    }
}