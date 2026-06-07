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
        Schema::create('riwayat_kasbon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id')->index();
            $table->decimal('total_kasbon', 15, 2)->default(0.00);
            $table->decimal('kasbon_dibayar', 15, 2)->default(0.00);
            $table->decimal('sisa_kasbon', 15, 2)->default(0.00);
            $table->integer('lama_cicilan')->default(0);
            $table->integer('sisa_cicilan')->default(0);
            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kasbon');
    }
};
