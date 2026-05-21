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
        Schema::create('pegawai', function (Blueprint $table) {

            // $table->id();

            // DATA PEGAWAI
             $table->string('id')->primary();

            $table->string('nama');

            $table->string('jabatan')->unique();

            $table->string('email');

            $table->string('no_hp')->nullable();

            $table->text('alamat')->nullable();


            // STATUS
            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');

    }
};
