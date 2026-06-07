<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKasbon;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatKasbonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayatKasbon = RiwayatKasbon::with('pegawai')->latest()->get();
        return view('riwayat_kasbon.index', compact('riwayatKasbon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = User::where('role', 'karyawan')->get();
        return view('riwayat_kasbon.create', compact('pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:user,id',
            'total_kasbon' => 'required|numeric|min:0',
            'kasbon_dibayar' => 'required|numeric|min:0',
            'lama_cicilan' => 'required|integer|min:0',
            'sisa_cicilan' => 'required|integer|min:0',
        ]);

        $total_kasbon = $request->total_kasbon;
        $kasbon_dibayar = $request->kasbon_dibayar;
        $sisa_kasbon = $total_kasbon - $kasbon_dibayar;

        RiwayatKasbon::create([
            'pegawai_id' => $request->pegawai_id,
            'total_kasbon' => $total_kasbon,
            'kasbon_dibayar' => $kasbon_dibayar,
            'sisa_kasbon' => $sisa_kasbon,
            'lama_cicilan' => $request->lama_cicilan,
            'sisa_cicilan' => $request->sisa_cicilan,
        ]);

        return redirect()->route('riwayat-kasbon.index')->with('success', 'Riwayat kasbon berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $riwayatKasbon = RiwayatKasbon::findOrFail($id);
        $pegawai = User::where('role', 'karyawan')->get();
        return view('riwayat_kasbon.edit', compact('riwayatKasbon', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:user,id',
            'total_kasbon' => 'required|numeric|min:0',
            'kasbon_dibayar' => 'required|numeric|min:0',
            'lama_cicilan' => 'required|integer|min:0',
            'sisa_cicilan' => 'required|integer|min:0',
        ]);

        $riwayatKasbon = RiwayatKasbon::findOrFail($id);

        $total_kasbon = $request->total_kasbon;
        $kasbon_dibayar = $request->kasbon_dibayar;
        $sisa_kasbon = $total_kasbon - $kasbon_dibayar;

        $riwayatKasbon->update([
            'pegawai_id' => $request->pegawai_id,
            'total_kasbon' => $total_kasbon,
            'kasbon_dibayar' => $kasbon_dibayar,
            'sisa_kasbon' => $sisa_kasbon,
            'lama_cicilan' => $request->lama_cicilan,
            'sisa_cicilan' => $request->sisa_cicilan,
        ]);

        return redirect()->route('riwayat-kasbon.index')->with('success', 'Riwayat kasbon berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $riwayatKasbon = RiwayatKasbon::findOrFail($id);
        $riwayatKasbon->delete();

        return redirect()->route('riwayat-kasbon.index')->with('success', 'Riwayat kasbon berhasil dihapus.');
    }
}
