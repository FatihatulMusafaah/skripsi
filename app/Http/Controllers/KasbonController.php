<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasbon;
use App\Models\Pegawai;

class KasbonController extends Controller
{
    /**
     * TAMPIL DATA
     */
    public function index()
    {
        $kasbons = Kasbon::with('pegawai')
                         ->latest()
                         ->get();

        return view('kasbon.index', compact('kasbons'));
    }

    /**
     * FORM TAMBAH
     */
    public function create()
    {
        $pegawais = Pegawai::all();

        return view('kasbon.create', compact('pegawais'));
    }

    /**
     * SIMPAN DATA
     */
    public function store(Request $request)
    {
        $request->validate([

            'pegawai_id'         => 'required',
            'jumlah_kasbon'      => 'required|numeric',
            'metode_pembayaran'  => 'required',

        ]);

        Kasbon::create([

            'pegawai_id'         => $request->pegawai_id,
            'jumlah_kasbon'      => $request->jumlah_kasbon,
            'metode_pembayaran'  => $request->metode_pembayaran,

        ]);

        return redirect()->route('kasbon.index')
                         ->with('success', 'Data kasbon berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $kasbon = Kasbon::findOrFail($id);

        $pegawais = Pegawai::all();

        return view('kasbon.edit', compact(
            'kasbon',
            'pegawais'
        ));
    }

    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
    {
        $kasbon = Kasbon::findOrFail($id);

        $request->validate([

            'pegawai_id'         => 'required',
            'jumlah_kasbon'      => 'required|numeric',
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
     * HAPUS DATA
     */
    public function destroy($id)
    {
        $kasbon = Kasbon::findOrFail($id);

        $kasbon->delete();

        return redirect()->route('kasbon.index')
                         ->with('success', 'Data kasbon berhasil dihapus');
    }
}