<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class ApiController extends Controller
{
    use ResponseTrait;

    public function getCoordinates()
    {
        $alamat = $this->request->getGet('alamat');

        if (!$alamat) {
            return $this->fail('Alamat tidak boleh kosong', 400);
        }

        $cache    = \Config\Services::cache();
        $cacheKey = 'geocode_' . md5($alamat);
        $cached   = $cache->get($cacheKey);

        if ($cached !== null) {
            return $this->respond($cached);
        }

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->request('GET', 'https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q'      => $alamat,
                    'format' => 'json',
                    'limit'  => 1
                ],
                'headers' => [
                    'User-Agent' => 'ProjectKuliner/1.0'
                ]
            ]);

            $body = json_decode($response->getBody());

            if (!empty($body)) {
                $result = [
                    'lat' => $body[0]->lat,
                    'lon' => $body[0]->lon
                ];

                $cache->save($cacheKey, $result, 86400);

                return $this->respond($result);
            } else {
                return $this->failNotFound('Koordinat tidak ditemukan untuk alamat tersebut.');
            }

        } catch (\Exception $e) {
            return $this->failServerError('Gagal menghubungi server Nominatim: ' . $e->getMessage());
        }
    }

    public function kuliner()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tempat_kuliner tk')
            ->select('tk.id, tk.nama, tk.alamat, tk.deskripsi, tk.lat, tk.lon, tk.created_at, k.nama_kategori as kategori, ft.file_foto')
            ->join('kategori k', 'k.id = tk.kategori_id', 'left')
            ->join('foto_tempat ft', 'ft.tempat_id = tk.id', 'left')
            ->where('tk.status', 'approved')
            ->groupBy('tk.id')
            ->orderBy('tk.created_at', 'DESC');

        $kategori = $this->request->getGet('kategori');
        if ($kategori) {
            $builder->where('tk.kategori_id', $kategori);
        }

        $data = $builder->get()->getResultArray();

        foreach ($data as &$item) {
            $item['foto_url'] = $item['file_foto']
                ? base_url('uploads/' . $item['file_foto'])
                : null;
            unset($item['file_foto']);
        }

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'total'  => count($data),
            'data'   => $data
        ]);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();

        $data = $db->table('tempat_kuliner tk')
            ->select('tk.id, tk.nama, tk.alamat, tk.deskripsi, tk.lat, tk.lon, tk.created_at, k.nama_kategori as kategori, ft.file_foto')
            ->join('kategori k', 'k.id = tk.kategori_id', 'left')
            ->join('foto_tempat ft', 'ft.tempat_id = tk.id', 'left')
            ->where('tk.id', $id)
            ->where('tk.status', 'approved')
            ->get()->getRowArray();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        $data['foto_url'] = $data['file_foto']
            ? base_url('uploads/' . $data['file_foto'])
            : null;
        unset($data['file_foto']);

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function kategori()
    {
        $db   = \Config\Database::connect();
        $data = $db->table('kategori')->get()->getResultArray();

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'total'  => count($data),
            'data'   => $data
        ]);
    }
}