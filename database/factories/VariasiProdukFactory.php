<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariasiProduk>
 */
class VariasiProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'produk_id' => fake()->numberBetween(1, 10),
            'nama_variasi' => fake()->name(),
            'harga_beli' => fake()->numberBetween(1000, 999999),
            'harga_jual' => fake()->numberBetween(1000, 999999),
            'stok' => fake()->numberBetween(1000, 999999),
            'berat_produk' => fake()->numberBetween(1000, 999999),
        ];
    }
}
