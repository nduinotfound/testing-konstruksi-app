<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - Pemantauan Proyek</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <!-- Top Navigation (Sudah Dilengkapi Tombol Logout Aman) -->
    <div class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-md text-white">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center font-black text-sm tracking-wider shadow-sm">OW</div>
            <div>
                <h2 class="font-black text-base tracking-tight leading-none">Owner Workspace</h2>
                <p class="text-[10px] text-slate-400 mt-1 font-medium">Sistem Pemantauan Infrastruktur & Logistik</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <span class="hidden sm:inline-block text-xs font-bold text-blue-400 bg-blue-500/10 border border-blue-500/20 px-3 py-1 rounded-full uppercase tracking-wider">Mode Pengawas Utama</span>

            <!-- TOMBOL LOGOUT AMAN LAUNCHER -->
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600/10 hover:bg-red-600 border border-red-500/20 hover:border-red-600 text-red-400 hover:text-white font-black text-[10px] uppercase tracking-wider px-3.5 py-2 rounded-xl transition duration-200 flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <div class="mb-8">
            <h1 class="text-xl font-black text-gray-800 tracking-tight">Selamat Datang Kembali, Owner!</h1>
            <p class="text-xs text-gray-400 mt-1">Berikut adalah daftar proyek aktif yang sedang dalam pengawasan operasional mandor Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($proyeks as $proyek)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition duration-300 overflow-hidden flex flex-col h-full">

                    <div class="p-5 flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[9px] font-black font-mono tracking-wider px-2 py-0.5 rounded uppercase
                                {{ $proyek->status == 'berjalan' ? 'bg-blue-50 text-blue-600' : ($proyek->status == 'selesai' ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600') }}">
                                ● {{ $proyek->status }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-medium font-mono">ID: PRO-{{ $proyek->id }}</span>
                        </div>

                        <h3 class="text-base font-black text-gray-800 tracking-tight capitalize group-hover:text-blue-600 transition">{{ $proyek->nama_proyek }}</h3>

                        <p class="text-xs text-gray-400 mt-2 flex items-start leading-relaxed">
                            <svg class="w-3.5 h-3.5 mr-1 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $proyek->lokasi }}
                        </p>
                    </div>

                    <div class="bg-gray-50 border-t border-gray-100 px-5 py-3.5 flex items-center justify-between">
                        <div class="text-[10px] text-gray-400 font-bold">
                            Log masuk: <span class="text-slate-700 font-black">{{ $proyek->laporanHarians->count() }} Hari</span>
                        </div>
                        <a href="{{ route('owner.proyek.show', $proyek->id) }}" class="bg-slate-900 hover:bg-slate-800 text-white font-black text-[10px] uppercase tracking-wider px-4 py-2 rounded-xl shadow-2xs transition">
                            Pantau Progres ➔
                        </a>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center text-sm text-gray-400 font-medium">
                    Belum ada proyek konstruksi yang terdaftar dalam database saat ini.
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>
