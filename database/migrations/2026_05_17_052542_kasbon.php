<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('kasbon');
        Schema::create('kasbon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('user')->onDelete('cascade');
            $table->decimal('jumlah_kasbon', 15, 2);
            $table->enum('metode_pembayaran', ['bayar_sekali', 'cicilan']);
            $table->integer('persentase_potongan')->nullable(); // null jika bayar sekali
            $table->decimal('potongan_per_bulan', 15, 2);
            $table->integer('lama_cicilan');
            $table->decimal('sisa_kasbon', 15, 2);
            $table->enum('status', ['aktif', 'lunas'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasbon');
    }
};
