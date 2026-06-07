<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Kasbon;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            'user_id' => 'required|exists:user,id',
            'bulan' => 'required',
            'tahun' => 'required|numeric',
        ]);

        $userId = $request->user_id;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $user = User::findOrFail($userId);

        // Mapping Nama Bulan ke Angka
        $bulanMap = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12'
        ];
        $bulanAngka = $bulanMap[$bulan];

        return DB::transaction(function () use ($user, $userId, $bulan, $tahun, $bulanAngka) {
            
            // 1. ATURAN DASAR
            $gaji_pokok = $user->gaji_pokok > 0 ? $user->gaji_pokok : 2000000;
            $tarif_lembur = 25000;
            $gaji_per_hari = $gaji_pokok / 30;

            // 2. HITUNG LEMBUR DARI ABSENSI
            $dataAbsensi = Absensi::where('pegawai_id', $userId)
                ->whereMonth('tanggal', $bulanAngka)
                ->whereYear('tanggal', $tahun)
                ->whereNotNull('jam_masuk')
                ->whereNotNull('jam_keluar')
                ->get();

            $total_jam_lembur = 0;
            $jam_pulang_standar = Carbon::createFromTime(16, 0, 0);

            foreach ($dataAbsensi as $absen) {
                $keluar = Carbon::parse($absen->jam_keluar);
                if ($keluar->gt($jam_pulang_standar)) {
                    $selisihJam = $jam_pulang_standar->diffInHours($keluar);
                    $total_jam_lembur += $selisihJam;
                }
            }
            $total_rupiah_lembur = $total_jam_lembur * $tarif_lembur;

            // 3. HITUNG POTONGAN KASBON (INTEGRASI OTOMATIS)
            $potongan_kasbon = 0;
            // Ambil kasbon aktif untuk pegawai ini
            $kasbonAktif = Kasbon::where('pegawai_id', $userId)
                ->where('status', 'aktif')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($kasbonAktif) {
                $potongan_kasbon = $kasbonAktif->potongan_per_bulan;
                
                // Jika sisa kasbon lebih kecil dari cicilan normal, potong sisanya saja
                if ($potongan_kasbon > $kasbonAktif->sisa_kasbon) {
                    $potongan_kasbon = $kasbonAktif->sisa_kasbon;
                }

                // Update Sisa Kasbon
                $kasbonAktif->decrement('sisa_kasbon', $potongan_kasbon);
                
                // Status akan otomatis jadi 'lunas' via model boot logic jika sisa = 0
                $kasbonAktif->save();
            }

            // 4. HITUNG POTONGAN CUTI
            $dataCuti = Cuti::where('pegawai_id', $userId)
                ->where('status', 'disetujui')
                ->where(function($query) use ($bulanAngka, $tahun) {
                    $query->where(function($q) use ($bulanAngka, $tahun) {
                        $q->whereMonth('tanggal_mulai', $bulanAngka)
                        ->whereYear('tanggal_mulai', $tahun);
                    })->orWhere(function($q) use ($bulanAngka, $tahun) {
                        $q->whereMonth('tanggal_selesai', $bulanAngka)
                        ->whereYear('tanggal_selesai', $tahun);
                    });
                })
                ->get();

            $total_hari_cuti = 0;
            foreach ($dataCuti as $cuti) {
                $start = Carbon::parse($cuti->tanggal_mulai);
                $end = Carbon::parse($cuti->tanggal_selesai);
                $startBulan = Carbon::create($tahun, $bulanAngka, 1)->startOfMonth();
                $endBulan = Carbon::create($tahun, $bulanAngka, 1)->endOfMonth();
                $actualStart = $start->gt($startBulan) ? $start : $startBulan;
                $actualEnd = $end->lt($endBulan) ? $end : $endBulan;
                if ($actualStart->lte($actualEnd)) {
                    $total_hari_cuti += $actualStart->diffInDays($actualEnd) + 1;
                }
            }
            $potongan_cuti = round($total_hari_cuti * $gaji_per_hari);

            // 5. HITUNG TOTAL GAJI
            $total = ($gaji_pokok + $total_rupiah_lembur) - ($potongan_kasbon + $potongan_cuti);

            // 6. SIMPAN DATA PENGGAJIAN
            Penggajian::create([
                'pegawai_id' => $user->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'gaji_pokok' => $gaji_pokok,
                'lembur' => $total_rupiah_lembur,
                'potongan_kasbon' => $potongan_kasbon,
                'potongan_cuti' => $potongan_cuti,
                'total_gaji' => $total,
            ]);

            return redirect()->back()->with('success', "Gaji berhasil diproses. Potongan Kasbon: Rp " . number_format($potongan_kasbon, 0, ',', '.'));
        });
    }

    public function edit(string $id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $pegawai = User::where('role', 'karyawan')->get();
        return view('penggajian.edit', compact('penggajian', 'pegawai'));
    }

    public function update(Request $request, string $id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $request->validate([
            'gaji_pokok' => 'required|numeric',
            'lembur' => 'required|numeric',
            'potongan_kasbon' => 'required|numeric',
            'potongan_cuti' => 'required|numeric',
            'total_gaji' => 'required|numeric',
        
        ]);
        $penggajian->update($request->all());
        return redirect()->route('penggajian.index')->with('success', 'Data penggajian diperbarui');
    }

    public function destroy(string $id)
    {
        Penggajian::destroy($id);
        return redirect()->route('penggajian.index')->with('success', 'Data penggajian dihapus');
    }
}
