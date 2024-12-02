<?php

namespace Database\Seeders;

use App\Models\Diskon;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VariasiProduk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        User::factory()->create([
            'name' => 'Anita Wulandari',
            'email' => 'anitaawd@gmail.com',
        ]);
        $this->command->info('User table seeded!');

        // Produk::factory(10)->create();
        // VariasiProduk::factory(50)->create();

        Diskon::factory(50)->create();
        $this->command->info('Diskon table seeded!');
        // Penjualan::factory(500)->create();

        $path = 'database/dump/dml_tb_produk.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Produk table seeded!');

        $path = 'database/dump/dml_tb_penjualan.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Penjualan table seeded!');

    }
}
