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
        Schema::create('tb_batas', function (Blueprint $table) {
            $table->id('batas_id');
            $table->integer('halaman');
            $table->decimal('batas_kecil_modal', 15, 2);
            $table->decimal('batas_sedang_modal', 15, 2);
            $table->decimal('batas_besar_modal', 15, 2);
            $table->decimal('batas_kecil_keuntungan', 15, 2);
            $table->decimal('batas_sedang_keuntungan', 15, 2);
            $table->decimal('batas_besar_keuntungan', 15, 2);
            $table->decimal('batas_kecil_diskon', 15, 2);
            $table->decimal('batas_sedang_diskon', 15, 2);
            $table->decimal('batas_besar_diskon', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_batas');
    }
};
