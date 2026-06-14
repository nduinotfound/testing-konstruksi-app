<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id',
        'tipe_pengeluaran',
        'tanggal',
        'nama_material',
        'qty',
        'satuan',
        'harga_satuan',
        'harga_total',
        'ppn'
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }
}
