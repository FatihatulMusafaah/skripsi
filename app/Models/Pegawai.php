<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'id_pegawai',
        'nama',
        'email',
        'jabatan',
        'no_hp',
        'alamat',
        'gaji_pokok',
    ];

    // relasi ke absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'pegawai_id');
    }

    // relasi ke cuti
    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'pegawai_id');
    }

    // relasi ke kasbon
    public function kasbon()
    {
        return $this->hasMany(Kasbon::class, 'pegawai_id');
    }

    // relasi ke penggajian
    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'pegawai_id');
    }
}