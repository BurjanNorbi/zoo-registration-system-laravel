<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Enclosure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enclosures = Enclosure::all();
        foreach($enclosures as $enclosure) {
            $limit = $enclosure->limit;
            $animalCount = fake()->numberBetween(0, $limit);
            $is_predator = fake()->boolean();
            Animal::factory()->count($animalCount)->state(['is_predator' => $is_predator])->for($enclosure)->create();
        }

        $archivedCount = 10;
        for ($i=0; $i < $archivedCount; $i++) {
            Animal::factory()->state(['deleted_at' => fake()->dateTimeBetween('-20 years', 'now')])->create();
        }
    }
}
