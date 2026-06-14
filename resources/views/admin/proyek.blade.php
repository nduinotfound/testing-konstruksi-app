<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Proyek</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-lg text-gray-800 tracking-tight">Master Data Proyek</h2>
        </div>
        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Mode Manajemen Proyek</span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        @if (session('success'))
            <div class="mb-6 p-4 text-sm bg-green-600 text-white font-bold rounded-xl shadow-xs" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sticky top-24">

                    @if(isset($proyek))
                        <h3 class="text-amber-600 font-extrabold text-sm uppercase tracking-wider mb-4">Edit Data Proyek</h3>
                        <form action="{{ route('admin.proyek.update', $proyek->id) }}" method="POST">
                            @method('PUT')
                    @else
                        <h3 class="text-gray-800 font-extrabold text-sm uppercase tracking-wider mb-4">Buka Proyek Baru</h3>
                        <form action="{{ route('admin.proyek.store') }}" method="POST">
                    @endif
                        @csrf

                        <div class="mb-4">
                            <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Nama Proyek</label>
                            <input type="text" name="nama_proyek" required placeholder="Contoh: Pembangunan Jembatan Air Manis"
                                   value="{{ isset($proyek) ? $proyek->nama_proyek : old('nama_proyek') }}"
                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium">
                        </div>

                        <div class="mb-4">
                            <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Lokasi / Wilayah</label>
                            <textarea name="lokasi" required placeholder="Masukkan alamat lengkap lokasi proyek..." rows="2"
                                      class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium resize-none">{{ isset($proyek) ? $proyek->lokasi : old('lokasi') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Kontrak Mulai</label>
                                <input type="date" name="tanggal_mulai" required
                                       value="{{ isset($proyek) ? $proyek->tanggal_mulai : old('tanggal_mulai') }}"
                                       class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-xs bg-gray-50 font-medium">
                            </div>
                            <div>
                                <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Target Batas (Deadline)</label>
                                <input type="date" name="deadline" required
                                       value="{{ isset($proyek) ? $proyek->deadline : old('deadline') }}"
                                       class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-xs bg-gray-50 font-medium">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Status Proyek</label>
                            <select name="status" required class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium">
                                <option value="" disabled selected>-- Pilih Status --</option>
                                <option value="perencanaan" {{ (isset($proyek) && $proyek->status == 'perencanaan') ? 'selected' : '' }}>Perencanaan (Planing)</option>
                                <option value="berjalan" {{ (isset($proyek) && $proyek->status == 'berjalan') ? 'selected' : '' }}>Sedang Berjalan (Active)</option>
                                <option value="selesai" {{ (isset($proyek) && $proyek->status == 'selesai') ? 'selected' : '' }}>Selesai Kontrak (Done)</option>
                                <option value="tertunda" {{ (isset($proyek) && $proyek->status == 'tertunda') ? 'selected' : '' }}>Tertunda (On Hold)</option>
                            </select>
                        </div>

                        @if(isset($proyek))
                            <button type="submit" class="w-full bg-amber-500 text-white font-black py-3.5 rounded-xl hover:bg-amber-600 transition shadow-sm text-xs active:scale-95 tracking-wider mb-2">
                                UPDATE DATA PROYEK
                            </button>
                            <a href="{{ route('admin.proyek.index') }}" class="block text-center w-full bg-gray-100 text-gray-600 font-bold py-2.5 rounded-xl text-xs active:scale-95 tracking-wider">
                                Batal Edit
                            </a>
                        @else
                            <button type="submit" class="w-full bg-blue-600 text-white font-black py-3.5 rounded-xl hover:bg-blue-700 transition shadow-sm text-xs active:scale-95 tracking-wider">
                                SUBMIT PROYEK BARU
                            </button>
                        @endif
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 overflow-hidden">
                    <h3 class="text-gray-800 font-extrabold text-sm uppercase tracking-wider mb-4">Daftar Seluruh Proyek</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 text-gray-400 text-[11px] font-extrabold uppercase tracking-wider">
                                    <th class="pb-3 pl-2">Nama Proyek & Lokasi</th>
                                    <th class="pb-3">Durasi Kontrak</th>
                                    <th class="pb-3 text-center">Status</th>
                                    <th class="pb-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm font-medium text-gray-700">
                                @forelse($proyeks as $pryk)
                                    <tr>
                                        <td class="py-4 pl-2 max-w-[220px]">
                                            <h4 class="font-bold text-gray-800 text-sm leading-snug">{{ $pryk->nama_proyek }}</h4>
                                            <p class="text-[11px] text-gray-400 mt-1 flex items-center">
                                                <svg class="w-3 h-3 text-gray-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                <span class="truncate">{{ $pryk->lokasi }}</span>
                                            </p>
                                        </td>
                                        <td class="py-4 text-xs font-medium text-gray-600">
                                            <div class="font-mono">{{ date('d M Y', strtotime($pryk->tanggal_mulai)) }}</div>
                                            <div class="text-[10px] text-gray-400 mt-0.5 uppercase font-bold tracking-wider">s/d</div>
                                            <div class="font-mono text-red-600 font-bold">{{ date('d M Y', strtotime($pryk->deadline)) }}</div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <span class="text-[9px] font-black px-2.5 py-1 rounded-md tracking-wider uppercase inline-block shadow-2xs text-white
                                                {{ $pryk->status == 'berjalan' ? 'bg-blue-600' : ($pryk->status == 'selesai' ? 'bg-green-600' : ($pryk->status == 'tertunda' ? 'bg-red-500' : 'bg-amber-500')) }}">
                                                {{ $pryk->status }}
                                            </span>
                                        </td>
                                        <!-- Kolom Aksi Lengkap dengan Detail Proyek -->
                                        <td class="py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <!-- BARIS BARU: Tombol Lihat Detail & Audit Logistik Proyek (Ikon Mata Hijau) -->
                                                <a href="{{ route('admin.proyek.show', $pryk->id) }}" class="p-1.5 bg-green-50 text-green-600 rounded-md hover:bg-green-600 hover:text-white transition" title="Lihat Detail & Audit Logistik">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>

                                                <!-- Edit Proyek -->
                                                <a href="{{ route('admin.proyek.edit', $pryk->id) }}" class="p-1.5 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-600 hover:text-white transition" title="Edit Data Proyek">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>

                                                <!-- Hapus Proyek -->
                                                <form action="{{ route('admin.proyek.destroy', $pryk->id) }}" method="POST" onsubmit="return confirm('Hapus proyek {{ $pryk->nama_proyek }}? Seluruh log laporan, keuangan, dan absensi di proyek ini juga ikut terhapus otomatis.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-600 hover:text-white transition" title="Hapus Proyek">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-16v1a3 3 0 003 3h10M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-xs text-gray-400 font-medium">Belum ada data proyek terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

</body>
</html>
