<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // tampil data
    public function index()
    {
        $absensi = Absensi::with('pegawai')
            ->latest()
            ->get();

        $pegawais = Pegawai::all();

        return view('absensi.index', compact(
            'absensis',
            'pegawais'
        ));
    }

    // absensi masuk
    public function masuk(Request $request)
    {
        Absensi::create([

            'nama_pegawai' => $request->nama_pegawai,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => now()->format('H:i:s'),
            'status' => 'Hadir'

        ]);

        return redirect('/absensi')
            ->with('success', 'Absensi masuk berhasil');
    }

    // absensi pulang
    public function pulang($id)
    {
        $absensi = Absensi::findOrFail($id);

        $absensi->update([
            'jam_pulang' => now()->format('H:i:s')
        ]);

        return redirect('/absensi')
            ->with('success', 'Absensi pulang berhasil');
    }
}