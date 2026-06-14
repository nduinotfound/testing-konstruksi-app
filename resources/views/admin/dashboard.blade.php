<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Kendali Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <!-- Header Navigasi Atas -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-600 text-white rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h2 class="font-bold text-lg text-gray-800 tracking-tight">Panel Kendali Admin</h2>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 px-3 py-2 rounded-xl transition">
                Keluar Sistem
            </button>
        </form>
    </div>

    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        <!-- Kartu Selamat Datang Premium -->
        <div class="bg-gradient-to-r from-slate-800 to-slate-950 rounded-2xl p-6 text-white shadow-md mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-xs uppercase tracking-widest font-bold opacity-60">Selamat Datang Kembali,</h3>
                <h1 class="text-2xl font-black tracking-tight mt-1 text-blue-400">{{ Auth::user()->name }}</h1>
                <p class="text-xs opacity-75 mt-1">Anda masuk sebagai Administrator Utama. Kelola seluruh konfigurasi akun dan hak akses proyek di sini.</p>
            </div>
            <div class="mt-4 md:mt-0 bg-slate-700/50 border border-slate-700 px-4 py-2 rounded-xl text-center md:text-right">
                <p class="text-[10px] font-bold uppercase opacity-60">Status Server</p>
                <p class="text-xs font-mono text-green-400 font-bold">Aktif & Sinkron (WIB)</p>
            </div>
        </div>

        <h4 class="text-gray-500 font-extrabold uppercase text-[11px] tracking-wider mb-4">Menu Utama Master Data</h4>

        <!-- GRID KARTU MENU UTAMA ADMIN -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

            <!-- 1. Tombol Kelola User -->
            <a href="{{ route('admin.users.index') }}" class="bg-white p-5 rounded-2xl shadow-xs border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-blue-500 transition hover:shadow-md group active:scale-95">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Kelola Akun Pengguna</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Tambah data Admin, Mandor Lapangan, dan Owner.</p>
            </a>

            <!-- 2. Tombol Kelola Proyek -->
            <a href="{{ route('admin.proyek.index') }}" class="bg-white p-5 rounded-2xl shadow-xs border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-blue-500 transition hover:shadow-md group active:scale-95">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Master Data Proyek</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Buka proyek baru dan audit logistik/keuangan lapangan.</p>
            </a>

            <!-- 3. Tombol Rekap Presensi -->
            <a href="{{ route('admin.audit.index') }}" class="bg-white p-5 rounded-2xl shadow-xs border border-gray-100 flex flex-col items-center sm:items-start text-center sm:text-left hover:border-blue-500 transition hover:shadow-md group active:scale-95">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-5 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="text-sm font-black text-gray-800">Audit Absen Mandor</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Pantau foto selfie orisinalitas kehadiran dari lokasi.</p>
            </a>

        </div>
    </div>

</body>
</html>
