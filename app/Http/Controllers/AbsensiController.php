<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;

class AbsensiController extends Controller
{
    /**
     * Tampilkan data absensi
     */
    public function index()
    {
        $absensi = Absensi::with('user')->latest()->get();
        $pegawai = User::where('role', 'karyawan')->get();

        return view('absensi.index', compact('absensi', 'pegawai'));
    }

    /**
     * Form tambah absensi
     */
    public function create()
    {
        $pegawai = User::where('role', 'karyawan')->get();

        return view('absensi.create', compact('pegawai'));
    }

    /**
     * Simpan absensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|exists:user,id',
            'status' => 'required',
            'tanggal' => 'required|date',
        ]);

        Absensi::create([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk ?? now()->format('H:i:s'),
            'jam_keluar' => $request->jam_keluar,
            'status' => strtolower($request->status),
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan');
    }

    /**
     * Absen pulang
     */
    public function pulang($id)
    {
        $absensi = Absensi::findOrFail($id);

        $absensi->update([
            'jam_keluar' => now()->format('H:i:s')
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Absen pulang berhasil');
    }

    /**
     * Update absensi
     */
    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        $request->validate([
            'nama' => 'required|exists:user,id',
            'tanggal' => 'required|date',
            'status' => 'required',
        ]);

        $absensi->update([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status' => strtolower($request->status),
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil diupdate');
    }

    /**
     * Hapus absensi
     */
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil dihapus');
    }
}
