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
        Schema::create('tb_diskon', function (Blueprint $table) {
            $table->id('diskon_id');
            // $table->string('jenis_diskon');
            // $table->integer('besaran_diskon');
            // $table->string('keterangan');
            $table->foreignId('rekomendasi_id');
            $table->timestamps();

            $table->foreign('rekomendasi_id')->references('rekomendasi_id')->on('tb_rekomendasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_diskon');
    }
};
