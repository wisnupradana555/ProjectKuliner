<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function getCoordinates()
    {
        // 1. Terima input alamat dari AJAX 
        $alamat = $this->request->getGet('alamat');
        
        if (!$alamat) {
            return $this->fail('Alamat tidak boleh kosong', 400); // Error handling
        }

        // Setup Caching (Syarat nilai maksimal) 
        $cache = \Config\Services::cache();
        $cacheKey = 'geocode_' . md5($alamat);
        $cachedData = $cache->get($cacheKey);

        // Jika data ada di cache, langsung kembalikan
        if ($cachedData !== null) {
            return $this->respond($cachedData);
        }

        // 2. HTTP Request ke API Nominatim
        $client = \Config\Services::curlrequest();
        
        try {
            // URL endpoint sesuai spesifikasi
            $response = $client->request('GET', 'https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q'      => $alamat,
                    'format' => 'json',
                    'limit'  => 1
                ],
                'headers' => [
                    // Nominatim mewajibkan User-Agent yang jelas agar tidak diblokir
                    'User-Agent' => 'ProjectKuliner/1.0' 
                ]
            ]);

            $body = json_decode($response->getBody());

            // 3. Ambil response [0].lat dan [0].lon
            if (!empty($body)) {
                $result = [
                    'lat' => $body[0]->lat,
                    'lon' => $body[0]->lon
                ];
                
                // Simpan hasil ke cache selama 24 jam (86400 detik)
                $cache->save($cacheKey, $result, 86400);
                
                return $this->respond($result);
            } else {
                return $this->failNotFound('Koordinat tidak ditemukan untuk alamat tersebut.'); // Error handling 
            }

        } catch (\Exception $e) {
            return $this->failServerError('Gagal menghubungi server Nominatim: ' . $e->getMessage()); // Error handling 
        }
    }
}