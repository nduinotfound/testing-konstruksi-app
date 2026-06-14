<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AuditAbsensiController extends Controller
{
    // Menampilkan seluruh log absensi mandor yang masuk ke sistem
    public function index()
    {
        // Ambil semua data absensi, gabungkan dengan relasi data proyek dan user (mandor)
        $absensis = Absensi::with(['proyek', 'user'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.audit', compact('absensis'));
    }
}
