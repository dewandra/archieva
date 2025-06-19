<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    // Properti untuk menampung input dari form
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    // Aturan validasi untuk input
    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required|string',
    ];

    /**
     * Method ini akan dijalankan saat form di-submit.
     */
    public function login()
    {
        // 1. Jalankan validasi berdasarkan $rules di atas
        $credentials = $this->validate();

        // 2. Coba lakukan autentikasi dengan data yang diberikan
        if (Auth::attempt($credentials, $this->remember)) {
            // 3. Jika berhasil, regenerate session untuk keamanan
            request()->session()->regenerate();

            // 4. Dapatkan user yang sedang login
            $user = Auth::user();

            // 5. LAKUKAN REDIRECT BERDASARKAN ROLE
            // Kita akan memanggil method getRedirectRoute() dari model User Anda.
            // Pastikan method itu mengembalikan NAMA RUTE, bukan URL.
            return redirect()->route($user->getRedirectRoute());
        }

        // 6. Jika autentikasi gagal, kirim pesan error ke view
        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
    }

    /**
     * Render view komponen dan bungkus dengan layout login kustom Anda.
     */
    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.login');
    }
}