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
     * Logic pelunasan otomatis dan sinkronisasi ke RiwayatKasbon
     */
    protected static function boot()
    {
        parent::boot();

        // Sebelum simpan, cek status lunas
        static::saving(function ($model) {
            if ($model->sisa_kasbon <= 0) {
                $model->status = 'lunas';
                $model->sisa_kasbon = 0;
            } else {
                $model->status = 'aktif';
            }
        });

        // Setelah simpan (create/update), sinkronkan ke RiwayatKasbon
        static::saved(function ($model) {
            static::updateRiwayat($model->pegawai_id);
        });

        // Setelah hapus, sinkronkan ke RiwayatKasbon
        static::deleted(function ($model) {
            static::updateRiwayat($model->pegawai_id);
        });
    }

    /**
     * Fungsi untuk memperbarui data di RiwayatKasbon berdasarkan data Kasbon aktif/lunas
     */
    public static function updateRiwayat($pegawai_id)
    {
        $allKasbon = self::where('pegawai_id', $pegawai_id)->get();
        
        if ($allKasbon->isEmpty()) {
            RiwayatKasbon::where('pegawai_id', $pegawai_id)->delete();
            return;
        }

        $total_kasbon = $allKasbon->sum('jumlah_kasbon');
        $sisa_kasbon = $allKasbon->sum('sisa_kasbon');
        $kasbon_dibayar = $total_kasbon - $sisa_kasbon;
        
        // Menghitung cicilan (hanya untuk yang metode 'cicilan')
        $lama_cicilan = $allKasbon->where('metode_pembayaran', 'cicilan')->sum('lama_cicilan');
        
        // Estimasi sisa cicilan: sisa_kasbon / potongan_per_bulan (untuk yang aktif)
        $sisa_cicilan = 0;
        foreach ($allKasbon as $k) {
            if ($k->status == 'aktif' && $k->metode_pembayaran == 'cicilan' && $k->potongan_per_bulan > 0) {
                $sisa_cicilan += ceil($k->sisa_kasbon / $k->potongan_per_bulan);
            }
        }

        RiwayatKasbon::updateOrCreate(
            ['pegawai_id' => $pegawai_id],
            [
                'total_kasbon' => $total_kasbon,
                'kasbon_dibayar' => $kasbon_dibayar,
                'sisa_kasbon' => $sisa_kasbon,
                'lama_cicilan' => $lama_cicilan,
                'sisa_cicilan' => $sisa_cicilan,
            ]
        );
    }
}
