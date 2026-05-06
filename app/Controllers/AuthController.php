<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Tampilkan halaman login
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $model = new UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $model->where('email', $email)->first();

        if ($user) {
            // Cek kecocokan password (karena kita pakai password_hash di seeder)
            $verify_pass = password_verify($password, $user['password']);
            
            if ($verify_pass) {
                // Simpan data ke session
                $ses_data = [
                    'user_id'   => $user['id'],
                    'nama'      => $user['nama'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'isLoggedIn'=> TRUE
                ];
                $session->set($ses_data);
                
                // Arahkan ke dashboard setelah berhasil
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Email tidak terdaftar!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy(); // Hapus semua session
        return redirect()->to('/login');
    }
}