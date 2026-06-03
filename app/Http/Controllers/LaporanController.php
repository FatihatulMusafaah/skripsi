<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Kasbon;
use App\Models\Penggajian;

class LaporanController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::latest()->get();

        $absensi = Absensi::with('pegawai')
            ->latest()
            ->get();

        $cuti = Cuti::with('pegawai')
            ->latest()
            ->get();

        $kasbon = Kasbon::with('pegawai')
            ->latest()
            ->get();

        $penggajian = Penggajian::with('pegawai')
            ->latest()
            ->get();

        return view('laporan.index', compact(
            'pegawai',
            'absensi',
            'cuti',
            'kasbon',
            'penggajian'
        ));
    }
}