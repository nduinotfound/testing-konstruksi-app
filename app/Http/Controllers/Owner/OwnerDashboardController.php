<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\LaporanHarian;
use App\Models\NotaBelanja;
use App\Models\MaterialSisa;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    // Halaman Dashboard Utama Owner (Melihat daftar proyek milik dia)
    public function index()
    {
        // Berasumsi model Proyek kamu memiliki relasi user_id atau owner_id.
        // Jika semua proyek bisa dilihat owner, gunakan Proyek::latest()->get()
        $proyeks = Proyek::latest()->get();

        return view('owner.dashboard', compact('proyeks'));
    }

    // Halaman Detail Proyek Khusus Owner (Pantau Progres Fisik & Logistik Tanpa Anggaran Uang)
    public function showProyek($id)
    {
        $proyek = Proyek::findOrFail($id);

        // 1. Ambil Log Progres Fisik Lapangan
        $laporanHarians = LaporanHarian::with('user')
            ->where('proyek_id', $id)
            ->latest('tanggal')
            ->get();

        // 2. Ambil Log Bukti Nota Belanja (Hanya untuk dokumentasi barang masuk)
        $notaBelanjas = NotaBelanja::with('user')
            ->where('proyek_id', $id)
            ->latest('tanggal')
            ->get();

        // 3. Ambil Kendali Sisa Material Gudang Saat Ini
        $materialSisas = MaterialSisa::with('user')
            ->where('proyek_id', $id)
            ->latest()
            ->get();

        return view('owner.proyek_detail', compact('proyek', 'laporanHarians', 'notaBelanjas', 'materialSisas'));
    }
}
