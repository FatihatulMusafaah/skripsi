<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Penggajian;
use App\Models\Kasbon;

class LaporanController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        $absensi = Absensi::all();
        $cuti = Cuti::all();
        $penggajian = Penggajian::all();
        $kasbon = Kasbon::all();

        $totalPegawai = Pegawai::count();
        $totalAbsensi = Absensi::count();
        $totalCuti = Cuti::count();
        $totalPenggajian = Penggajian::count();
        $totalKasbon = Kasbon::count();

        return view('laporan.index', compact(
            'pegawai',
            'absensi',
            'cuti',
            'penggajian',
            'kasbon',
            'totalPegawai',
            'totalAbsensi',
            'totalCuti',
            'totalPenggajian',
            'totalKasbon'
        ));
    }
}