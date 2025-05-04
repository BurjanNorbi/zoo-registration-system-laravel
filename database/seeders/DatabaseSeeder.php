<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'q@q.hu',
            'admin' => true,
            'password' => Hash::make('q'),
        ]);

        User::factory()->create([
            'name' => 'Nem Admin',
            'email' => 'w@w.hu',
            'admin' => false,
            'password' => Hash::make('w'),
        ]);

        User::factory()->count(20)->create();

        $this->call([
            EnclosureSeeder::class,
            AnimalSeeder::class,
        ]);
    }
}
