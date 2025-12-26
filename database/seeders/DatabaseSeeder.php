<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'admin@smkn4bogor.local')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@smkn4bogor.local',
                'password' => bcrypt('password'), // Ensure password is set
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Seed guru data
        $this->call([
                // GuruSeeder::class,
            RealGuruSeeder::class,
            GuruUserSeeder::class,
        ]);
    }
}
