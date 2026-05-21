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
    
{
    Schema::create('penggajians', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pegawai');
        $table->integer('gaji_pokok');
        $table->integer('lembur')->default(0);
        $table->integer('potongan')->default(0);
        $table->integer('total_gaji');
        $table->date('tanggal');
        $table->timestamps();
    });
}
    }
    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
