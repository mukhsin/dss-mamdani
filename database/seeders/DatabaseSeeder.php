<?php

namespace Database\Seeders;

use App\Models\Diskon;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VariasiProduk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        Produk::factory(10)->create();
        // VariasiProduk::factory(50)->create();

        Diskon::factory(50)->create();
        Penjualan::factory(500)->create();
    }
}
