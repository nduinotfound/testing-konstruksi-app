<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Mandor Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-2.5">
            <div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></div>
            <h2 class="font-black text-base text-gray-800 tracking-tight">Aplikasi Mandor Lapangan</h2>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-black text-red-600 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition">
                Keluar Sistem
            </button>
        </form>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        @if (session('success'))
            <div class="mb-6 p-4 text-sm bg-green-600 text-white font-bold rounded-xl shadow-xs" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-md mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center font-black text-base uppercase text-white shadow-sm">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div>
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider block">Petugas Lapangan Utama</span>
                    <h1 class="text-xl font-black tracking-tight mt-0.5">{{ Auth::user()->name }}</h1>
                </div>
            </div>
            <div class="mt-4 sm:mt-0 bg-slate-800/60 border border-slate-800 px-4 py-2 rounded-xl text-center sm:text-right">
                <p class="text-[10px] font-bold uppercase opacity-60 text-gray-400">Sinkronisasi Absensi</p>
                <p class="text-xs font-mono text-green-400 font-bold">Online & Terhubung</p>
            </div>
        </div>

        <h4 class="text-gray-400 font-black uppercase text-[11px] tracking-wider mb-4 pl-1">Pelaporan & Tugas Hari Ini</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

            <a href="{{ route('mandor.absensi.create') }}" class="bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-blue-500 transition hover:shadow-md group active:scale-95 shadow-2xs">
                <div class="p-3 bg-green-50 text-green-600 rounded-xl mb-3 group-hover:bg-green-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V3z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Absensi Kamera Selfie</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium leading-relaxed">Kirim bukti orisinalitas kehadiran presensi dari lokasi proyek.</p>
            </a>

            <a href="{{ route('mandor.absen.create') }}" class="bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-blue-600 transition hover:shadow-md group active:scale-95 shadow-2xs">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-black text-gray-800">Absen Regu Pekerja</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium leading-relaxed">Kelola dan kunci data kehadiran seluruh tukang harian hari ini sekali klik.</p>
            </a>

            <a href="{{ route('mandor.laporan.create') }}" class="bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-blue-500 transition hover:shadow-md group active:scale-95 shadow-2xs">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-5 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Laporan Progres Fisik</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium leading-relaxed">Catat kemajuan fisik dinding, pembesian tiang, dan progres pengecoran.</p>
            </a>

            <a href="{{ route('mandor.laporan.riwayat') }}" class="bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-indigo-600 transition hover:shadow-md group active:scale-95 shadow-2xs">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl mb-3 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Riwayat Catatan Fisik</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium leading-relaxed">Lihat arsip rekap buku log kerja harian yang sudah dikirim ke pusat.</p>
            </a>

            <a href="{{ route('mandor.nota.create') }}" class="bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-red-500 transition hover:shadow-md group active:scale-95 shadow-2xs">
                <div class="p-3 bg-red-50 text-red-600 rounded-xl mb-3 group-hover:bg-red-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Upload Nota Belanja</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium leading-relaxed">Foto struk pembelian material semen, paku, atau operasional lapangan.</p>
            </a>

            <a href="{{ route('mandor.material.create') }}" class="bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-amber-500 transition hover:shadow-md group active:scale-95 shadow-2xs">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl mb-3 group-hover:bg-amber-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Stok Sisa Material</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium leading-relaxed">Update berkala sisa besi, semen, atau material penting lainnya di gudang proyek.</p>
            </a>

        </div>
    </div>

</body>
</html>
