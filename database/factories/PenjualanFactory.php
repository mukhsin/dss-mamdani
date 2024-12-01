<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualan>
 */
class PenjualanFactory extends Factory
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
            'tgl_pesanan' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'qty' => fake()->numberBetween(1, 100),
            'harga_jual' => fake()->numberBetween(10000, 100000),
        ];
    }
}
