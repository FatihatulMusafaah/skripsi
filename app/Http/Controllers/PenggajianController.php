<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::with('pegawai')->latest()->get();

        $pegawais = Pegawai::all();

        return view('penggajian.index', compact(
            'penggajian',
            'pegawais'
        ));
    }

    public function store(Request $request)
    {
        $gaji =
            $request->gaji_pokok +
            ($request->jam_lembur * $request->tarif_lembur);

        $potongan =
            $request->potongan_bpjs +
            $request->potongan_kasbon +
            $request->potongan_lainnya;

        $total = $gaji - $potongan;

        Penggajian::create([
            'pegawai_id' => $request->pegawai_id,
            'bulan' => $request->bulan,
            'gaji_pokok' => $request->gaji_pokok,
            'jam_lembur' => $request->jam_lembur,
            'tarif_lembur' => $request->tarif_lembur,
            'potongan_kasbon' => $request->potongan_kasbon,
            'potongan_lainnya' => $request->potongan_lainnya,
            'total_gaji' => $total,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Penggajian berhasil diproses');
    }
}