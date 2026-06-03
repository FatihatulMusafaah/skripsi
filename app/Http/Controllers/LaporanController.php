<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Kasbon;
use App\Models\Penggajian;

class LaporanController extends Controller
{
    /**
     * Tampilkan data laporan
     */
    public function index()
    {
        $pegawai = User::where('role', 'karyawan')->latest()->get();

        $absensi = Absensi::with('user')->latest()->get();
        $cuti = Cuti::with('user')->latest()->get();
        $kasbon = Kasbon::with('user')->latest()->get();
        $penggajian = Penggajian::with('user')->latest()->get();

        return view('laporan.index', compact(
            'pegawai',
            'absensi',
            'cuti',
            'kasbon',
            'penggajian'
        ));
    }
}
