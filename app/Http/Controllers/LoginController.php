<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Kita butuh ini
use Illuminate\Http\RedirectResponse; // Kita butuh ini

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     * (Menggantikan closure 'GET /login')
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Menangani percobaan login (autentikasi).
     * (Menggantikan closure 'POST /login')
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => 'required', // Kita pakai 'username'
            'password' => 'required',
        ]);

        // 2. Coba lakukan login
        if (Auth::attempt($credentials)) {
            // Jika berhasil, regenerasi session dan arahkan ke dashboard
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // 3. Jika gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.', // Tampilkan error
        ])->onlyInput('username');
    }

    /**
     * Menangani logout user.
     * (Menggantikan closure 'POST /logout')
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Arahkan kembali ke halaman login
    }
}