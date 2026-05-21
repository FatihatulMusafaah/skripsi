<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    /**
     * TAMPIL DATA PEGAWAI
     */
    public function index()
    {
        // Ambil semua data pegawai
        $pegawai = Pegawai::latest()->get();

        // Kirim ke view
        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * FORM TAMBAH PEGAWAI
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * SIMPAN DATA PEGAWAI
     */
    public function store(Request $request)
    {
        $request->validate([

            'id'           => 'required',
            'nama'           => 'required',
            'email'          => 'required|email|unique:pegawai,email',
            'jabatan'        => 'required',
            'no_hp'          => 'required',
            'alamat'         => 'nullable',
           
        ]);

        Pegawai::create([

            'id'           => $request->id,
            'nama'           => $request->nama,
            'email'          => $request->email,
            'jabatan'        => $request->jabatan,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            

        ]);

        return redirect()->route('pegawai.index')
                         ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    /**
     * FORM EDIT PEGAWAI
     */
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * UPDATE DATA PEGAWAI
     */
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([

            'id'           => 'required',
            'nama'           => 'required',
            'email'          => 'required|email|unique:pegawais,email,' . $id,
            'jabatan'        => 'required',
            'no_hp'          => 'required',
            'alamat'         => 'nullable',
            
        ]);

        $pegawai->update([

            'id'           => $request->id,
            'nama'           => $request->nama,
            'email'          => $request->email,
            'jabatan'        => $request->jabatan,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
          

        ]);

        return redirect()->route('pegawai.index')
                         ->with('success', 'Data pegawai berhasil diupdate');
    }

    /**
     * HAPUS DATA PEGAWAI
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $pegawai->delete();

        return redirect()->route('pegawai.index')
                         ->with('success', 'Data pegawai berhasil dihapus');
    }
}