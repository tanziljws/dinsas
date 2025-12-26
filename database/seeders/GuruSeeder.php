<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            ['nama' => 'Ahmad Fauzi, S.Pd.', 'nomor' => '198501152010011001'],
            ['nama' => 'Siti Nurhaliza, M.Pd.', 'nomor' => '198703202011012002'],
            ['nama' => 'Budi Santoso, S.Pd.', 'nomor' => '197905102008011003'],
            ['nama' => 'Dewi Rahmawati, S.Pd.', 'nomor' => '198812252012012004'],
            ['nama' => 'Eko Prasetyo, M.Pd.', 'nomor' => '198607302009011005'],
            ['nama' => 'Fitri Handayani, S.Pd.', 'nomor' => '199001052014012006'],
            ['nama' => 'Gunawan Wibowo, S.Pd.', 'nomor' => '198504122007011007'],
            ['nama' => 'Hesti Kusuma, M.Pd.', 'nomor' => '198908182013012008'],
            ['nama' => 'Irfan Hakim, S.Pd.', 'nomor' => '198710222010011009'],
            ['nama' => 'Joko Widodo, S.Pd.', 'nomor' => '198206152006011010'],
        ];

        foreach ($gurus as $guruData) {
            // Create Guru
            $guru = Guru::create($guruData);

            // Create User for this Guru
            $user = \App\Models\User::create([
                'name' => $guru->nama,
                'email' => $guru->nomor . '@smkn4bogor.local', // Email dummy based on NIP
                'password' => bcrypt($guru->nomor), // Default password is NIP
                'role' => 'guru',
            ]);

            // Link Guru to User
            $guru->update(['user_id' => $user->id]);
        }
    }
}
