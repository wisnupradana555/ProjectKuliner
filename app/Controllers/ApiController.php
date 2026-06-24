<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ApiController extends Controller
{
    /**
     * GET /api/kuliner
     * Mengembalikan daftar semua tempat kuliner yang sudah diapprove dalam format JSON.
     * Bisa difilter dengan query parameter: ?kategori=1 atau ?lat=x&lng=y
     */
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

        // Filter opsional berdasarkan kategori
        $kategori = $this->request->getGet('kategori');
        if ($kategori) {
            $builder->where('tk.kategori_id', $kategori);
        }

        $data = $builder->get()->getResultArray();

        // Format foto agar ada full URL-nya
        foreach ($data as &$item) {
            $item['foto_url'] = $item['file_foto']
                ? base_url('uploads/' . $item['file_foto'])
                : null;
            unset($item['file_foto']);
        }

        return $this->response
            ->setStatusCode(200)
            ->setJSON([
                'status'  => 'success',
                'total'   => count($data),
                'data'    => $data
            ]);
    }

    /**
     * GET /api/kuliner/{id}
     * Mengembalikan detail satu tempat kuliner berdasarkan ID.
     */
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
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Data tidak ditemukan.'
                ]);
        }

        $data['foto_url'] = $data['file_foto']
            ? base_url('uploads/' . $data['file_foto'])
            : null;
        unset($data['file_foto']);

        return $this->response
            ->setStatusCode(200)
            ->setJSON([
                'status' => 'success',
                'data'   => $data
            ]);
    }

    /**
     * GET /api/kategori
     * Mengembalikan daftar semua kategori kuliner dalam format JSON.
     */
    public function kategori()
    {
        $db   = \Config\Database::connect();
        $data = $db->table('kategori')->get()->getResultArray();

        return $this->response
            ->setStatusCode(200)
            ->setJSON([
                'status' => 'success',
                'total'  => count($data),
                'data'   => $data
            ]);
    }
}
