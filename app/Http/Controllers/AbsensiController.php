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
        $pegawais = User::where('role', 'karyawan')->get();

        return view('absensi.create', compact('pegawais'));
    }

    /**
     * Simpan absensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required',
        ]);

        Absensi::create([
            'user_id' => $request->user_id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => now()->format('H:i:s'),
            'status' => $request->status,
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
            'jam_pulang' => now()->format('H:i:s')
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
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'status' => 'required',
        ]);

        $absensi->update([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
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
