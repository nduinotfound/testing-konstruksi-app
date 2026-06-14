<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi Pekerja Proyek</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 pb-5 mb-6">
            <div>
                <span class="text-[10px] bg-slate-900 text-white font-black px-2.5 py-1 rounded-md uppercase tracking-wider">Kantor Pusat</span>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight mt-2">Rekap Absensi Pekerja Lapangan</h1>
                <p class="text-xs text-gray-500 mt-1">Proyek: <span class="font-bold text-blue-600">{{ $proyek->nama_proyek }}</span> | Lokasi: {{ $proyek->lokasi }}</p>
            </div>
            <a href="{{ route('admin.proyek.show', $proyek->id) }}" class="mt-4 sm:mt-0 text-xs font-bold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 px-4 py-2.5 rounded-xl shadow-3xs transition text-center">
                ⬅️ Kembali ke Detail Proyek
            </a>
        </div>

        @forelse($rekapAbsen as $tanggal => $daftarAbsen)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-3xs overflow-hidden mb-6">
                <div class="bg-slate-50 border-b border-gray-100 px-5 py-3.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex items-center space-x-2">
                        <span class="text-base text-gray-500">📅</span>
                        <h3 class="text-sm font-black text-gray-800 font-mono">{{ date('l, d F Y', strtotime($tanggal)) }}</h3>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium sm:text-right">
                        Dilaporkan oleh Mandor: <span class="font-bold text-slate-700 capitalize">{{ $daftarAbsen->first()->user->name }}</span>
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-gray-50/50 text-[10px] text-gray-500 uppercase font-black tracking-wider border-b border-gray-100">
                            <tr>
                                <th class="py-3 px-5 w-12 text-center">No</th>
                                <th class="py-3 px-5">Nama Pekerja / Tukang</th>
                                <th class="py-3 px-5 text-center w-40">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 font-bold text-gray-700">
                            @foreach($daftarAbsen as $index => $absen)
                                <tr class="hover:bg-gray-50/30 transition">
                                    <td class="py-3 px-5 text-center font-mono text-gray-400">{{ $index + 1 }}</td>
                                    <td class="py-3 px-5 text-gray-900 capitalize">{{ $absen->nama_pekerja }}</td>
                                    <td class="py-3 px-5">
                                        <div class="flex justify-center">
                                            @if($absen->status_kehadiran === 'hadir')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-emerald-700 border border-emerald-100 tracking-wider">
                                                    🟢 Hadir
                                                </span>
                                            @elseif($absen->status_kehadiran === 'izin')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-50 text-amber-700 border border-amber-100 tracking-wider">
                                                    🟡 Izin
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-red-50 text-red-700 border border-red-100 tracking-wider">
                                                    🔴 Alfa
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-3xs">
                <span class="text-4xl block mb-3">📋</span>
                <h3 class="text-sm font-black text-gray-400">Belum Ada Riwayat Absensi Pekerja</h3>
                <p class="text-xs text-gray-400 mt-1">Mandor belum mengunci atau mengirimkan laporan absensi regu lapangan untuk proyek ini.</p>
            </div>
        @endforelse
    </div>

</body>
</html>
