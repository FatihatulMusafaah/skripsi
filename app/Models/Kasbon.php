<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $table = 'kasbon';

    protected $fillable = [
 
        'pegawai_id',
        'jumlah_kasbon',
        'metode_pembayaran',

    ];

    /**
     * RELASI KE PEGAWAI
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}