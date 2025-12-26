<?php

namespace App\Exports;

use App\Models\PerjalananDinas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PerjalananDinasExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $startDate;
    protected $endDate;
    protected $jenis;

    public function __construct($startDate = null, $endDate = null, $jenis = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->jenis = $jenis;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = PerjalananDinas::with('guru')->orderBy('created_at', 'desc');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        if ($this->jenis && $this->jenis !== 'Semua') {
            $query->where('jenis', $this->jenis);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'NIP',
            'Jabatan',
            'Tanggal Submit',
            'Nomor Surat',
            'Tanggal Surat',
            'Tanggal Berangkat',
            'Jenis',
            'Lama',
            'Nama Kegiatan',
            'Nama Instansi',
            'Alamat Instansi',
            'Pengikut 1',
            'Pengikut 2',
            'Pengikut 3',
            'Status',
            'Alasan Ditolak',
        ];
    }

    /**
     * @param PerjalananDinas $row
     * @return array
     */
    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->guru->nama ?? '-',
            $row->guru->nomor ?? '-',
            $row->guru->jabatan ?? '-',
            $row->created_at->format('d/m/Y H:i'),
            $row->nomor_surat,
            $row->tanggal_surat->format('d/m/Y'),
            $row->tanggal_berangkat->format('d/m/Y'),
            $row->jenis,
            $row->lama,
            $row->nama_kegiatan,
            $row->nama_instansi,
            $row->alamat_instansi,
            $row->nama_pengikut1 ?? '-',
            $row->nama_pengikut2 ?? '-',
            $row->nama_pengikut3 ?? '-',
            $row->status,
            $row->alasan_ditolak ?? '-',
        ];
    }

    /**
     * Style the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
