<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showSigninForm()
    {
        return view('user.signin');
    }

    public function showSignupForm()
    {
        return view('user.signup'); // Pastikan Anda memiliki view 'user/signup.blade.php'
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required|unique:users,nik',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'nik' => $request->nik,
        ]);

        return redirect('/signin')->with('success', 'Pendaftaran berhasil! Silakan masuk.');
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'nik' => ['required', 'string'],
        ]);

        // Cari user berdasarkan name & nik
        $user = \App\Models\User::where('name', $credentials['name'])
            ->where('nik', $credentials['nik'])
            ->first();

        if ($user) {
            // Login manual tanpa password
            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'name' => 'Nama atau NIK yang Anda masukkan salah.',
        ])->onlyInput('name');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
