<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenPekerja extends Model
{
    // 1. Izinkan kolom-kolom ini diisi secara massal lewat controller
    protected $fillable = [
        'proyek_id',
        'nama_pekerja',
        'status_kehadiran',
        'tanggal',
        'created_by',
    ];

    /**
     * HUBUNGAN RELASI: Setiap 1 baris absen dicatat oleh 1 Akun User (Mandor)
     * Ini dipakai di Blade bagian: $absenLap->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * HUBUNGAN RELASI: Setiap data absen terikat pada 1 Proyek
     */
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
}
