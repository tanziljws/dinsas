<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerjalananDinas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perjalanan_dinas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guru_id',
        'pengikut',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_berangkat',
        'jenis',
        'lama',
        'nama_kegiatan',
        'nama_instansi',
        'alamat_instansi',
        'file_path',
        'status',
        'alasan_ditolak',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_berangkat' => 'date',
        'pengikut' => 'array',
    ];

    /**
     * Get the guru that owns this perjalanan dinas.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }
}
