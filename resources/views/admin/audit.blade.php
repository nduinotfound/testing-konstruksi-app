<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Presensi Mandor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <!-- Header Navigasi -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-lg text-gray-800 tracking-tight">Audit Presensi Mandor</h2>
        </div>
        <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full flex items-center">
            <span class="h-1.5 w-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span>
            Monitoring Real-Time
        </span>
    </div>

    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        <!-- Tabel Utama Audit Log -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 overflow-hidden">
            <div class="mb-4">
                <h3 class="text-gray-800 font-extrabold text-sm uppercase tracking-wider">Rekam Jejak Kehadiran Lapangan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Seluruh data foto selfie wajah dan jam masuk terenkripsi server otomatis.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-[11px] font-extrabold uppercase tracking-wider">
                            <th class="pb-3 pl-2">Bukti Kamera (Selfie)</th>
                            <th class="pb-3">Nama Mandor</th>
                            <th class="pb-3">Lokasi Proyek Tugas</th>
                            <th class="pb-3 text-center">Tanggal & Jam</th>
                            <th class="pb-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs font-medium text-gray-700">
                            @forelse($absensis as $absen)
                                <tr class="hover:bg-gray-50/40 transition">

                                    <td class="py-4 pl-1 whitespace-nowrap vertical-middle">
                                        <div class="relative w-24 h-24 flex-shrink-0">
                                            @if($absen->status == 'hadir' && $absen->foto_selfie)
                                                <img src="{{ asset('uploads/absensi/' . $absen->foto_selfie) }}"
                                                     alt="Selfie Mandor"
                                                     class="w-24 h-24 object-cover rounded-xl border border-gray-100 shadow-xs"
                                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            @endif

                                            <div style="display: {{ ($absen->status == 'hadir' && $absen->foto_selfie) ? 'none' : 'flex' }}"
                                                 class="w-24 h-24 bg-gray-50 border border-gray-200 border-dashed rounded-xl flex flex-col items-center justify-center text-center p-2">
                                                <svg class="w-5 h-5 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-wider leading-none">NO FILE</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 text-gray-800 font-bold vertical-middle">
                                        {{ $absen->user->name }}
                                        <div class="text-[10px] text-gray-400 font-medium font-sans mt-0.5">{{ $absen->user->email }}</div>
                                    </td>

                                    <td class="py-4 text-gray-700 font-semibold vertical-middle">
                                        {{ $absen->proyek->nama_proyek ?? 'Proyek N/A' }}
                                        <div class="text-[10px] text-gray-400 font-medium font-sans mt-0.5 flex items-center">
                                            <svg class="w-3 h-3 text-gray-300 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $absen->proyek->lokasi ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="py-4 vertical-middle whitespace-nowrap">
                                        <span class="text-xs font-bold text-gray-600">{{ date('d M Y', strtotime($absen->tanggal)) }}</span>
                                        <div class="mt-1">
                                            <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-md text-[9px] font-mono font-bold">
                                                {{ date('H:i', strtotime($absen->jam_masuk)) }} WIB
                                            </span>
                                        </div>
                                    </td>

                                    <td class="py-4 vertical-middle whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-green-100 text-green-700">
                                            {{ $absen->status }}
                                        </span>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-xs text-gray-400 font-medium py-12">Belum ada rekam jejak presensi mandor lapangan hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>
