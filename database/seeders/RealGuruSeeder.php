<?php

namespace Database\Seeders;

use App\Imports\GuruImport;
use App\Models\Guru;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class RealGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Clear existing guru data to avoid duplicates/mess
        // Guru::truncate(); // Be careful if foreign keys exist. 
        // Better: delete all guru that are not used? Or just keep adding. 
        // User asked to "dirapihkan", so let's try to start fresh if possible.
        // But PerjalananDinas has foreign key.
        // So better just updateOrCreate (handled in Import) and maybe delete dummy ones?
        // Let's delete the dummy ones created by previous seeder if we can identify them, but we can't easily.
        // I'll just run the import. The import uses updateOrCreate so it's safe.

        $path = base_path('Master nama dan rekening.xlsx');

        if (file_exists($path)) {
            $this->command->info('Importing real guru data from ' . $path);
            Excel::import(new GuruImport, $path);
            $this->command->info('Guru data imported successfully.');
        } else {
            $this->command->error('File not found: ' . $path);
        }
    }
}
