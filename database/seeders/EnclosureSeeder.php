<?php

namespace Database\Seeders;

use App\Models\Enclosure;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnclosureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enclosureCount = 100;
        for ($i=0; $i < $enclosureCount; $i++) {
            $tmpUsers = User::all()->random(5);
            Enclosure::factory()->hasAttached($tmpUsers)->create();
        }
    }
}
