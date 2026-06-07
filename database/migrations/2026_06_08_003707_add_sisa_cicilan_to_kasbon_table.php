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
        Schema::table('kasbon', function (Blueprint $table) {
            $table->integer('sisa_cicilan')->default(0)->after('lama_cicilan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kasbon', function (Blueprint $table) {
            $table->dropColumn('sisa_cicilan');
        });
    }
};
