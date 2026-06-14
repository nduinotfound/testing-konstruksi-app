<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaBelanja extends Model
{
    protected $fillable = ['proyek_id', 'user_id', 'tanggal', 'nama_barang', 'jumlah', 'satuan', 'total_harga', 'foto_nota'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
