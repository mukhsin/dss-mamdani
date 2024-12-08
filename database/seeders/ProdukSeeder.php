<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_produk = [
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Sabun Wajah',      'berat_produk' => 80,       'harga_modal' => 20000,],
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Toner',            'berat_produk' => 80,       'harga_modal' => 20000,],
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Day Cream',        'berat_produk' => 30,       'harga_modal' => 35000,],
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Night Cream',      'berat_produk' => 30,       'harga_modal' => 35000,],
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Acne Serum',       'berat_produk' => 50,       'harga_modal' => 35000,],
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Glow Serum',       'berat_produk' => 50,       'harga_modal' => 35000,],
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Paket',            'berat_produk' => 300,      'harga_modal' => 100000,],
            ['nama_produk' => 'SHESILE BEAUTY GLOW - Paket + Serum',    'berat_produk' => 350,      'harga_modal' => 135000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Sabun Wajah',         'berat_produk' => 80,       'harga_modal' => 15000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Toner',               'berat_produk' => 80,       'harga_modal' => 15000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Day Cream',           'berat_produk' => 30,       'harga_modal' => 30000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Night Cream',         'berat_produk' => 30,       'harga_modal' => 30000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Acne Serum',          'berat_produk' => 50,       'harga_modal' => 30000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Glow Serum',          'berat_produk' => 50,       'harga_modal' => 30000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Paket',               'berat_produk' => 300,      'harga_modal' => 90000,],
            ['nama_produk' => 'ERDHIRA SKINCARE - Paket + Serum',       'berat_produk' => 350,      'harga_modal' => 120000,],
        ];

        foreach ($list_produk as $produk) {
            Produk::create($produk);
        }
    }
}
