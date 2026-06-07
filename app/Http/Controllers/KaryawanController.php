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

        $jumlah = $request->jumlah_kasbon;
        $metode = $request->metode_pembayaran;
        $persen = $request->persentase_potongan ?? 100;
        
        $potongan = ($jumlah * $persen) / 100;
        $tenor = ceil($jumlah / $potongan);

        Kasbon::create([
            'pegawai_id' => Auth::id(),
            'jumlah_kasbon' => $jumlah,
            'metode_pembayaran' => $metode,
            'persentase_potongan' => $metode == 'cicilan' ? $persen : null,
            'potongan_per_bulan' => $potongan,
            'lama_cicilan' => $tenor,
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
}
