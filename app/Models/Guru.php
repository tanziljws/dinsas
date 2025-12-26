<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama',
        'nomor',
        'jabatan',
        'nomor_rekening',
    ];

    /**
     * Get the user account for this guru.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all perjalanan dinas for the guru.
     */
    public function perjalananDinas(): HasMany
    {
        return $this->hasMany(PerjalananDinas::class);
    }
}
