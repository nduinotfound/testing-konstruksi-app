<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    // Mendaftarkan kolom yang boleh diisi data
    protected $fillable = [
        'nama_proyek',
        'lokasi',
        'tanggal_mulai',
        'deadline',
        'status',
    ];

    // Hubungan Relasi: Satu proyek bisa memiliki banyak data absensi mandor
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
    // Relasi ke Laporan Harian (Satu proyek punya banyak laporan progres)
    public function laporanHarians()
    {
        return $this->hasMany(LaporanHarian::class);
    }

    // Relasi ke Nota Belanja (Satu proyek punya banyak nota pengeluaran uang)
    public function notaBelanjas()
    {
        return $this->hasMany(NotaBelanja::class);
    }

    // Relasi ke Material Sisa (Satu proyek punya rekap material sisa di gudang lapangan)
    public function materialSisas()
    {
        return $this->hasMany(MaterialSisa::class);
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    public function absenPekerjas()
    {
        return $this->hasMany(AbsenPekerja::class);
    }
}
