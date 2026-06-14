<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialSisa;
use App\Models\Proyek;
use Illuminate\Http\Request;

class AdminMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialSisa::with(['proyek', 'user'])->latest();

        if ($request->has('proyek_id')) {
            $query->where('proyek_id', $request->proyek_id);
        }

        $allMaterials = $query->get();
        $groupedMaterials = $allMaterials->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });

        return view('admin.material_index', compact('groupedMaterials'));
    }

    public function exportReport(Request $request)
    {
        $query = MaterialSisa::with(['proyek', 'user'])->latest();

        if ($request->has('proyek_id')) {
            $query->where('proyek_id', $request->proyek_id);
        }

        $allMaterials = $query->get();
        $groupedMaterials = $allMaterials->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });

        return view('admin.material_export', compact('groupedMaterials'));
    }

    // Fungsi Cetak Laporan - BERSIH DARI KEUANGAN
    // Fungsi Cetak Laporan - BERSIH DARI KEUANGAN (FIXED TOTAL PENGELUARAN)
    public function exportProyekReport($id)
    {
        // Ambil data proyek beserta relasi pengeluaran kasnya, Ndut!
        $proyek = Proyek::with('pengeluarans')->findOrFail($id);

        $laporanHarians = \App\Models\LaporanHarian::with('user')
            ->where('proyek_id', $id)
            ->latest('tanggal')
            ->get();

        // Ambil data nota belanja murni untuk melihat foto bukti fisiknya saja
        $notaBelanjas = \App\Models\NotaBelanja::with('user')
            ->where('proyek_id', $id)
            ->latest('tanggal')
            ->get();

        // FIX UTAMA: Hitung total akumulasi pengeluaran murni dari kolom harga_total pengeluaran admin!
        $totalPengeluaran = $proyek->pengeluarans->sum('harga_total');

        // Kirimkan variabel $totalPengeluaran ke dalam compact view agar tidak undefined lagi!
        return view('admin.proyek_export', compact('proyek', 'laporanHarians', 'notaBelanjas', 'totalPengeluaran'));
    }
}
