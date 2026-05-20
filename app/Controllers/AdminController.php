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
            'pending_kuliner' => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.status, k.nama_kategori, u.nama as user_nama')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->join('users u', 'u.id = tk.user_id', 'left')
                ->where('tk.status', 'pending')
                ->get()->getResultArray(),
            'semua_kuliner'   => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.status, k.nama_kategori, u.nama as user_nama')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->join('users u', 'u.id = tk.user_id', 'left')
                ->orderBy('tk.id', 'DESC')
                ->get()->getResultArray(),
        ];

        return view('admin/dashboard', $data);
    }

    // Dashboard untuk kontributor
    public function dashboard()
    {
        $db  = \Config\Database::connect();
        $uid = session()->get('user_id');

        $data = [
            'total_submisi' => $db->table('tempat_kuliner')->where('user_id', $uid)->countAllResults(),
            'total_approved'=> $db->table('tempat_kuliner')->where('user_id', $uid)->where('status', 'approved')->countAllResults(),
            'total_pending' => $db->table('tempat_kuliner')->where('user_id', $uid)->where('status', 'pending')->countAllResults(),
            'kuliner_saya'  => $db->table('tempat_kuliner tk')
                ->select('tk.id, tk.nama, tk.alamat, tk.status, k.nama_kategori')
                ->join('kategori k', 'k.id = tk.kategori_id', 'left')
                ->where('tk.user_id', $uid)
                ->orderBy('tk.id', 'DESC')
                ->get()->getResultArray(),
        ];

        return view('kontributor/dashboard', $data);
    }

    // 1. CREATE: Nampilin form
    public function create()
    {
        return view('tambah_kuliner'); 
    }

    // 2. CREATE: Nyimpen data ke database
    public function store()
    {
        $model = new KulinerModel();
        
        $data = [
            // PERBAIKAN: Disamakan menjadi 'user_id' agar tidak error foreign key
            'user_id'     => session()->get('user_id') ?? 1, 
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'lat'         => $this->request->getPost('lat'),
            'lon'         => $this->request->getPost('lon'),
            'status'      => 'approved'
        ];

        $model->insert($data);

        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin')->with('pesan', 'Mantap! Data Kuliner baru berhasil ditambahkan.');
        } else {
            return redirect()->to('/dashboard')->with('pesan', 'Mantap! Data Kuliner baru berhasil ditambahkan.');
        }
    }

    // 3. UPDATE: Nampilin form edit
    public function edit($id)
    {
        $model = new KulinerModel();
        $data = [
            'kuliner' => $model->find($id)
        ];
        
        // Buat file view 'edit_kuliner.php' kalau belum ada
        return view('edit_kuliner', $data); 
    }

    // 4. UPDATE: Nyimpen perubahan ke database
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

    // 5. DELETE: Hapus data
    public function delete($id)
    {
        $model = new KulinerModel();
        
        $model->delete($id);

        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin')->with('pesan', 'Data Kuliner berhasil dihapus dari sistem.');
        } else {
            return redirect()->to('/dashboard')->with('pesan', 'Data Kuliner berhasil dihapus dari sistem.');
        }
    }
}