<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => fake()->name,
            'email' => fake()->email,
            "role" => random_int(1, 10) % 2 == 0 ? 'member' : 'manager',
            "password" => Hash::make('123123')
        ]);
    }
}
