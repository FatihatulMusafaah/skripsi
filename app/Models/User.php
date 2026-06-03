<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'jabatan',
        'no_hp',
        'alamat',
        'status',
        'gaji_pokok',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'user_id');
    }

    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'user_id');
    }

    public function kasbon()
    {
        return $this->hasMany(Kasbon::class, 'user_id');
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'user_id');
    }

    public function riwayatKasbon()
    {
        return $this->hasMany(RiwayatKasbon::class, 'user_id');
    }
}
