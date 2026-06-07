<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Kasbon;
use App\Models\RiwayatKasbon;
use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $absensiHariIni = Absensi::where('pegawai_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        $totalCuti = Cuti::where('pegawai_id', $user->id)
            ->where('status', 'disetujui')
            ->count();

        $kasbonAktif = Kasbon::where('pegawai_id', $user->id)
            ->where('status', 'aktif')
            ->sum('sisa_kasbon');

        return view('karyawan.dashboard', compact('absensiHariIni', 'totalCuti', 'kasbonAktif'));
    }

    // ABSENSI
    public function absensi()
    {
        $user = Auth::user();
        $absensi = Absensi::where('pegawai_id', $user->id)->latest()->get();
        $todayAbsen = Absensi::where('pegawai_id', $user->id)->whereDate('tanggal', Carbon::today())->first();

        return view('karyawan.absensi', compact('absensi', 'todayAbsen'));
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        $cek = Absensi::where('pegawai_id', $user->id)->whereDate('tanggal', $today)->first();
        if ($cek) {
            return back()->with('error', 'Anda sudah absen hari ini.');
        }

        Absensi::create([
            'pegawai_id' => $user->id,
            'nama_pegawai' => $user->name,
            'tanggal' => $today,
            'jam_masuk' => now()->format('H:i:s'),
            'status' => 'hadir'
        ]);

        return back()->with('success', 'Berhasil absen masuk.');
    }

    public function absenPulang($id)
    {
        $absensi = Absensi::findOrFail($id);
        if ($absensi->pegawai_id != Auth::id()) {
            abort(403);
        }

        $absensi->update([
            'jam_keluar' => now()->format('H:i:s')
        ]);

        return back()->with('success', 'Berhasil absen pulang.');
    }

    // CUTI
    public function cuti()
    {
        $user = Auth::user();
        $cuti = Cuti::where('pegawai_id', $user->id)->latest()->get();
        return view('karyawan.cuti', compact('cuti'));
    }

    public function cutiStore(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'alasan' => 'required',
        ]);

        Cuti::create([
            'pegawai_id' => Auth::id(),
            'nama_pegawai' => Auth::user()->name,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    // KASBON
    public function kasbon()
    {
        $user = Auth::user();
        $kasbon = Kasbon::where('pegawai_id', $user->id)->latest()->get();
        $riwayat = RiwayatKasbon::where('pegawai_id', $user->id)->first();

        return view('karyawan.kasbon', compact('kasbon', 'riwayat'));
    }

    public function kasbonStore(Request $request)
    {
        $request->validate([
            'jumlah_kasbon' => 'required|numeric|min:1000',
            'metode_pembayaran' => 'required|in:bayar_sekali,cicilan',
            'persentase_potongan' => 'required_if:metode_pembayaran,cicilan|nullable|integer|min:30|max:100',
        ]);

        $user = Auth::user();
        $gajiPokok = $user->gaji_pokok > 0 ? $user->gaji_pokok : 2000000;
        
        $jumlah = $request->jumlah_kasbon;
        $metode = $request->metode_pembayaran;
        
        if ($metode == 'bayar_sekali') {
            $potongan = $jumlah;
            $tenor = 1;
            $persen = null;
        } else {
            $persen = $request->persentase_potongan;
            // Rumus: Gaji Pokok * Persentase Potongan
            $potongan = ($gajiPokok * $persen) / 100;
            // Rumus: Total Kasbon / Potongan per Bulan (Bulatkan ke atas)
            $tenor = ceil($jumlah / $potongan);
        }

        Kasbon::create([
            'pegawai_id' => $user->id,
            'jumlah_kasbon' => $jumlah,
            'metode_pembayaran' => $metode,
            'persentase_potongan' => $persen,
            'potongan_per_bulan' => $potongan,
            'lama_cicilan' => $tenor,
            'sisa_cicilan' => $tenor,
            'sisa_kasbon' => $jumlah,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan kasbon berhasil dikirim.');
    }

    // SLIP GAJI
    public function slipGaji()
    {
        $user = Auth::user();
        $gaji = Penggajian::where('pegawai_id', $user->id)->latest()->get();
        return view('karyawan.slip_gaji', compact('gaji'));
    }

    public function slipGajiShow($id)
    {
        $gaji = Penggajian::with('user')->findOrFail($id);
        if ($gaji->pegawai_id != Auth::id()) {
            abort(403);
        }
        return view('karyawan.slip_gaji_detail', compact('gaji'));
    }

    // LAPORAN
    public function laporan()
    {
        $user = Auth::user();
        $absensi = Absensi::where('pegawai_id', $user->id)->count();
        $cuti = Cuti::where('pegawai_id', $user->id)->where('status', 'disetujui')->count();
        $kasbon = Kasbon::where('pegawai_id', $user->id)->sum('jumlah_kasbon');
        
        return view('karyawan.laporan', compact('absensi', 'cuti', 'kasbon'));
    }

    // RIWAYAT KASBON
    public function riwayatKasbon(Request $request)
    {
        $user = Auth::user();
        $query = Kasbon::where('pegawai_id', $user->id);

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian (berdasarkan nominal atau metode)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jumlah_kasbon', 'like', "%$search%")
                  ->orWhere('metode_pembayaran', 'like', "%$search%");
            });
        }

        $riwayat = $query->latest()->paginate(10);
        
        return view('karyawan.riwayat_kasbon', compact('riwayat'));
    }

    public function riwayatKasbonDetail($id)
    {
        $kasbon = Kasbon::findOrFail($id);
        if ($kasbon->pegawai_id != Auth::id()) {
            abort(403);
        }
        return view('karyawan.riwayat_kasbon_detail', compact('kasbon'));
    }
}
