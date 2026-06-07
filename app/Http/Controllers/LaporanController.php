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
    public function index()
    {
        return redirect()->route('owner.laporan.pegawai');
    }

    public function pegawai(Request $request)
    {
        $query = User::where('role', 'karyawan');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $data = $query->latest()->get();
        return view('owner.laporan.pegawai', compact('data'));
    }

    public function absensi(Request $request)
    {
        $query = Absensi::with('user');
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        $data = $query->latest()->get();
        return view('owner.laporan.absensi', compact('data'));
    }

    public function cuti(Request $request)
    {
        $query = Cuti::with('user');
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $data = $query->latest()->get();
        return view('owner.laporan.cuti', compact('data'));
    }

    public function kasbon(Request $request)
    {
        $query = Kasbon::with('user');
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $data = $query->latest()->get();
        return view('owner.laporan.kasbon', compact('data'));
    }

    public function penggajian(Request $request)
    {
        $query = Penggajian::with('user');
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        $data = $query->latest()->get();
        return view('owner.laporan.penggajian', compact('data'));
    }
}
