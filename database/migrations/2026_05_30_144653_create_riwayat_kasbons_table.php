<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_kasbon', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pegawai_id')
                ->constrained('user')
                ->onDelete('cascade');

            $table->decimal('total_kasbon', 15, 2)->default(0);
            $table->decimal('kasbon_dibayar', 15, 2)->default(0);
            $table->decimal('sisa_kasbon', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_kasbon');
    }
};
