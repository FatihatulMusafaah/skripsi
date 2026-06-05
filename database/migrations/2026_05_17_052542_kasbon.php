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

            $table->foreignId('pegawai_id')->constrained('user')->onDelete('cascade');

            $table->decimal('jumlah_kasbon', 12, 2);
            $table->enum('metode_pembayaran', ['cicil_30', 'sekali_bayar']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasbon');
    }
};
