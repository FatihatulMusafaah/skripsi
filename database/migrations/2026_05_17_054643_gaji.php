<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('user')->onDelete('cascade');
            $table->string('bulan', 20);
            $table->year('tahun');
            $table->decimal('gaji_pokok', 12, 2)->default(2000000);
            $table->integer('jam_lembur')->default(0);
            $table->decimal('tarif_lembur', 12, 2)->default(25000);
            $table->decimal('total_lembur', 12, 2)->default(0);
            $table->decimal('potongan_kasbon', 12, 2)->default(0);
            $table->decimal('potongan_cuti', 12, 2)->default(0);
            $table->decimal('gaji_bersih', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};
