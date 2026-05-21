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
        Schema::create('kasbons', function (Blueprint $table) {

            $table->id();

            // RELASI KE PEGAWAI
            $table->foreignId('pegawai_id')
                  ->constrained('pegawais')
                  ->onDelete('cascade');

            // JUMLAH KASBON
            $table->decimal('jumlah_kasbon', 12, 2);

            // METODE PEMBAYARAN
            $table->enum('metode_pembayaran', [

                'cicil_30',
                'sekali_bayar'

            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasbons');
    }
};