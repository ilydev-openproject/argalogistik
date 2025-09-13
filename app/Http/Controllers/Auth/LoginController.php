<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Kita bisa pakai view login yang sama
    }

    // Memproses usaha login
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Password wajib diisi.',
            ]
        );

        // Coba login menggunakan penjaga 'logistik'
        if (Auth::guard('logistik')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/logistik'); // Arahkan ke dashboard logistik
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::guard('logistik')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/logistik/login');
    }
}