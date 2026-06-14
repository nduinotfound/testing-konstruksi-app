<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Proyek;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Menampilkan halaman form absensi + rekap riwayat pribadi mandor
    public function create()
    {
        // 1. Ambil data proyek yang statusnya masih aktif berjalan untuk dropdown
        $proyeks = Proyek::where('status', 'berjalan')->get();

        // 2. Ambil riwayat absensi khusus milik mandor yang sedang login saat ini
        $absensis = Absensi::with('proyek')
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        // 3. Lempar kedua variabel ($proyeks dan $absensis) ke dalam view
        return view('mandor.absensi', compact('proyeks', 'absensis'));
    }

    // Fungsi untuk memproses simpan jepretan absen dari kamera
    public function store(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required|exists:proyeks,id',
            'status' => 'required|in:hadir,izin,sakit',
            'foto_selfie' => 'nullable|string', // Menyesuaikan nama input hidden HTML
        ]);

        $absensi = new \App\Models\Absensi();
        $absensi->user_id = auth()->id();
        $absensi->proyek_id = $request->proyek_id;
        $absensi->tanggal = now()->format('Y-m-d');
        $absensi->jam_masuk = now()->format('H:i:s');
        $absensi->status = $request->status;

        // Proses simpan jepretan kamera murni ke folder public bebas hambatan Windows
        if ($request->status == 'hadir' && $request->foto_selfie) {
            $img = $request->foto_selfie;
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $namaFoto = time() . '_' . auth()->id() . '.jpg';
            $folderPath = public_path('uploads/absensi');

            // Bikin foldernya otomatis di folder public utama kalau belum ada
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            file_put_contents($folderPath . '/' . $namaFoto, $data);

            // Simpan nama file murni ke database
            $absensi->foto_selfie = $namaFoto;
        }

        $absensi->save();

        return redirect()->route('mandor.absensi.create')->with('success', 'Presensi kehadiran masuk hari ini berhasil dikirim!');
    }
}
