<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;
use App\Models\Proyek;
use App\Models\AbsenPekerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LaporanHarianController extends Controller
{
    /**
     * Menampilkan form input laporan harian mandor
     */
    public function create()
    {
        // Ambil semua proyek yang statusnya masih berjalan untuk dipilih oleh mandor
        $proyeks = Proyek::where('status', 'berjalan')->get();

        return view('mandor.laporan_create', compact('proyeks'));
    }

    /**
     * Menyimpan data laporan harian ke database (BEBAS UKURAN GAMBAR & DIJAMIN JADI SATU PER HARI)
     */
    public function store(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required|exists:proyeks,id',
            'tanggal' => 'required|date',
            'keterangan_progres' => 'required|string',
            'foto_progres' => 'required|array',
            'foto_progres.*' => 'image|mimes:jpeg,png,jpg,webp',
        ]);

        try {
            if ($request->hasFile('foto_progres')) {
                $pathTujuan = public_path('uploads/laporan');
                if (!file_exists($pathTujuan)) {
                    mkdir($pathTujuan, 0755, true);
                }

                // Wadah untuk mengumpulkan semua nama file foto
                $arrNamaFile = [];

                foreach ($request->file('foto_progres') as $file) {
                    $namaFile = time() . '_' . uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move($pathTujuan, $namaFile);

                    // Masukkan nama file ke wadah array
                    $arrNamaFile[] = $namaFile;
                }

                // FIX UTAMA: Gabungkan array nama file menjadi satu string dipisah koma (contoh: foto1.jpg,foto2.jpg)
                $fotoGabungan = implode(',', $arrNamaFile);

                // SIMPAN SEKALI SAJA KE DATABASE (Satu hari, satu catatan, banyak foto)
                LaporanHarian::create([
                    'proyek_id' => $request->proyek_id,
                    'user_id' => auth()->id(),
                    'tanggal' => $request->tanggal,
                    'keterangan_progres' => $request->keterangan_progres,
                    'foto_progres' => $fotoGabungan, // String kumpulan nama foto
                ]);

                return redirect()->route('mandor.dashboard')->with('success', 'Laporan progres harian berhasil dikirim ke kantor pusat!');
            }

            return redirect()->back()->withInput()->withErrors(['foto_progres' => 'Gagal membaca file foto.']);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan riwayat laporan harian yang pernah dikirim oleh mandor tersebut
     */
    public function riwayat()
    {
        $laporans = LaporanHarian::with('proyek')
            ->where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('mandor.laporan_riwayat', compact('laporans'));
    }

    /**
     * FIX TOTAL (Penyelamat Eror): Menampilkan Form Absen Dinamis Mandiri
     */
    /**
     * FIX DROPDOWN: Menampilkan Form Absen dengan Pilihan Proyek Dinamis
     */
    public function createAbsenPekerja(Request $request)
    {
        // Ambil semua proyek yang berstatus berjalan untuk isi select dropdown
        $proyeks = Proyek::where('status', 'berjalan')->get();

        // Tangkap id proyek pilihan mandor (jika ada yang dipilih)
        $proyekTerpilihId = $request->get('proyek_id');
        $proyek = null;
        $absenHariIni = collect();

        if ($proyekTerpilihId) {
            $proyek = Proyek::find($proyekTerpilihId);
            if ($proyek) {
                // Tarik riwayat absen khusus proyek terpilih yang tanggalnya hari ini
                $absenHariIni = $proyek->absenPekerjas()->where('tanggal', now()->format('Y-m-d'))->get();
            }
        }

        return view('mandor.absen_pekerja', compact('proyeks', 'proyek', 'proyekTerpilihId', 'absenHariIni'));
    }

    /**
     * FIX DROPDOWN: Menyimpan data berdasarkan proyek_id yang dipilih dari form
     */
    public function storeAbsenPekerja(Request $request)
    {
        // Validasi wajib menyertakan proyek_id pilihan dropdown
        $request->validate([
            'proyek_id' => 'required|exists:proyeks,id',
            'pekerja' => 'required|array',
            'pekerja.*.nama' => 'required|string',
            'pekerja.*.status' => 'required|in:hadir,izin,alfa',
        ]);

        $mandorId = Auth::id();
        $tanggalHariIni = now()->format('Y-m-d');
        $proyekId = $request->proyek_id;

        foreach ($request->pekerja as $data) {
            if (!empty(trim($data['nama']))) {
                AbsenPekerja::updateOrCreate(
                    [
                        'proyek_id' => $proyekId,
                        'nama_pekerja' => trim($data['nama']),
                        'tanggal' => $tanggalHariIni,
                    ],
                    [
                        'status_kehadiran' => $data['status'],
                        'created_by' => $mandorId,
                    ]
                );
            }
        }

        // Kembalikan ke halaman dengan membawa parameter proyek_id agar dropdown tidak reset setelah save
        return redirect()->route('mandor.absen.create', ['proyek_id' => $proyekId])
                         ->with('success', 'Absensi regu pekerja berhasil disimpan dan dikunci!');
    }
}
