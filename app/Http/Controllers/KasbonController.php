<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasbon;
use App\Models\User;

class KasbonController extends Controller
{
    /**
     * Tampilkan data kasbon
     */
    public function index()
    {
        $kasbon = Kasbon::with('user')->latest()->get();

        return view('kasbon.index', compact('kasbon'));
    }

    /**
     * Form tambah kasbon
     */
    public function create()
    {
        $pegawai = User::where('role', 'karyawan')->get();

        return view('kasbon.create', compact('pegawai'));
    }

    /**
     * Simpan kasbon
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah_kasbon' => 'required|numeric',
            'metode_pembayaran' => 'required|in:Sekali Bayar,Cicilan',
        ]);

        Kasbon::create([
            'user_id' => $request->user_id,
            'jumlah_kasbon' => $request->jumlah_kasbon,
            'metode_pembayaran' => $request->metode_pembayaran,
            'sisa_kasbon' => $request->jumlah_kasbon,
            'status' => 'Belum Lunas'
        ]);

        return redirect()->route('kasbon.index')
            ->with('success', 'Kasbon berhasil ditambahkan');
    }

    /**
     * Form edit kasbon
     */
    public function edit($id)
    {
        $kasbon = Kasbon::findOrFail($id);
        $pegawai = User::where('role', 'karyawan')->get();

        return view('kasbon.edit', compact('kasbon', 'pegawai'));
    }

    /**
     * Update kasbon
     */
    public function update(Request $request, $id)
    {
        $kasbon = Kasbon::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah_kasbon' => 'required|numeric',
            'metode_pembayaran' => 'required|in:Sekali Bayar,Cicilan',
        ]);

        $kasbon->update([
            'user_id' => $request->user_id,
            'jumlah_kasbon' => $request->jumlah_kasbon,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('kasbon.index')
            ->with('success', 'Data kasbon berhasil diupdate');
    }

    /**
     * Hapus kasbon
     */
    public function destroy($id)
    {
        $kasbon = Kasbon::findOrFail($id);
        $kasbon->delete();

        return redirect()->route('kasbon.index')
            ->with('success', 'Data kasbon berhasil dihapus');
    }
}
