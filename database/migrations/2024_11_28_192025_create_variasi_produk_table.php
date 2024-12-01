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
        // Schema::create('tb_variasi_produk', function (Blueprint $table) {
        //     $table->id('variasi_id');
        //     $table->foreignId('produk_id');
        //     $table->string('nama_variasi');
        //     $table->decimal('harga_beli', 15, 2);
        //     $table->decimal('harga_jual', 15, 2);
        //     $table->integer('stok');
        //     $table->integer('berat_produk');
        //     $table->timestamps();
        //
        //     $table->foreign('produk_id')->references('produk_id')->on('tb_produk');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_variasi_produk');
    }
};
