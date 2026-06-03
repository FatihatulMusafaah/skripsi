<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib ditambahkan untuk fitur login

class SesiController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input (Sesuai kode Anda)
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'email wajib diisi',
            'password.required' => 'password wajib diisi',
        ]);

        // 2. Ambil data email dan password dari form
        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // 3. Proses otentikasi ke database
        if (Auth::attempt($infologin)) {
           if (Auth::user()->role == 'Admin'){
            return redirect('/Admin');
           }elseif (Auth::user()->role == 'karyawan'){
            return redirect('Admin/karyawan');
           }elseif (Auth::user()->role == 'owner'){
            return redirect('Admin/owner');
           }
        } else {
            // Jika email atau password salah, kembali ke login dengan pesan error
            return redirect('')->withErrors('Email atau password yang Anda masukkan salah')->withInput();
        }
    }

    // 4. Fungsi tambahan untuk logout
    function logout()
    {
        Auth::logout();
        return redirect('')->with('success', 'Berhasil logout');
    }
}
