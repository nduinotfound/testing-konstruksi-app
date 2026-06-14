<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\AbsenPekerja;
use App\Models\Pengeluaran; // Memanggil model pengeluaran baru
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    // 1. Menampilkan daftar proyek & form tambah
    public function index()
    {
        $proyeks = Proyek::orderBy('id', 'desc')->get();
        return view('admin.proyek', compact('proyeks'));
    }

    // 2. Memproses simpan proyek baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:perencanaan,berjalan,selesai,tertunda',
        ]);

        Proyek::create($request->all());

        return redirect()->route('admin.proyek.index')->with('success', 'Data proyek baru berhasil ditambahkan!');
    }

    // 3. Menampilkan form edit proyek
    public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyeks = Proyek::orderBy('id', 'desc')->get();
        return view('admin.proyek', compact('proyek', 'proyeks'));
    }

    // 4. Memproses update data proyek
    public function update(Request $request, $id)
    {
        $proyek = Proyek::findOrFail($id);

        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:perencanaan,berjalan,selesai,tertunda',
        ]);

        $proyek->update($request->all());

        return redirect()->route('admin.proyek.index')->with('success', 'Data proyek berhasil diperbarui!');
    }

    // 5. Memproses hapus proyek
    public function destroy($id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyek->delete();

        return redirect()->route('admin.proyek.index')->with('success', 'Data proyek berhasil erased dari sistem!');
    }

    // 6. Menampilkan detail audit logistik, nota, progres, DAN DETAIL CATATAN PENGELUARAN (FIXED)
    public function show($id)
    {
        // Ambil data proyek beserta semua data laporan harian, nota belanja, sisa material, dan pengeluaran admin
        $proyek = Proyek::with([
            'laporanHarians.user',
            'notaBelanjas.user',
            'materialSisas',
            'pengeluarans' // Load relasi pengeluaran mandiri
        ])->findOrFail($id);

        // FIX SAKTI: Hitung total pengeluaran murni berdasarkan kolom 'harga_total' bawaan form kamu, Ndut!
        $totalPengeluaran = $proyek->pengeluarans->sum('harga_total');

        return view('admin.proyek_detail', compact('proyek', 'totalPengeluaran'));
    }

    // 7. Memproses simpan pengeluaran baru yang diinput oleh Admin (FIXED ARRAY STORAGE)
    public function storePengeluaran(Request $request)
    {
        // Validasi inputan utama dan inputan array material
        $request->validate([
            'proyek_id' => 'required|exists:proyeks,id',
            'tipe_pengeluaran' => 'required|string',
            'tanggal' => 'required|date',
            'nama_material' => 'required|array',
            'nama_material.*' => 'required|string|max:255',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
            'satuan' => 'required|array',
            'satuan.*' => 'required|string',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        // Loop sebanyak barang yang diinput oleh Admin di form dinamis
        foreach ($request->nama_material as $index => $material) {
            // Ambil nominal PPN, jika kosong atau null otomatis anggap 0 demi keselamatan kalkulasi
            $nominalPpn = $request->ppn[$index] ?? 0;

            // Hitung harga total secara paksa di backend biar gak bisa dimanipulasi inspect element browser
            $hitungTotal = ($request->qty[$index] * $request->harga_satuan[$index]) + $nominalPpn;

            Pengeluaran::create([
                'proyek_id' => $request->proyek_id,
                'tipe_pengeluaran' => $request->tipe_pengeluaran,
                'tanggal' => $request->tanggal,
                'nama_material' => $material,
                'qty' => $request->qty[$index],
                'satuan' => $request->satuan[$index],
                'harga_satuan' => $request->harga_satuan[$index],
                'ppn' => $nominalPpn,
                'harga_total' => $hitungTotal, // Mengisi kolom harga_total yang valid
            ]);
        }

        return redirect()->back()->with('success', 'Semua rincian nota pengeluaran material berhasil dicatat ke kas proyek!');
    }

    // 8. Menampilkan halaman form edit pengeluaran spesifik
    public function editPengeluaran($id)
    {
        // Cari data pengeluaran yang mau diedit
        $pengeluaran = Pengeluaran::findOrFail($id);

        // Ambil data proyek terkait untuk navigasi kembali
        $proyek = Proyek::findOrFail($pengeluaran->proyek_id);

        return view('admin.pengeluaran_edit', compact('pengeluaran', 'proyek'));
    }

    // 9. Memproses update data pengeluaran ke database
    public function updatePengeluaran(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        $request->validate([
            'tipe_pengeluaran' => 'required|string',
            'tanggal'          => 'required|date',
            'nama_material'    => 'required|string|max:255',
            'qty'              => 'required|numeric|min:1',
            'satuan'           => 'required|string',
            'harga_satuan'     => 'required|numeric|min:0',
            'ppn'              => 'nullable|numeric|min:0',
        ]);

        $nominalPpn = $request->ppn ?? 0;

        // Hitung ulang harga total secara otomatis di backend
        $hitungTotal = ($request->qty * $request->harga_satuan) + $nominalPpn;

        // Update data ke database
        $pengeluaran->update([
            'tipe_pengeluaran' => $request->tipe_pengeluaran,
            'tanggal'          => $request->tanggal,
            'nama_material'    => $request->nama_material,
            'qty'              => $request->qty,
            'satuan'           => $request->satuan,
            'harga_satuan'     => $request->harga_satuan,
            'ppn'              => $nominalPpn,
            'harga_total'      => $hitungTotal,
        ]);

        // Tendang kembali ke halaman detail proyek semula dengan pesan sukses
        return redirect()->route('admin.proyek.show', $pengeluaran->proyek_id)
            ->with('success', 'Catatan pengeluaran berhasil diperbarui dan kas proyek telah disesuaikan!');
    }

    // 10. Memproses hapus data catatan pengeluaran spesifik
    public function destroyPengeluaran($id)
    {
        // Cari data pengeluaran kas yang dimaksud
        $pengeluaran = Pengeluaran::findOrFail($id);
        $proyekId = $pengeluaran->proyek_id;

        // Hapus data dari database
        $pengeluaran->delete();

        // Kembalikan ke halaman detail proyek dengan pesan sukses
        return redirect()->route('admin.proyek.show', $proyekId)
            ->with('success', 'Catatan rincian biaya berhasil dihapus permanen dan saldo kas proyek otomatis disesuaikan!');
    }

    public function showAbsenPekerja($id)
    {
        $proyek = Proyek::findOrFail($id);

        // Ambil data absen pekerja, kelompokkan berdasarkan tanggal terbaru
        $rekapAbsen = AbsenPekerja::where('proyek_id', $id)
            ->with('user') // Biar tahu mandor siapa yang mengabsenkan
            ->orderBy('tanggal', 'desc')
            ->get()
            ->groupBy('tanggal'); // Mengelompokkan data berdasarkan tanggal di Laravel

        return view('admin.proyek_absen_pekerja', compact('proyek', 'rekapAbsen'));
    }
}
