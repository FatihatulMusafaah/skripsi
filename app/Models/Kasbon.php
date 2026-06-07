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
        'nama_pegawai',
        'jumlah_kasbon',
        'metode_pembayaran',
        'persentase_potongan',
        'potongan_per_bulan',
        'lama_cicilan',
        'sisa_kasbon',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    /**
     * Logic pelunasan otomatis saat sisa_kasbon <= 0
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->sisa_kasbon <= 0) {
                $model->status = 'lunas';
                $model->sisa_kasbon = 0;
            } else {
                $model->status = 'aktif';
            }
        });
    }
}
