<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    // 1. TAMBAHKAN BARIS INI UNTUK MENGUNCI NAMA TABEL
    protected $table = 'penggajian';

    protected $fillable = [
        'pegawai_id',
        'bulan',
        'gaji_pokok',
        'jam_lembur',
        'tarif_lembur',
        'potongan_kasbon',
        'potongan_lainnya',
        'total_gaji',
        'keterangan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
