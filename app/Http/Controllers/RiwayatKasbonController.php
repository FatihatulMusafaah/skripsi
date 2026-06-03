<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKasbon;
use App\Models\Kasbon;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatKasbonController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatKasbon::with('user')->latest()->get();
        return view('riwayat_kasbon.index', compact('riwayat'));
    }

    public function create()
    {
        $pegawai = User::where('role', 'karyawan')->get();
        return view('riwayat_kasbon.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_kasbon' => 'required|numeric',
            'kasbon_dibayar' => 'required|numeric',
        ]);

        RiwayatKasbon::create([
            'user_id' => $request->user_id,
            'total_kasbon' => $request->total_kasbon,
            'kasbon_dibayar' => $request->kasbon_dibayar,
            'sisa_kasbon' => $request->total_kasbon - $request->kasbon_dibayar,
        ]);

        return redirect()->route('riwayat-kasbon.index')
            ->with('success', 'Data riwayat kasbon berhasil ditambahkan');
    }

    public function edit($id)
    {
        $riwayat = RiwayatKasbon::findOrFail($id);
        $pegawai = User::where('role', 'karyawan')->get();

        return view('riwayat_kasbon.edit', compact('riwayat', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $riwayat = RiwayatKasbon::findOrFail($id);

        $riwayat->update([
            'user_id' => $request->user_id,
            'total_kasbon' => $request->total_kasbon,
            'kasbon_dibayar' => $request->kasbon_dibayar,
            'sisa_kasbon' => $request->total_kasbon - $request->kasbon_dibayar,
        ]);

        return redirect()->route('riwayat-kasbon.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        RiwayatKasbon::findOrFail($id)->delete();

        return redirect()->route('riwayat-kasbon.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
