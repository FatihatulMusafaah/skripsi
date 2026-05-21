<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');

            $table->string('bulan');

            $table->bigInteger('gaji_pokok')->default(0);
;
            $table->integer('jam_lembur')->default(0);

            $table->bigInteger('tarif_lembur')->default(0);

            $table->bigInteger('potongan_kasbon')->default(0);

            $table->bigInteger('potongan_lainnya')->default(0);

            $table->bigInteger('total_gaji')->default(0);

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};