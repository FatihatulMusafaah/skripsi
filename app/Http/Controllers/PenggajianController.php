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
            'user_id' => 'required|exists:user,id',
            'bulan' => 'required',
            'tahun' => 'required|numeric',
        ]);

        $userId = $request->user_id;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Mapping Nama Bulan ke Angka
        $bulanMap = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12'
        ];
        $bulanAngka = $bulanMap[$bulan];

        // 1. ATURAN DASAR
        $gaji_pokok = 2000000;
        $tarif_lembur = 25000;
        $potongan_per_hari_cuti = 50000; // Contoh: Potongan 50rb per hari cuti

        // 2. HITUNG LEMBUR DARI ABSENSI
        // Ambil data absensi bulan tersebut yang ada jam_keluarnya
        $dataAbsensi = \App\Models\Absensi::where('nama', $userId)
            ->whereMonth('tanggal', $bulanAngka)
            ->whereYear('tanggal', $tahun)
            ->whereNotNull('jam_masuk')
            ->whereNotNull('jam_keluar')
            ->get();

        $total_jam_lembur = 0;
        $jam_pulang_standar = \Carbon\Carbon::createFromTime(16, 0, 0);

        foreach ($dataAbsensi as $absen) {
            $keluar = \Carbon\Carbon::parse($absen->jam_keluar);

            // Jika jam keluar lebih dari jam 16:00, hitung selisihnya sebagai lembur
            if ($keluar->gt($jam_pulang_standar)) {
                $selisihJam = $jam_pulang_standar->diffInHours($keluar);
                $total_jam_lembur += $selisihJam;
            }
        }
        $total_lembur = $total_jam_lembur * $tarif_lembur;

        // 3. HITUNG POTONGAN KASBON
        // Cek sisa kasbon di tabel riwayat_kasbon
        $riwayat = \App\Models\RiwayatKasbon::where('pegawai_id', $userId)->first();
        $potongan_kasbon = 0;
        if ($riwayat && $riwayat->sisa_kasbon > 0) {
            // Minimal potongan 30% dari gaji pokok (Rp 600.000)
            $potongan_kasbon = $gaji_pokok * 0.3;
            
            // Jangan memotong melebihi sisa kasbon
            if ($potongan_kasbon > $riwayat->sisa_kasbon) {
                $potongan_kasbon = $riwayat->sisa_kasbon;
            }
            
            // Update sisa kasbon (Opsional: biasanya dilakukan saat konfirmasi pembayaran)
            // $riwayat->decrement('sisa_kasbon', $potongan_kasbon);
            // $riwayat->increment('kasbon_dibayar', $potongan_kasbon);
        }

        // 4. HITUNG POTONGAN CUTI
        // Ambil data cuti yang disetujui pada bulan tersebut
        $dataCuti = \App\Models\Cuti::where('nama', $userId)
            ->where('status', 'disetujui')
            ->where(function($query) use ($bulanAngka, $tahun) {
                // Mencari cuti yang beririsan dengan bulan terpilih
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
            $start = \Carbon\Carbon::parse($cuti->tanggal_mulai);
            $end = \Carbon\Carbon::parse($cuti->tanggal_selesai);
            
            // Batasi rentang tanggal hanya pada bulan yang dipilih
            $startBulan = \Carbon\Carbon::create($tahun, $bulanAngka, 1)->startOfMonth();
            $endBulan = \Carbon\Carbon::create($tahun, $bulanAngka, 1)->endOfMonth();
            
            $actualStart = $start->gt($startBulan) ? $start : $startBulan;
            $actualEnd = $end->lt($endBulan) ? $end : $endBulan;
            
            if ($actualStart->lte($actualEnd)) {
                $total_hari_cuti += $actualStart->diffInDays($actualEnd) + 1;
            }
        }
        $potongan_cuti = $total_hari_cuti * $potongan_per_hari_cuti;

        // 5. HITUNG GAJI BERSIH
        $gaji_bersih = ($gaji_pokok + $total_lembur) - ($potongan_kasbon + $potongan_cuti);

        // 6. SIMPAN DATA
        Penggajian::create([
            'pegawai_id' => $userId,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => $gaji_pokok,
            'jam_lembur' => $total_jam_lembur,
            'tarif_lembur' => $tarif_lembur,
            'total_lembur' => $total_lembur,
            'potongan_kasbon' => $potongan_kasbon,
            'potongan_cuti' => $potongan_cuti,
            'gaji_bersih' => $gaji_bersih,
        ]);

        return redirect()->back()->with('success', "Gaji berhasil diproses secara otomatis untuk bulan $bulan $tahun");
    }

    /**
     * Form edit gaji
     */
    public function edit(string $id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $pegawai = User::where('role', 'karyawan')->get();

        return view('penggajian.edit', compact('penggajian', 'pegawai'));
    }

    /**
     * Update data gaji secara manual
     */
    public function update(Request $request, string $id)
    {
        $penggajian = Penggajian::findOrFail($id);

        $request->validate([
            'gaji_pokok' => 'required|numeric',
            'jam_lembur' => 'required|numeric',
            'total_lembur' => 'required|numeric',
            'potongan_kasbon' => 'required|numeric',
            'potongan_cuti' => 'required|numeric',
            'gaji_bersih' => 'required|numeric',
        ]);

        $penggajian->update($request->all());

        return redirect()->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil diperbarui secara manual');
    }

    /**
     * Hapus data gaji
     */
    public function destroy(string $id)
    {
        Penggajian::destroy($id);

        return redirect()->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil dihapus');
    }
}
