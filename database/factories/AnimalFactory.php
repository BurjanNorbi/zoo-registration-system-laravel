<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagename = fake()->boolean();
        return [
            'name' => fake()->name(),
            'species' => fake()->name(),
            'is_predator' => fake()->boolean(),
            'born_at' => fake()->dateTimeBetween('-20 years', 'now'),
            'imagename' => $imagename ? 'image.jpg' : null,
            'imagename_hash' => $imagename ? 'image.jpg' : null,
        ];
    }
}
