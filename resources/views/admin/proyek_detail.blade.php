<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail & Audit Logistik Proyek</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-16 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.proyek.index') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-base text-gray-800 tracking-tight leading-none">{{ $proyek->nama_proyek }}</h2>
                <p class="text-[11px] text-gray-400 mt-1 font-medium flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    {{ $proyek->lokasi }}
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.proyek.absen_pekerja', $proyek->id) }}"
               class="bg-slate-900 hover:bg-black text-white font-black text-[10px] uppercase tracking-wider px-4 py-2 rounded-xl transition shadow-3xs flex items-center space-x-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>👥 Rekap Absen Pekerja</span>
            </a>
            <a href="{{ route('admin.proyek.export_all', $proyek->id) }}" target="_blank"
               class="bg-red-600 hover:bg-red-700 text-white font-black text-[10px] uppercase tracking-wider px-4 py-2 rounded-xl transition shadow-3xs flex items-center space-x-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Ekspor Rangkuman PDF</span>
            </a>

            <span class="text-[10px] font-black px-2.5 py-2 rounded-xl tracking-wider uppercase inline-block shadow-2xs text-white
                {{ $proyek->status == 'berjalan' ? 'bg-blue-600' : ($proyek->status == 'selesai' ? 'bg-green-600' : ($proyek->status == 'tertunda' ? 'bg-red-500' : 'bg-amber-500')) }}">
                {{ $proyek->status }}
            </span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        @if (session('success'))
            <div class="mb-6 p-4 text-sm bg-green-600 text-white font-bold rounded-xl shadow-xs">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Akumulasi Pengeluaran</p>
                    <h3 class="text-xl font-black text-gray-800 mt-0.5">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center space-x-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Struk/Nota Audit</p>
                    <h3 class="text-xl font-black text-gray-800 mt-0.5">{{ $proyek->notaBelanjas->count() }} Dokumen</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center space-x-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Log Progres Terkirim</p>
                    <h3 class="text-xl font-black text-gray-800 mt-0.5">{{ $proyek->laporanHarians->count() }} Hari</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
                    <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider mb-4 flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        1. Buku Log Progres Fisik Lapangan (Grouped By Date)
                    </h3>

                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                        @forelse($proyek->laporanHarians->groupBy('tanggal') as $tanggal => $logs)
                            <div class="border border-gray-100 rounded-xl overflow-hidden shadow-3xs">
                                <div class="bg-slate-900 px-4 py-2 flex items-center justify-between text-white text-[10px] font-black tracking-wider uppercase">
                                    <span>{{ date('l, d M Y', strtotime($tanggal)) }}</span>
                                    <span class="bg-blue-500/30 text-blue-300 px-2 py-0.5 rounded-full border border-blue-500/20">{{ $logs->count() }} Laporan</span>
                                </div>

                                <div class="divide-y divide-gray-50 bg-white">
                                    @foreach($logs as $laporan)
                                        <div class="p-4 flex flex-col space-y-3 hover:bg-gray-50/30 transition">
                                            <div class="font-sans">
                                                <div class="flex items-center space-x-2 text-[11px] font-black text-gray-800 mb-1">
                                                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded">Oleh: {{ $laporan->user->name ?? 'Mandor' }}</span>
                                                    <span class="text-gray-400 font-mono text-[10px]">{{ $laporan->created_at->format('H:i') }} WIB</span>
                                                </div>
                                                <p class="text-xs text-gray-600 leading-relaxed font-medium">{{ $laporan->keterangan_progres }}</p>
                                            </div>

                                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 pt-2 border-t border-gray-50">
                                                @foreach(explode(',', $laporan->foto_progres) as $index => $fProgres)
                                                    @if(!empty(trim($fProgres)))
                                                        <a href="{{ asset('uploads/laporan/' . trim($fProgres)) }}" target="_blank" class="block aspect-video rounded-lg overflow-hidden border border-gray-100 bg-gray-50 group">
                                                            <img src="{{ asset('uploads/laporan/' . trim($fProgres)) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-200" onerror="this.onerror=null; this.src='https://placehold.co/100&text=No+Image';">
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-xs text-gray-400 font-medium py-10 border border-dashed rounded-xl">Belum ada catatan log progres lapangan dari mandor.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
                    <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider mb-4 flex items-center">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                        2. Arsip Berkas Dokumentasi & Nota Belanja Logistik
                    </h3>

                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                        @forelse($proyek->notaBelanjas->groupBy('tanggal') as $tanggal => $notas)
                            <div class="border border-gray-100 rounded-xl overflow-hidden shadow-3xs">
                                <div class="bg-red-50/80 border-b border-red-100 px-4 py-2 flex items-center justify-between text-red-800 text-[10px] font-black tracking-wider uppercase">
                                    <span>{{ date('l, d M Y', strtotime($tanggal)) }}</span>
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full">{{ $notas->count() }} Struk</span>
                                </div>

                                <div class="divide-y divide-gray-50 bg-white p-4 space-y-4">
                                    @foreach($notas as $nota)
                                        <div class="border border-gray-100 rounded-xl p-3 bg-gray-50/30 space-y-3">
                                            <div class="flex items-center justify-between text-xs">
                                                <div>
                                                    <span class="font-bold text-gray-800 text-xs block">Diupload oleh: {{ $nota->user->name ?? 'Mandor' }}</span>
                                                    <span class="text-[10px] text-gray-400 font-mono mt-0.5 block">{{ $nota->created_at->format('H:i') }} WIB</span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 pt-2 border-t border-gray-100">
                                                @foreach(explode(',', $nota->foto_nota) as $index => $fNota)
                                                    @if(!empty(trim($fNota)))
                                                        <div class="relative aspect-square border border-gray-200 rounded-xl overflow-hidden bg-white shadow-3xs group">
                                                            <img src="{{ asset('uploads/nota/' . trim($fNota)) }}" class="w-full h-full object-cover">
                                                            <a href="{{ asset('uploads/nota/' . trim($fNota)) }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white font-bold text-[9px] uppercase tracking-wider">
                                                                Buka Foto
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-xs text-gray-400 font-medium py-12 border border-dashed rounded-xl">Belum ada dokumen foto nota yang diupload mandor.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider">3. Sisa Stok Material</h3>
                        </div>
                        <a href="{{ route('admin.material.index', ['proyek_id' => $proyek->id]) }}" class="text-[9px] font-black text-blue-600 hover:bg-blue-600 hover:text-white transition bg-blue-50 px-2.5 py-1.5 rounded-lg uppercase tracking-wider shadow-3xs">Lihat & Ekspor</a>
                    </div>

                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                        @forelse($proyek->materialSisas->groupBy(function($item) { return $item->created_at->format('Y-m-d'); }) as $tanggal => $items)
                            <div class="border border-gray-100 rounded-xl overflow-hidden shadow-3xs">
                                <div class="bg-gray-50/80 px-4 py-2 border-b border-gray-100 flex items-center justify-between text-xs">
                                    <span class="font-black text-slate-800 font-mono uppercase">{{ date('l, d M Y', strtotime($tanggal)) }}</span>
                                    <span class="text-[10px] text-gray-400 font-bold bg-white px-2 py-0.5 border border-gray-100 rounded">Opname Harian</span>
                                </div>
                                <div class="divide-y divide-gray-50 bg-white grid grid-cols-1 sm:grid-cols-2 gap-x-4 p-2">
                                    @foreach($items as $item)
                                        <div class="p-2.5 flex items-center justify-between text-xs hover:bg-gray-50/30 rounded-lg transition">
                                            <span class="font-bold text-gray-800 capitalize">{{ $item->nama_material }}</span>
                                            <span class="font-mono font-black text-amber-600 bg-amber-50 px-2.5 py-0.5 rounded-md border border-amber-100 text-[11px]">
                                                {{ $item->jumlah_sisa }} <span class="text-[9px] font-bold text-gray-400 font-sans">{{ $item->satuan }}</span>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-xs text-gray-400 font-medium py-10 border border-dashed rounded-xl">Tidak ada sisa material tercatat di proyek ini.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider">4. Buku Catatan Rincian Biaya & Pengeluaran Kas</h3>
                        </div>
                        <span class="text-[10px] font-mono bg-emerald-50 text-emerald-700 font-black px-2.5 py-1 rounded-xl">Buku Jurnal Admin</span>
                    </div>

                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                        @forelse($proyek->pengeluarans->groupBy('tanggal') as $tanggal => $items)
                            <div class="border border-gray-100 rounded-xl overflow-hidden shadow-3xs">
                                <div class="bg-emerald-800 px-4 py-2 flex items-center justify-between text-white text-[10px] font-black tracking-wider uppercase">
                                    <span>📅 {{ date('l, d M Y', strtotime($tanggal)) }}</span>
                                    <span class="bg-white/20 px-2 py-0.5 rounded-md">Total Hari Ini: Rp {{ number_format($items->sum('harga_total'), 0, ',', '.') }}</span>
                                </div>

                                <div class="overflow-x-auto bg-white">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-slate-50 border-b border-gray-100 text-[9px] font-black text-gray-400 uppercase tracking-wider">
                                                <th class="py-2 px-4">Kategori / Barang</th>
                                                <th class="py-2 px-4 text-center">Volume</th>
                                                <th class="py-2 px-4 text-right">Harga Satuan</th>
                                                <th class="py-2 px-4 text-right">PPN</th>
                                                <th class="py-2 px-4 text-right">Total Net</th>
                                                <th class="py-2 px-4 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50 text-xs font-medium text-gray-600">
                                            @foreach($items as $item)
                                                <tr class="hover:bg-gray-50/50 transition">
                                                    <td class="py-2.5 px-4 font-sans">
                                                        <span class="text-[9px] font-bold text-slate-400 uppercase block leading-none mb-1">{{ $item->tipe_pengeluaran }}</span>
                                                        <span class="font-bold text-gray-800 capitalize">{{ $item->nama_material }}</span>
                                                    </td>
                                                    <td class="py-2.5 px-4 text-center font-mono text-gray-700">
                                                        {{ $item->qty }} <span class="text-[9px] font-sans text-gray-400 font-bold">{{ $item->satuan }}</span>
                                                    </td>
                                                    <td class="py-2.5 px-4 text-right font-mono text-gray-500">
                                                        {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                                    </td>
                                                    <td class="py-2.5 px-4 text-right font-mono text-red-500">
                                                        {{ $item->ppn > 0 ? number_format($item->ppn, 0, ',', '.') : '-' }}
                                                    </td>
                                                    <td class="py-2.5 px-4 text-right font-mono font-black text-emerald-600 bg-emerald-50/20">
                                                        {{ number_format($item->harga_total, 0, ',', '.') }}
                                                    </td>
                                                    <td class="py-2.5 px-4 text-center whitespace-nowrap">
                                                        <div class="flex items-center justify-center space-x-2">
                                                            <!-- Tombol Edit -->
                                                            <a href="{{ route('admin.proyek.edit_pengeluaran', $item->id) }}" class="text-[10px] font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white transition px-2.5 py-1 rounded-md shadow-3xs">
                                                                ✏️ Edit
                                                            </a>

                                                            <!-- Form Tombol Hapus (Wajib pakai POST + @method('DELETE') karena jalur HTTP Delete) -->
                                                            <form action="{{ route('admin.proyek.destroy_pengeluaran', $item->id) }}" method="POST" onsubmit="return confirm('Hapus catatan biaya {{ $item->nama_material }}? Saldo akumulasi pengeluaran proyek akan berkurang otomatis.')" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-[10px] font-bold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition px-2.5 py-1 rounded-md shadow-3xs">
                                                                    🗑️ Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-xs text-gray-400 font-medium py-12 border border-dashed rounded-xl">Belum ada rincian nota pengeluaran kas yang dicatat oleh Administrator.</div>
                        @endforelse
                    </div>
                </div>

            </div> <div class="lg:col-span-1 space-y-6">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sticky top-24">
                    <div class="flex items-center space-x-2 border-b border-gray-100 pb-3 mb-4">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider">Input Nota & Pengeluaran Material</h3>
                    </div>

                    <form action="{{ route('admin.proyek.store_pengeluaran') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="proyek_id" value="{{ $proyek->id }}">

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-wide mb-1">Tipe Pengeluaran</label>
                                <select id="select-tipe" name="tipe_pengeluaran" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                                    <option value="Logistik Material">Logistik Material</option>
                                    <option value="Operasional Lapangan">Operasional Lapangan</option>
                                    <option value="Sewa Alat Berat">Sewa Alat Berat</option>
                                    <option value="Konsumsi & Lembur">Konsumsi & Lembur</option>
                                    <option value="Lainnya">Lainnya...</option>
                                </select>

                                <div id="wrapper-tipe-kustom" class="mt-2 hidden">
                                    <label class="block text-[9px] font-bold text-emerald-600 uppercase mb-1">Tipe Kustom</label>
                                    <input type="text" id="input-tipe-kustom" placeholder="Sebutkan tipe pengeluaran" class="w-full bg-white border border-emerald-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-xl px-3 py-2 text-xs font-semibold text-gray-800 outline-none transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-wide mb-1">Tanggal Bayar/Nota</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                            </div>
                        </div>

                        <div id="wrapper-material" class="space-y-4 pt-2">
                            <div class="item-material border border-gray-100 p-4 rounded-xl bg-gray-50/50 space-y-3 relative">
                                <div class="grid grid-cols-1 gap-2">
                                    <div>
                                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Nama Material / Keterangan</label>
                                        <input type="text" name="nama_material[]" placeholder="Contoh: Semen Padang PCC" required class="w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Qty</label>
                                        <input type="number" name="qty[]" placeholder="0" required class="input-qty w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Satuan</label>
                                        <input type="text" name="satuan[]" placeholder="Sak / Btg" required class="w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Harga Satuan</label>
                                        <input type="number" name="harga_satuan[]" placeholder="Rp" required class="input-harga w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 border-t border-gray-100 pt-2">
                                    <div>
                                        <label class="block text-[9px] font-bold text-gray-400 uppercase">PPN (Nominal Rp)</label>
                                        <input type="number" name="ppn[]" placeholder="0" class="input-ppn w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-bold text-gray-800 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-bold text-gray-400 uppercase">Harga Total (+PPN)</label>
                                        <input type="number" name="harga_total[]" readonly placeholder="Otomatis" class="input-total w-full bg-gray-100 border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-black text-emerald-600 outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="btn-tambah-baris" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold text-[10px] tracking-wider uppercase py-2 rounded-xl transition shadow-3xs flex items-center justify-center space-x-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>+ Tambah Barang Lagi</span>
                        </button>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[10px] tracking-wider uppercase py-3 rounded-xl shadow-xs transition">
                            Simpan Nota & Update Kas
                        </button>
                    </form>
                </div>

            </div> </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const wrapper = document.getElementById("wrapper-material");
            const btnTambah = document.getElementById("btn-tambah-baris");
            const selectTipe = document.getElementById('select-tipe');
            const wrapperKustom = document.getElementById('wrapper-tipe-kustom');
            const inputKustom = document.getElementById('input-tipe-kustom');

            selectTipe.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    wrapperKustom.classList.remove('hidden');
                    inputKustom.setAttribute('name', 'tipe_pengeluaran');
                    inputKustom.setAttribute('required', 'required');
                    selectTipe.removeAttribute('name');
                    inputKustom.focus();
                } else {
                    wrapperKustom.classList.add('hidden');
                    selectTipe.setAttribute('name', 'tipe_pengeluaran');
                    inputKustom.removeAttribute('name');
                    inputKustom.removeAttribute('required');
                    inputKustom.value = '';
                }
            });

            function hitungBaris(element) {
                const row = element.closest('.item-material');
                if(!row) return;

                const qty = parseFloat(row.querySelector('.input-qty').value) || 0;
                const harga = parseFloat(row.querySelector('.input-harga').value) || 0;
                const ppn = parseFloat(row.querySelector('.input-ppn').value) || 0;

                const subTotal = qty * harga;
                const totalAkhir = subTotal + ppn;

                row.querySelector('.input-total').value = totalAkhir;
            }

            wrapper.addEventListener('input', function (e) {
                if (e.target.classList.contains('input-qty') ||
                    e.target.classList.contains('input-harga') ||
                    e.target.classList.contains('input-ppn')) {
                    hitungBaris(e.target);
                }
            });

            btnTambah.addEventListener("click", function () {
                const index = document.querySelectorAll('.item-material').length;
                const HTMLBarisBaru = `
                <div class="item-material border border-dashed border-gray-200 p-4 rounded-xl bg-gray-50/30 space-y-3 relative">
                    <button type="button" class="btn-hapus-baris absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-xs p-1">
                        ✕ Hapus
                    </button>
                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase">Nama Material / Keterangan (#${index + 1})</label>
                            <input type="text" name="nama_material[]" placeholder="Nama Barang" required class="w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase">Qty</label>
                            <input type="number" name="qty[]" placeholder="0" required class="input-qty w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase">Satuan</label>
                            <input type="text" name="satuan[]" placeholder="Sak" required class="w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase">Harga Satuan</label>
                            <input type="number" name="harga_satuan[]" placeholder="Rp" required class="input-harga w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-medium text-gray-800 outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 border-t border-gray-100 pt-2">
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase">PPN (Nominal Rp)</label>
                            <input type="number" name="ppn[]" placeholder="0" class="input-ppn w-full bg-white border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-bold text-gray-800 outline-none">
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase">Harga Total (+PPN)</label>
                            <input type="number" name="harga_total[]" readonly placeholder="Otomatis" class="input-total w-full bg-gray-100 border border-gray-200 rounded-lg px-2.5 py-2 text-xs font-black text-emerald-600 outline-none">
                        </div>
                    </div>
                </div>`;

                wrapper.insertAdjacentHTML('beforeend', HTMLBarisBaru);
            });

            wrapper.addEventListener('click', function (e) {
                if (e.target.classList.contains('btn-hapus-baris')) {
                    e.target.closest('.item-material').remove();
                }
            });
        });
    </script>
</body>
</html>
