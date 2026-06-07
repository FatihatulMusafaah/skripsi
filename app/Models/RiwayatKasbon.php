<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKasbon extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kasbon';

    protected $fillable = [
        'pegawai_id',
        'total_kasbon',
        'kasbon_dibayar',
        'sisa_kasbon',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }
}
