<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KulinerModel;

class AdminController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data = [
            'total_approved'  => $db->table('tempat_kuliner')->where('status', 'approved')->countAllResults(),
            'total_pending'   => $db->table('tempat_kuliner')->where('status', 'pending')->countAllResults(),
            'total_kategori'  => $db->table('kategori')->countAllResults(),
            'total_tag'       => $db->table('tags')->countAllResults(),
            
            // Query ditambahkan LEFT JOIN ke foto_tempat agar gambar bisa tampil di tabel
            'pending_kuliner' => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.status, k.nama_kategori, u.nama as user_nama, ft.file_foto')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->join('users u', 'u.id = tk.user_id', 'left')
                ->join('foto_tempat ft', 'ft.tempat_id = tk.id', 'left')
                ->where('tk.status', 'pending')
                ->groupBy('tk.id') // Mengelompokkan ID agar tidak ganda jika fotonya banyak
                ->get()->getResultArray(),
                
            'semua_kuliner'   => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.status, k.nama_kategori, u.nama as user_nama, ft.file_foto')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->join('users u', 'u.id = tk.user_id', 'left')
                ->join('foto_tempat ft', 'ft.tempat_id = tk.id', 'left')
                ->orderBy('tk.id', 'DESC')
                ->groupBy('tk.id')
                ->get()->getResultArray(),
        ];

        return view('admin/dashboard', $data);
    }

    public function dashboard()
    {
        $db  = \Config\Database::connect();
        $uid = session()->get('user_id');

        $data = [
            'total_submisi' => $db->table('tempat_kuliner')->where('user_id', $uid)->countAllResults(),
            'total_approved'=> $db->table('tempat_kuliner')->where('user_id', $uid)->where('status', 'approved')->countAllResults(),
            'total_pending' => $db->table('tempat_kuliner')->where('user_id', $uid)->where('status', 'pending')->countAllResults(),
            
            'kuliner_saya'  => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.alamat, tk.status, k.nama_kategori, ft.file_foto')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->join('foto_tempat ft', 'ft.tempat_id = tk.id', 'left')
                ->where('tk.user_id', $uid)
                ->orderBy('tk.id', 'DESC')
                ->groupBy('tk.id')
                ->get()->getResultArray(),
        ];

        return view('kontributor/dashboard', $data);
    }

    public function create()
    {
        return view('tambah_kuliner'); 
    }

    public function store()
    {
        // 1. Validasi
        $rules = [
            'nama'        => ['rules' => 'required', 'errors' => ['required' => 'Nama tempat wajib diisi.']],
            'kategori_id' => ['rules' => 'required', 'errors' => ['required' => 'Kategori wajib dipilih.']],
            'gambar'      => [
                'rules'  => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]',
                'errors' => [
                    'uploaded' => 'Pilih foto tempat terlebih dahulu.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG/PNG/JPEG.',
                    'max_size' => 'Ukuran maksimal 2MB.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Simpan Data Tempat Kuliner
        $model = new KulinerModel();
        $model->insert([
            'user_id'     => session()->get('user_id') ?? 1, 
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'lat'         => $this->request->getPost('lat'),
            'lon'         => $this->request->getPost('lon'),
            'status'      => 'approved'
        ]);

        // AMBIL ID TEMPAT KULINER YANG BARU SAJA DISIMPAN
        $tempat_id = $model->getInsertID();

        // 3. Proses Upload File & Simpan ke Tabel `foto_tempat`
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            // Simpan gambar ke folder public/uploads
            $fileGambar->move(ROOTPATH . 'public/uploads', $namaGambar);

            // Insert ke tabel foto_tempat
            $db = \Config\Database::connect();
            $db->table('foto_tempat')->insert([
                'tempat_id' => $tempat_id,
                'file_foto' => $namaGambar
            ]);
        }

        $halaman = (session()->get('role') === 'admin') ? '/admin' : '/dashboard';
        return redirect()->to($halaman)->with('pesan', 'Mantap! Kuliner & gambar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new KulinerModel();
        $data = [
            'kuliner' => $model->find($id)
        ];
        
        return view('edit_kuliner', $data); 
    }

    public function update($id)
    {
        $model = new KulinerModel();
        
        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'lat'         => $this->request->getPost('lat'),
            'lon'         => $this->request->getPost('lon'),
        ];

        $model->update($id, $data);

        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin')->with('pesan', 'Sip! Data Kuliner berhasil diperbarui.');
        } else {
            return redirect()->to('/dashboard')->with('pesan', 'Sip! Data Kuliner berhasil diperbarui.');
        }
    }

    public function delete($id)
    {
        $model = new KulinerModel();
        $db = \Config\Database::connect();
        
        // Cek apakah ada foto yang terhubung untuk dihapus fisik filenya
        $fotoLama = $db->table('foto_tempat')->where('tempat_id', $id)->get()->getResultArray();
        
        foreach ($fotoLama as $foto) {
            if (!empty($foto['file_foto']) && file_exists(ROOTPATH . 'public/uploads/' . $foto['file_foto'])) {
                unlink(ROOTPATH . 'public/uploads/' . $foto['file_foto']); // Hapus file dari folder
            }
        }

        // Hapus data tempat kuliner (Tabel foto_tempat akan otomatis terhapus karena relasi CASCADE)
        $model->delete($id);

        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin')->with('pesan', 'Data Kuliner berhasil dihapus dari sistem.');
        } else {
            return redirect()->to('/dashboard')->with('pesan', 'Data Kuliner berhasil dihapus dari sistem.');
        }
    }
}