<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = [
        'nama_pegawai',
        'tanggal',
        'jam_masuk',
        'jam_pulang'
    ];
}