<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Check if the user already exists
        if (!User::where('email', 'diallo@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Diallo',
                'prenom' => 'Mohamed',
                'email' => 'diallo@gmail.com',
                'password' => '123456789',
                'role' => 'admin',
            ]);
        }
    }
}
