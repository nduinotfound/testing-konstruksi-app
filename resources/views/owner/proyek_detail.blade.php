<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemantauan Operasional Proyek - Owner</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-16 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('owner.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
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

        <span class="text-[10px] font-black px-2.5 py-2 rounded-xl tracking-wider uppercase inline-block shadow-2xs text-white
            {{ $proyek->status == 'berjalan' ? 'bg-blue-600' : ($proyek->status == 'selesai' ? 'bg-green-600' : 'bg-amber-500') }}">
            Status: {{ $proyek->status }}
        </span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
                <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider mb-4 flex items-center border-b border-gray-50 pb-3">
                    <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                    1. Catatan Kemajuan Fisik & Visual Lapangan
                </h3>

                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-1">
                    @forelse($laporanHarians->groupBy('tanggal') as $tanggal => $logs)
                        <div class="border border-gray-100 rounded-xl overflow-hidden shadow-3xs">
                            <div class="bg-slate-900 px-4 py-2 flex items-center justify-between text-white text-[10px] font-black tracking-wider uppercase">
                                <span>{{ date('l, d F Y', strtotime($tanggal)) }}</span>
                                <span class="bg-blue-500/30 text-blue-300 px-2 py-0.5 rounded-full border border-blue-500/20">{{ $logs->count() }} Laporan</span>
                            </div>

                            <div class="divide-y divide-gray-50 bg-white">
                                @foreach($logs as $laporan)
                                    <div class="p-4 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 text-[10px] font-black text-gray-400 mb-1">
                                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded">Mandor: {{ $laporan->user->name }}</span>
                                                <span class="font-mono">{{ $laporan->created_at->format('H:i') }} WIB</span>
                                            </div>
                                            <p class="text-xs text-gray-600 leading-relaxed font-medium whitespace-pre-line">{{ $laporan->keterangan_progres }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="{{ asset('uploads/laporan/' . $laporan->foto_progres) }}" target="_blank" class="block group">
                                                <img src="{{ asset('uploads/laporan/' . $laporan->foto_progres) }}"
                                                     class="w-24 h-16 object-cover rounded-xl border border-gray-100 shadow-3xs group-hover:scale-102 transition duration-200"
                                                     onerror="this.onerror=null; this.src='https://placehold.co/100x75?text=No+Image';">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-xs text-gray-400 font-medium py-12 border border-dashed rounded-xl">Belum ada rincian rekap progres fisik lapangan untuk proyek ini.</div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-xs p-6 h-fit">
                <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider mb-4 flex items-center border-b border-gray-50 pb-3">
                    <span class="w-2 h-2 bg-amber-500 rounded-full mr-2"></span>
                    2. Sisa Stok Gudang Material Saat Ini
                </h3>

                <div class="space-y-4 max-h-[650px] overflow-y-auto pr-1">
                    @forelse($materialSisas->groupBy(function($item) { return $item->created_at->format('Y-m-d'); }) as $tanggal => $items)
                        <div class="border border-gray-100 rounded-xl overflow-hidden shadow-3xs">
                            <div class="bg-gray-50 px-4 py-2 border-b border-gray-100 flex items-center justify-between">
                                <span class="text-[10px] font-black text-slate-800 font-mono uppercase">{{ date('d M Y', strtotime($tanggal)) }}</span>
                                <span class="text-[9px] font-mono text-gray-400 font-bold">{{ $items->first()->created_at->format('H:i') }} WIB</span>
                            </div>

                            <div class="divide-y divide-gray-50 bg-white">
                                @foreach($items as $item)
                                    <div class="p-3 flex items-center justify-between text-xs hover:bg-gray-50/40 transition">
                                        <span class="font-bold text-gray-800 capitalize">{{ $item->nama_material }}</span>
                                        <span class="font-mono font-black text-amber-600 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded text-[11px]">
                                            {{ $item->jumlah_sisa }} <span class="text-[9px] font-bold text-gray-400 font-sans">{{ $item->satuan }}</span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-xs text-gray-400 font-medium py-12 border border-dashed rounded-xl">Tidak ada sisa logistik material gudang yang tercatat.</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</body>
</html>
