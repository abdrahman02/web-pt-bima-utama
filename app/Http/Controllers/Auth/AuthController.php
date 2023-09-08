<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('auth.index');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return 'Berhasil';
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
            // if (auth()->user()->role == 'admin') {
            //     return redirect()->intended('/dashboard/berita');
            // } elseif (auth()->user()->role == 'pelanggan') {
            //     return redirect()->intended('/');
            // }
        }
        else {
            return back()->with('loginError', 'Username atau password salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
