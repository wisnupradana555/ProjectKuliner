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
            ['Penyetan Mas Kobis', 1, 'Penyetan dengan sambal bawang pedas mantap.'],
            ['Warteg Kharisma Bahari', 1, 'Warteg legendaris dengan pilihan lauk lengkap.'],
            ['Nasi Goreng Padang Bangjo', 3, 'Nasi goreng padang porsi besar harga terjangkau.'],
            ['Soto Bangkong', 1, 'Soto ayam khas Semarang yang sudah terkenal.'],
            ['Sate Taichan Goreng', 3, 'Sate ayam bumbu taichan tanpa kecap.'],
            ['Tahu Gimbal Pak Edy', 3, 'Tahu gimbal khas Semarang dengan bumbu kacang.'],
            ['Mie Ayam Happy', 3, 'Mie ayam bakso homemade rasa rumahan.'],
            ['Kafe Basilia', 2, 'Kafe cozy buat nongkrong dan ngerjain tugas.'],
            ['Ayam Geprek Bensu', 3, 'Ayam geprek level pedas dengan nasi dan es teh.'],
            ['Seblak Bloom', 3, 'Seblak kuah pedas dengan topping lengkap.'],
            ['Es Teh Poci Nakula', 4, 'Es teh poci segar dengan gula batu.'],
            ['Kebab Turki Baba Rafi', 3, 'Kebab daging sapi dan ayam porsi jumbo.'],
            ['Geprek Juara', 3, 'Ayam geprek sambal matah dan sambal ijo.'],
            ['Lekker Paimo', 5, 'Lekker pancong isi coklat, keju, dan kacang.'],
            ['Pecel Yu Sri', 1, 'Pecel sayur dengan bumbu kacang khas Jawa.'],
            ['Lumpia Gang Lombok', 3, 'Lumpia basah dan goreng isi rebung.'],
            ['Nasi Ayam Bu Wido', 1, 'Nasi ayam kampung dengan lalapan segar.'],
            ['Bakso Doa Ibu', 3, 'Bakso urat jumbo kuah kaldu sapi.'],
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