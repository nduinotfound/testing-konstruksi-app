<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\MaterialSisa;
use App\Models\Proyek;
use Illuminate\Http\Request;

class MaterialSisaController extends Controller
{
    // Menampilkan form input sisa material
    public function create()
    {
        $proyeks = Proyek::where('status', 'berjalan')->get();
        return view('mandor.material_create', compact('proyeks'));
    }

    // Memproses simpan / update BANYAK data sisa material sekaligus
    public function store(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required|exists:proyeks,id',
            'materials' => 'required|array|min:1',
            'materials.*.nama_material' => 'required|string|max:255',
            'materials.*.jumlah_sisa' => 'required|integer|min:0',
            'materials.*.satuan' => 'required|string|max:50',
        ]);

        foreach ($request->materials as $item) {
            if (!empty($item['nama_material'])) {
                // Gunakan kombinasi proyek, user, dan nama barang untuk update atau create baru
                MaterialSisa::create([
                    'proyek_id' => $request->proyek_id,
                    'user_id' => auth()->id(), // Mencatat ID Mandor pemicu upload
                    'nama_material' => trim(strtolower($item['nama_material'])),
                    'jumlah_sisa' => $item['jumlah_sisa'],
                    'satuan' => $item['satuan'],
                ]);
            }
        }

        return redirect()->route('mandor.dashboard')->with('success', 'Data sisa material berhasil dilaporkan!');
    }
}
