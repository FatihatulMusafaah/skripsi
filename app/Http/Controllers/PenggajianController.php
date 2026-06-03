<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::with('user')->latest()->get();
        $pegawai = User::where('role', 'karyawan')->get();

        return view('penggajian.index', compact('penggajian', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required',
            'gaji_pokok' => 'required|numeric',
            'jam_lembur' => 'nullable|numeric',
            'tarif_lembur' => 'nullable|numeric',
            'potongan_kasbon' => 'nullable|numeric',
            'potongan_lainnya' => 'nullable|numeric',
        ]);

        $gaji = $request->gaji_pokok + ($request->jam_lembur * ($request->tarif_lembur ?? 0));
        $potongan = ($request->potongan_bpjs ?? 0) + ($request->potongan_kasbon ?? 0) + ($request->potongan_lainnya ?? 0);
        $total = $gaji - $potongan;

        Penggajian::create([
            'user_id' => $request->user_id,
            'gaji_pokok' => $request->gaji_pokok,
            'lembur' => ($request->jam_lembur * ($request->tarif_lembur ?? 0)),
            'potongan' => $potongan,
            'total_gaji' => $total,
            'tanggal' => now(), // Assuming current date for simplicity or use specific field
        ]);

        return redirect()->back()->with('success', 'Penggajian berhasil diproses');
    }
}
