<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Pengguna</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <!-- Header Navigasi -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-lg text-gray-800 tracking-tight">Kelola Akun Pengguna</h2>
        </div>
        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Mode Master Data</span>
    </div>

    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        <!-- Notifikasi Sukses Pembuatan/Penghapusan Akun -->
        @if (session('success'))
            <div class="mb-6 p-4 text-sm bg-green-600 text-white font-bold rounded-xl shadow-xs" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Gagal/Error -->
        @if (session('error'))
            <div class="mb-6 p-4 text-sm bg-red-600 text-white font-bold rounded-xl shadow-xs" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Grid Responsif Kiri-Kanan -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- SISI KIRI: Form Tambah / Edit Pengguna (Dinamis) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sticky top-24">

                    @if(isset($user))
                        <!-- Jika variabel $user dikirim dari fungsi edit, form berubah jadi MODE UPDATE -->
                        <h3 class="text-amber-600 font-extrabold text-sm uppercase tracking-wider mb-4">Edit Akun Pengguna</h3>
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @method('PUT')
                    @else
                        <!-- Jika tidak ada, form standar MODE SIMPAN BARU -->
                        <h3 class="text-gray-800 font-extrabold text-sm uppercase tracking-wider mb-4">Tambah Akun Baru</h3>
                        <form action="{{ route('admin.users.store') }}" method="POST">
                    @endif
                        @csrf

                        <!-- Input Nama -->
                        <div class="mb-4">
                            <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="Contoh: Budi Santoso"
                                   value="{{ isset($user) ? $user->name : old('name') }}"
                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium">
                        </div>

                        <!-- Input Email -->
                        <div class="mb-4">
                            <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Alamat Email</label>
                            <input type="email" name="email" required placeholder="budi@domain.com"
                                   value="{{ isset($user) ? $user->email : old('email') }}"
                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium">
                        </div>

                        <!-- Input Password -->
                        <div class="mb-4">
                            <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">
                                Password Akun {!! isset($user) ? '<span class="text-amber-600 font-medium lowercase">(kosongkan jika tidak diubah)</span>' : '' !!}
                            </label>
                            <input type="password" name="password" {{ isset($user) ? '' : 'required' }} placeholder="Minimal 8 karakter"
                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium">
                        </div>

                        <!-- Dropdown Hak Akses -->
                        <div class="mb-6">
                            <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Hak Akses Sistem (Role)</label>
                            <select name="role" required class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium">
                                <option value="" disabled>-- Pilih Hak Akses --</option>
                                <option value="admin" {{ (isset($user) && $user->role == 'admin') ? 'selected' : '' }}>Administrator (Admin)</option>
                                <option value="mandor" {{ (isset($user) && $user->role == 'mandor') ? 'selected' : '' }}>Mandor Lapangan (Mandor)</option>
                                <option value="owner" {{ (isset($user) && $user->role == 'owner') ? 'selected' : '' }}>Pemilik Proyek (Owner)</option>
                            </select>
                        </div>

                        <!-- Tombol Submit Dinamis warna sesuai mode -->
                        @if(isset($user))
                            <button type="submit" class="w-full bg-amber-500 text-white font-black py-3.5 rounded-xl hover:bg-amber-600 transition shadow-sm text-xs active:scale-95 tracking-wider mb-2">
                                SIMPAN PERUBAHAN
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="block text-center w-full bg-gray-100 text-gray-600 font-bold py-2.5 rounded-xl text-xs active:scale-95 tracking-wider">
                                Batal Edit
                            </a>
                        @else
                            <button type="submit" class="w-full bg-blue-600 text-white font-black py-3.5 rounded-xl hover:bg-blue-700 transition shadow-sm text-xs active:scale-95 tracking-wider">
                                DAFTARKAN AKUN
                            </button>
                        @endif
                    </form>
                </div>
            </div>

            <!-- SISI KANAN: Tabel Daftar Pengguna -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 overflow-hidden">
                    <h3 class="text-gray-800 font-extrabold text-sm uppercase tracking-wider mb-4">Daftar Pengguna Aktif</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 text-gray-400 text-[11px] font-extrabold uppercase tracking-wider">
                                    <th class="pb-3 pl-2">Nama Pengguna</th>
                                    <th class="pb-3">Email</th>
                                    <th class="pb-3 text-center">Hak Akses</th>
                                    <th class="pb-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm font-medium text-gray-700">
                                @foreach($users as $usr)
                                    <tr>
                                        <td class="py-3.5 pl-2 flex items-center space-x-3">
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs uppercase shadow-xs
                                                {{ $usr->role == 'admin' ? 'bg-red-100 text-red-600' : ($usr->role == 'mandor' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600') }}">
                                                {{ substr($usr->name, 0, 2) }}
                                            </div>
                                            <span class="font-bold text-gray-800">{{ $usr->name }}</span>
                                        </td>
                                        <td class="py-3.5 text-gray-500 font-mono text-xs">{{ $usr->email }}</td>
                                        <td class="py-3.5 text-center">
                                            <span class="text-[10px] font-black px-2.5 py-1 rounded-lg tracking-wider uppercase inline-block shadow-2xs text-white
                                                {{ $usr->role == 'admin' ? 'bg-red-600' : ($usr->role == 'mandor' ? 'bg-green-600' : 'bg-amber-500') }}">
                                                {{ $usr->role }}
                                            </span>
                                        </td>

                                        <!-- KOLOM AKSI EDIT DAN HAPUS -->
                                        <td class="py-3.5 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('admin.users.edit', $usr->id) }}" class="p-1.5 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-600 hover:text-white transition" title="Edit Akun">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>

                                                <!-- Tombol Hapus (Menggunakan Form karena metode HTTP-nya DELETE) -->
                                                <form action="{{ route('admin.users.destroy', $usr->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $usr->name }} ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-600 hover:text-white transition" title="Hapus Akun">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-16v1a3 3 0 003 3h10M4 7h16"></path></svg>
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
            </div>

        </div>
    </div>

</body>
</html>
