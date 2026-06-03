<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Tampilkan data pegawai (User)
     */
    public function index()
    {
        $pegawai = User::latest()->get();

        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * Form tambah pegawai
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Simpan pegawai ke tabel users
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,owner,karyawan',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    /**
     * Form edit pegawai
     */
    public function edit($id)
    {
        $pegawai = User::findOrFail($id);

        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Update pegawai di tabel users
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,owner,karyawan',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diupdate');
    }

    /**
     * Hapus pegawai
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus');
    }
}
