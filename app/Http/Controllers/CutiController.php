<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Pegawai;

class CutiController extends Controller
{
    /**
     * Tampilkan data cuti
     */
    public function index()
    {
        $cuti = Cuti::with('pegawai')->latest()->get();

        return view('cuti.index', compact('cuti'));
    }

    /**
     * Form create cuti
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view('cuti.create', compact('pegawai'));
    }

    /**
     * Simpan data cuti
     */
    public function store(Request $request)
    {
        $request->validate([

            'pegawai_id' => 'required',

            'nama_pegawai' => 'required',

            'tanggal_mulai' => 'required',

            'tanggal_selesai' => 'required',

            'alasan' => 'required',

        ]);

        Cuti::create([

            'pegawai_id' => $request->pegawai_id,

            'nama_pegawai' => $request->nama,

            'tanggal_mulai' => $request->tanggal_mulai,

            'tanggal_selesai' => $request->tanggal_selesai,

            'alasan' => $request->alasan,

            'status' => 'Pending'

        ]);

        return redirect('/cuti')
            ->with('success', 'Pengajuan cuti berhasil');
    }
     public function update($id)
    {
        $cuti = Cuti::findOrFail($id);

        $cuti->update([
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Cuti disetujui');
    }

    public function destroy($id)
    {
        Cuti::findOrFail($id)->delete();

        return back()->with('success', 'Data dihapus');
    }

}