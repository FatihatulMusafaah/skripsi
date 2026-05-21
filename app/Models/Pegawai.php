<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'id',
        'nama',
        'jabatan',
        'email',
        'no_hp',
        'alamat',
       
    ];
}