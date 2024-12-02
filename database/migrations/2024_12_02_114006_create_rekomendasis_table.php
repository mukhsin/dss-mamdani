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
        Schema::create('tb_rekomendasi', function (Blueprint $table) {
            $table->id('rekomendasi_id');
            $table->foreignId('batas_id');
            $table->date('tgl_awal')->nullable();
            $table->date('tgl_akhir')->nullable();
            $table->timestamps();

            $table->foreign('batas_id')->references('batas_id')->on('tb_batas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_rekomendasi');
    }
};
