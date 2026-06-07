<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';

    protected $fillable = [
        'pegawai_id',
        'bulan',
        'tahun',
        'gaji_pokok',
        'lembur',
        'potongan_kasbon',
        'potongan_cuti',
        'total_gaji',
        
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }
}
