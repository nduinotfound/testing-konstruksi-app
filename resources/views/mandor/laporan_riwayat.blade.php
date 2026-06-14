<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-16 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('mandor.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-base text-gray-800 tracking-tight">Riwayat Laporan Anda</h2>
        </div>
        <a href="{{ route('mandor.laporan.create') }}" class="text-[10px] font-black text-white bg-blue-600 hover:bg-blue-700 transition px-3 py-2 rounded-xl uppercase tracking-wider shadow-2xs">
            + Baru
        </a>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        <div class="space-y-4">
            @forelse($laporans as $laporan)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition hover:shadow-md">

                    <div class="bg-slate-900 px-4 py-2.5 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2 truncate">
                            <span class="w-2 h-2 bg-blue-400 rounded-full flex-shrink-0"></span>
                            <span class="text-[11px] font-black tracking-wide uppercase truncate">{{ $laporan->proyek->nama_proyek }}</span>
                        </div>
                        <span class="text-[10px] font-mono bg-slate-800 px-2 py-0.5 rounded text-gray-300 flex-shrink-0">
                            {{ date('d M Y', strtotime($laporan->tanggal)) }}
                        </span>
                    </div>

                    <div class="p-4 space-y-3">
                        <div class="font-sans">
                            <span class="text-[10px] font-mono text-gray-400 block mb-1">Dikirim jam {{ $laporan->created_at->format('H:i') }} WIB</span>
                            <p class="text-xs text-gray-600 leading-relaxed font-semibold">
                                {{ $laporan->keterangan_progres }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-2 border-t border-gray-50">
                            @php
                                $semuaFoto = explode(',', $laporan->foto_progres);
                            @endphp

                            @foreach($semuaFoto as $index => $foto)
                                @if(!empty(trim($foto)))
                                    <div class="relative rounded-xl overflow-hidden border border-gray-100 aspect-video shadow-3xs group">
                                        <a href="{{ asset('uploads/laporan/' . trim($foto)) }}" target="_blank" class="block w-full h-full">
                                            <img src="{{ asset('uploads/laporan/' . trim($foto)) }}" alt="Foto Progres" class="w-full h-full object-cover group-hover:scale-105 transition duration-200" onerror="this.onerror=null; this.src='https://placehold.co/150x150?text=No+Image';">
                                        </a>
                                        <span class="absolute bottom-1 right-1 bg-slate-900/60 text-white text-[8px] px-1.5 py-0.5 rounded font-bold">
                                            Foto {{ $index + 1 }}
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200 px-4">
                    <div class="p-3 bg-gray-50 text-gray-400 rounded-full inline-block mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-gray-400">Kamu belum pernah mengirim laporan progres fisik.</p>
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>
