<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruUserSeeder extends Seeder
{
    /**
     * Create user accounts for all guru using NIP as username and password.
     */
    public function run(): void
    {
        $gurus = Guru::whereNull('user_id')->get();

        foreach ($gurus as $guru) {
            // Create user with NIP as email (username) and password
            $user = User::create([
                'name' => $guru->nama,
                'email' => $guru->nomor . '@smkn4bogor.local', // NIP as email
                'password' => Hash::make($guru->nomor), // NIP as password
            ]);

            // Link user to guru
            $guru->update(['user_id' => $user->id]);

            $this->command->info("Created user for: {$guru->nama}");
        }

        $this->command->info("Total: {$gurus->count()} user accounts created.");
    }
}
