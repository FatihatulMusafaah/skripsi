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
        Schema::dropIfExists('penggajian');
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('user')->onDelete('cascade');
            $table->string('bulan', 20);
            $table->integer('tahun');
            $table->integer('gaji_pokok');
            $table->integer('lembur')->default(0);
            $table->integer('potongan_kasbon')->default(0);
            $table->integer('potongan_cuti')->default(0);
            $table->integer('total_gaji');
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
