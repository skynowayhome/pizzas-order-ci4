<?php namespace App\Controllers;
use App\Models\UserModel; // Memanggil model user yang sudah kita buat sebelumnya

class Auth extends BaseController {
    
    // Menampilkan halaman form login
    public function login() {
        // Jika user sudah login, arahkan langsung ke halaman utama
        if(session()->get('logged_in')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    // Memproses data dari form login
    public function processLogin() {
        $userModel = new UserModel();
        
        // Mengambil inputan dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Mencari user di database berdasarkan username
        // Ini menggantikan: $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $user = $userModel->where('username', $username)->first();

        // Jika user ditemukan
        if ($user) {
            // Memverifikasi password (sama seperti logika di file asli Anda)
            if (password_verify($password, $user['password'])) {
                // Set session jika berhasil
                $sessionData = [
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'logged_in' => true // Menggantikan 'user_logged_in' agar lebih rapi
                ];
                session()->set($sessionData);
                
                // Redirect ke halaman utama
                return redirect()->to('/');
            } else {
                // Password salah
                return redirect()->back()->with('error', 'Invalid password.');
            }
        } else {
            // Username tidak ditemukan
            return redirect()->back()->with('error', 'No user found with that username.');
        }
    }

    // Fungsi untuk logout sekalian kita buatkan
    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Menampilkan halaman form registrasi
    public function register() {
        if(session()->get('logged_in')) return redirect()->to('/');
        return view('auth/register');
    }

    // Memproses data registrasi
    public function processRegister() {
        $userModel = new \App\Models\UserModel();
        
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        if($password !== $confirm_password) {
            return redirect()->back()->with('error', 'Password konfirmasi tidak cocok!');
        }

        $data = [
            'username' => $this->request->getPost('username'),
            // Enkripsi password untuk keamanan
            'password' => password_hash($password, PASSWORD_DEFAULT) 
        ];

        $userModel->save($data);
        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}