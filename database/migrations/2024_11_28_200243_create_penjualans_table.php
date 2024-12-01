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
        Schema::create('tb_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->foreignId('produk_id');
            $table->date('tgl_pesanan');
            $table->decimal('harga_jual', 15, 2);
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('produk_id')->references('produk_id')->on('tb_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_penjualan');
    }
};
