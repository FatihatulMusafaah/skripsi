<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pegawai');
        $table->date('tanggal');
        $table->time('jam_masuk')->nullable();
        $table->time('jam_keluar')->nullable();
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('hadir');
        $table->timestamps();
    });
}
};
