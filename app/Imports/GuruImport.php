<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GuruImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip if NAMA (index 1) is empty
        if (empty($row[1])) {
            return null;
        }

        // Get NAMA, NIP, JABATAN, and NOMOR REKENING
        $nama = $row[1];
        $nip = $row[2] ?? '-';
        $jabatan = $row[3] ?? null;
        $noRekening = $row[4] ?? null;

        return Guru::updateOrCreate(
            ['nomor' => (string) $nip], // Key for search
            [
                'nama' => $nama,
                'jabatan' => $jabatan,
                'nomor_rekening' => (string) $noRekening,
            ]
        );
    }

    /**
     * Start from row 2 (skip header)
     */
    public function startRow(): int
    {
        return 2;
    }
}
