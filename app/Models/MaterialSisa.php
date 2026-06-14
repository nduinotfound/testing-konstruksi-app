<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSisa extends Model
{
    use HasFactory;

    // Pastikan semua kolom baru ini diizinkan untuk diisi massal
    protected $fillable = [
        'proyek_id',
        'user_id',
        'nama_material',
        'jumlah_sisa',
        'satuan'
    ];

    /**
     * Relasi balik ke tabel Proyek (Setiap data sisa material punya 1 proyek)
     */
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    /**
     * Relasi balik ke tabel User/Mandor (Setiap data sisa material dicatat oleh 1 mandor)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
