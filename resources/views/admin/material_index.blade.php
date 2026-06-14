<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendali Sisa Stok Barang - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-gray-800 tracking-tight">Kendali Sisa Stok Barang</h1>
                <p class="text-xs text-gray-400 mt-1">Laporan opname gudang berkala yang dikirim oleh mandor lapangan.</p>
            </div>

            <a href="{{ route('admin.material.export') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-wider px-5 py-3 rounded-xl transition shadow-xs flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Ekspor Laporan Cetak</span>
            </a>
        </div>

        <div class="space-y-8">
            @forelse($groupedMaterials as $tanggal => $allDailyItems)
                <div class="space-y-4">

                    <div class="bg-slate-900 px-6 py-3.5 rounded-2xl flex items-center justify-between text-white shadow-sm">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-black tracking-wider uppercase">{{ date('l, d F Y', strtotime($tanggal)) }}</span>
                        </div>
                        <span class="bg-blue-500/20 text-blue-300 text-[10px] font-black px-2.5 py-0.5 rounded-full border border-blue-500/30">
                            Total {{ $allDailyItems->count() }} Item Masuk
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-4 pl-2">
                        @foreach($allDailyItems->groupBy('proyek_id') as $proyekId => $items)
                            <div class="bg-white rounded-xl border border-gray-100 shadow-3xs overflow-hidden">

                                <div class="bg-slate-50 px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                                    <div>
                                        <h2 class="text-xs font-black text-slate-800 uppercase tracking-wide">{{ $items->first()->proyek->nama_proyek ?? 'Proyek Tanpa Nama' }}</h2>
                                        <p class="text-[10px] text-gray-400 font-medium mt-0.5">📍 Lokasi: {{ $items->first()->proyek->lokasi ?? '-' }}</p>
                                    </div>
                                    <span class="text-[9px] font-mono text-gray-400 font-bold bg-white px-2 py-1 rounded-md border border-gray-100">
                                        {{ $items->count() }} Item Material
                                    </span>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50/40 border-b border-gray-100 text-[9px] font-black text-gray-400 uppercase tracking-wider">
                                                <th class="py-2.5 px-6" style="width: 30%;">Nama Material</th>
                                                <th class="py-2.5 px-6 text-center" style="width: 25%;">Stok Sisa Lapangan</th>
                                                <th class="py-2.5 px-6" style="width: 25%;">Uploader (Mandor)</th>
                                                <th class="py-2.5 px-6 text-right" style="width: 20%;">Waktu Input</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50 text-xs font-medium text-gray-700">
                                            @foreach($items as $item)
                                                <tr class="hover:bg-gray-50/30 transition">
                                                    <td class="py-3 px-6 font-bold text-gray-900 capitalize">{{ $item->nama_material }}</td>
                                                    <td class="py-3 px-6 text-center">
                                                        <span class="bg-amber-50 text-amber-700 font-mono font-black px-2.5 py-0.5 rounded-md border border-amber-100 text-[11px]">
                                                            {{ $item->jumlah_sisa }} {{ $item->satuan }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3 px-6">
                                                        <div class="flex items-center space-x-2">
                                                            <div class="w-5 h-5 bg-blue-50 text-blue-600 font-black text-[9px] rounded-full flex items-center justify-center uppercase">
                                                                {{ substr($item->user->name ?? 'M', 0, 2) }}
                                                            </div>
                                                            <span class="font-bold text-gray-700 text-[11px]">{{ $item->user->name ?? 'Mandor Lapangan' }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-right font-mono text-gray-400 font-bold">
                                                        {{ $item->created_at->format('H:i') }} WIB
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-sm text-gray-400 font-medium shadow-3xs">
                    Belum ada riwayat update sisa material gudang yang masuk saat ini.
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>
