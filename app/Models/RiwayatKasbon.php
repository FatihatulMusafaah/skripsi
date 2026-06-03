<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKasbon extends Model
{
    protected $fillable = [
        'pegawai_id',
        'total_kasbon',
        'kasbon_dibayar',
        'sisa_kasbon'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}