<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diskon>
 */
class DiskonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis_diskon' => fake()->name(),
            'besaran_diskon' => fake()->numberBetween(1, 100),
            'keterangan' => fake()->realText(),
        ];
    }
}
