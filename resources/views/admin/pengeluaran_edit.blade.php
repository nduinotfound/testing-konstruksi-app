<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran Kas Proyek</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-16 antialiased">

    <!-- Header Navigasi -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.proyek.show', $proyek->id) }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-base text-gray-800 tracking-tight leading-none">Koreksi Pengeluaran</h2>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">{{ $proyek->nama_proyek }}</p>
            </div>
        </div>
        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">Mode Koreksi Biaya</span>
    </div>

    <div class="max-w-xl mx-auto px-4 mt-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">

            <form action="{{ route('admin.proyek.update_pengeluaran', $pengeluaran->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-wide mb-1">Tipe Pengeluaran</label>
                        <select name="tipe_pengeluaran" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                            <option value="Logistik Material" {{ $pengval = $pengeluaran->tipe_pengeluaran == 'Logistik Material' ? 'selected' : '' }}>Logistik Material</option>
                            <option value="Operasional Lapangan" {{ $pengeluaran->tipe_pengeluaran == 'Operasional Lapangan' ? 'selected' : '' }}>Operasional Lapangan</option>
                            <option value="Sewa Alat Berat" {{ $pengeluaran->tipe_pengeluaran == 'Sewa Alat Berat' ? 'selected' : '' }}>Sewa Alat Berat</option>
                            <option value="Konsumsi & Lembur" {{ $pengeluaran->tipe_pengeluaran == 'Konsumsi & Lembur' ? 'selected' : '' }}>Konsumsi & Lembur</option>
                            <option value="Lainnya" {{ !in_array($pengeluaran->tipe_pengeluaran, ['Logistik Material','Operasional Lapangan','Sewa Alat Berat','Konsumsi & Lembur']) ? 'selected' : '' }}>Lainnya...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-wide mb-1">Tanggal Nota</label>
                        <input type="date" name="tanggal" value="{{ $pengeluaran->tanggal }}" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-wide mb-1">Nama Material / Keterangan</label>
                    <input type="text" name="nama_material" value="{{ $pengeluaran->nama_material }}" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Qty</label>
                        <input type="number" id="input-qty" name="qty" value="{{ $pengeluaran->qty }}" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Satuan</label>
                        <input type="text" name="satuan" value="{{ $pengeluaran->satuan }}" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Harga Satuan</label>
                        <input type="number" id="input-harga" name="harga_satuan" value="{{ $pengeluaran->harga_satuan }}" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 border-t border-gray-100 pt-3">
                    <div>
                        <label class="block text-[9px] font-bold text-gray-400 uppercase">PPN (Nominal Rp)</label>
                        <input type="number" id="input-ppn" name="ppn" value="{{ $pengeluaran->ppn }}" placeholder="0" class="w-full bg-gray-50 border border-gray-200 focus:bg-white rounded-lg px-2.5 py-2 text-xs font-bold text-gray-800 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Harga Total Baru</label>
                        <input type="number" id="input-total" readonly value="{{ $pengeluaran->harga_total }}" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-black text-amber-600 outline-none">
                    </div>
                </div>

                <div class="pt-2 flex space-x-2">
                    <a href="{{ route('admin.proyek.show', $proyek->id) }}" class="w-1/3 text-center bg-gray-100 text-gray-600 font-bold text-xs py-3.5 rounded-xl hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-amber-500 hover:bg-amber-600 text-white font-black text-xs tracking-wider uppercase py-3.5 rounded-xl shadow-xs transition">
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Preview Hitung Otomatis Pas Diedit -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const qty = document.getElementById('input-qty');
            const harga = document.getElementById('input-harga');
            const ppn = document.getElementById('input-ppn');
            const total = document.getElementById('input-total');

            function hitungUlang() {
                const q = parseFloat(qty.value) || 0;
                const h = parseFloat(harga.value) || 0;
                const p = parseFloat(ppn.value) || 0;
                total.value = (q * h) + p;
            }

            qty.addEventListener('input', hitungUlang);
            harga.addEventListener('input', hitungUlang);
            ppn.addEventListener('input', hitungUlang);
        });
    </script>
</body>
</html>
