<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kasbon', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->onDelete('cascade');

            $table->bigInteger('jumlah_kasbon');

            $table->enum('metode_pembayaran', [
                'Sekali Bayar',
                'Cicilan'
            ]);

            $table->bigInteger('jumlah_cicilan')
                ->default(0);

            $table->bigInteger('sisa_kasbon');

            $table->string('status')
                ->default('Belum Lunas');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasbon');
    }
};