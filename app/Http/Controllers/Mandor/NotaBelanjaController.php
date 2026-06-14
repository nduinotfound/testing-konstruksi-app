<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\NotaBelanja;
use App\Models\Proyek;
use Illuminate\Http\Request;

class NotaBelanjaController extends Controller
{
    // 1. Menampilkan form input foto nota belanja
    public function create()
    {
        // Ambil proyek yang statusnya masih berjalan
        $proyeks = Proyek::where('status', 'berjalan')->get();
        return view('mandor.nota_create', compact('proyeks'));
    }

    // 2. Memproses simpan data foto nota (FIX ANTI-DOUBLE / ANTI-TERPISAH)
    public function store(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required|exists:proyeks,id',
            'tanggal' => 'required|date',
            'foto_nota' => 'required|array',
            'foto_nota.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('foto_nota')) {
                $pathTujuan = public_path('uploads/nota');
                if (!file_exists($pathTujuan)) {
                    mkdir($pathTujuan, 0755, true);
                }

                // 1. Wadah kosong untuk menampung kumpulan nama file nota
                $arrNamaFile = [];

                // 2. LOOP PERTAMA: Pindahkan file fisik dan catat namanya ke array
                foreach ($request->file('foto_nota') as $file) {
                    // Buat nama unik untuk masing-masing foto nota
                    $namaFoto = time() . '_nota_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Pindahkan file ke folder public/uploads/nota/
                    $file->move($pathTujuan, $namaFoto);

                    // Masukkan nama file ke wadah celengan
                    $arrNamaFile[] = $namaFoto;
                }

                // 3. Gabungkan semua nama file menjadi string tunggal dipisah koma (contoh: nota1.jpg,nota2.jpg)
                $fotoGabungan = implode(',', $arrNamaFile);

                // 4. FIX UTAMA: Panggil CREATE SEKALI SAJA di luar foreach agar jadi satu kelompok per hari
                NotaBelanja::create([
                    'proyek_id' => $request->proyek_id,
                    'user_id' => auth()->id(),
                    'tanggal' => $request->tanggal,
                    'foto_nota' => $fotoGabungan, // String kumpulan nama nota
                    'nama_barang' => '-',
                    'jumlah' => 0,
                    'satuan' => '-',
                    'total_harga' => 0,
                ]);

                return redirect()->route('mandor.dashboard')->with('success', 'Semua foto nota belanja berhasil dikelompokkan dan dikirim ke Admin!');
            }

            return redirect()->back()->withInput()->withErrors(['foto_nota' => 'Gagal membaca file foto nota.']);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
}
