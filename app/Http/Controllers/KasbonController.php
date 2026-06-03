<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasbon;
use App\Models\Pegawai;

class KasbonController extends Controller
{
    /**
     * Tampilkan data kasbon
     */
    public function index()
    {
        $kasbon = Kasbon::with('pegawai')
            ->latest()
            ->get();

        return view('kasbon.index', compact('kasbon'));
    }

    /**
     * Form tambah kasbon
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view('kasbon.create', compact('pegawai'));
    }

    /**
     * Simpan kasbon
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id'         => 'required|exists:pegawai,id',
            'jumlah_kasbon'      => 'required|numeric',
            'metode_pembayaran'  => 'required',
        ]);

        Kasbon::create([
            'pegawai_id'         => $request->pegawai_id,
            'jumlah_kasbon'      => $request->jumlah_kasbon,
            'metode_pembayaran'  => $request->metode_pembayaran,
            
           
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

        $pegawai = Pegawai::all();

        return view('kasbon.edit', compact(
            'kasbon',
            'pegawai'
        ));
    }

    /**
     * Update kasbon
     */
    public function update(Request $request, $id)
    {
        $kasbon = Kasbon::findOrFail($id);

        $request->validate([
            'pegawai_id'         => 'required',
            'jumlah_kasbon'      => 'required',
            'metode_pembayaran'  => 'required',
             

        ]);

        $kasbon->update([
            'pegawai_id'         => $request->pegawai_id,
            'jumlah_kasbon'      => $request->jumlah_kasbon,
            'metode_pembayaran'  => $request->metode_pembayaran,
            
        
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