<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\User;

class CutiController extends Controller
{
    /**
     * Tampilkan data cuti
     */
    public function index()
    {
        $cuti = Cuti::with('user')->latest()->get();

        return view('cuti.index', compact('cuti'));
    }

    /**
     * Form create cuti
     */
    public function create()
    {
        $pegawai = User::where('role', 'karyawan')->get();

        return view('cuti.create', compact('pegawai'));
    }

    /**
     * Simpan data cuti
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|exists:user,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'alasan' => 'required',
        ]);

        Cuti::create([
            'nama' => $request->nama,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'pending'
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Pengajuan cuti berhasil');
    }

    /**
     * Form edit cuti
     */
    public function edit(string $id)
    {
        $cuti = Cuti::findOrFail($id);
        $pegawai = User::where('role', 'karyawan')->get();

        return view('cuti.edit', compact('cuti', 'pegawai'));
    }

    /**
     * Update data cuti
     */
    public function update(Request $request, string $id)
    {
        $cuti = Cuti::findOrFail($id);

        $request->validate([
            'nama' => 'required|exists:user,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'alasan' => 'required',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $cuti->update([
            'nama' => $request->nama,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => $request->status,
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Data cuti berhasil diperbarui');
    }

    /**
     * Setujui cuti (Quick action)
     */
    public function setujui(string $id)
    {
        $cuti = Cuti::findOrFail($id);

        $cuti->update([
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Cuti disetujui');
    }

    public function destroy(string $id)
    {
        Cuti::findOrFail($id)->delete();

        return back()->with('success', 'Data dihapus');
    }
}
