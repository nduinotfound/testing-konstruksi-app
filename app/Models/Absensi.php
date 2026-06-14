<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $fillable = [
        'proyek_id',
        'user_id',
        'tanggal',
        'jam_masuk',
        'status',
        'foto_selfie',
    ];

    // Hubungan Relasi: Data absensi ini milik proyek mana
    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }

    // Hubungan Relasi: Data absensi ini mencatat user (mandor) siapa
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
