<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Absensi Mandor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <div x-data="{ status: 'hadir' }">
        <!-- Header Atas -->
        <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-3">
                <a href="{{ route('mandor.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-bold text-lg text-gray-800 tracking-tight">Ambil Absensi Mandor</h2>
            </div>
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

            @if (session('success'))
                <div class="mb-6 p-4 text-sm bg-green-600 text-white font-bold rounded-xl shadow-xs" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- SISI KIRI: INPUT FORM & KAMERA -->
                <div class="md:col-span-2 space-y-4">

                    <div class="bg-gradient-to-r from-slate-800 to-slate-950 rounded-2xl p-6 text-center md:text-left md:flex md:items-center md:justify-between text-white shadow-md">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest font-bold opacity-60">Waktu Server Lapangan</p>
                            <h1 id="clock" class="text-3xl md:text-4xl font-black tracking-tight my-1 text-blue-400 font-mono">00:00:00</h1>
                        </div>
                        <p id="date" class="text-xs md:text-sm font-medium opacity-80 mt-2 md:mt-0">Memuat tanggal...</p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
                        <form action="{{ route('mandor.absensi.store') }}" method="POST" id="form-absensi">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Lokasi Proyek Tugas</label>
                                <select name="proyek_id" required class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl p-3 text-sm bg-gray-50 font-medium">
                                    <option value="" disabled selected>-- Pilih Proyek Hari Ini --</option>
                                    @foreach ($proyeks as $proyek)
                                        <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-2">Status Kehadiran</label>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach(['hadir', 'izin', 'sakit'] as $st)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="status" value="{{ $st }}" x-model="status" class="sr-only">
                                            <div class="py-2.5 text-center text-xs font-black rounded-xl border capitalize transition active:scale-95"
                                                 :class="status === '{{ $st }}' ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-gray-50 text-gray-600 border-gray-200'">
                                                {{ $st }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-6" x-show="status === 'hadir'">
                                <label class="block text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">Bukti Foto Selfie Lapangan</label>

                                <input type="file" id="camera-input" accept="image/*" capture="user" class="sr-only" onchange="processSelfieImage(event)">
                                <input type="hidden" name="foto_selfie" id="base64-output">

                                <div onclick="document.getElementById('camera-input').click()" class="w-full h-52 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center bg-gray-50 cursor-pointer overflow-hidden group hover:bg-gray-100 transition relative">
                                    <img id="image-preview" class="w-full h-full object-cover hidden absolute inset-0 z-10">
                                    <div class="text-center p-4 z-0 flex flex-col items-center">
                                        <div class="p-3 bg-blue-50 text-blue-600 rounded-full mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V3z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700">Ambil Foto Wajah</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">Ketuk untuk membuka kamera depan HP</p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white font-black py-3.5 rounded-xl hover:bg-blue-700 transition shadow-sm text-xs active:scale-95 tracking-wider">
                                KIRIM KEHADIRAN MASUK
                            </button>
                        </form>
                    </div>

                </div>

                <!-- SISI KANAN: REKAP LOG LOGISTIK/ABSENSI -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sticky top-24">
                        <h3 class="text-gray-800 font-extrabold text-xs uppercase tracking-wider mb-4">Log Absensi Hari Ini</h3>

                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-1">
                            @foreach($absensis as $absen)
                                <div class="bg-gray-50/60 border border-gray-100 rounded-xl p-3 flex items-center justify-between transition hover:bg-white hover:shadow-3xs">
                                    <div class="flex items-center space-x-3">

                                        <!-- WRAPPER GAMBER PREMIUM DENGAN FAILSAFE DETECTOR -->
                                        <div class="relative w-10 h-10 flex-shrink-0">
                                            @if($absen->status == 'hadir' && $absen->foto_selfie)
                                                <img src="{{ asset('uploads/absensi/' . $absen->foto_selfie) }}"
                                                     alt="Selfie"
                                                     class="w-10 h-10 object-cover rounded-lg border border-gray-200"
                                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            @endif

                                            <div style="display: {{ ($absen->status == 'hadir' && $absen->foto_selfie) ? 'none' : 'flex' }}"
                                                 class="fallback-box w-10 h-10 bg-blue-50 text-blue-600 rounded-lg items-center justify-center font-black text-xs uppercase">
                                                {{ $absen->status == 'hadir' ? 'HA' : ($absen->status == 'izin' ? 'IZ' : 'SK') }}
                                            </div>
                                        </div>

                                        <div>
                                            <span class="text-xs font-black text-gray-800 block">
                                                {{ $absen->status == 'hadir' ? 'Check-in Berhasil' : 'Permohonan ' . ucfirst($absen->status) }}
                                            </span>
                                            <p class="text-[10px] text-gray-400 font-medium truncate max-w-[130px]">
                                                {{ $absen->proyek->nama_proyek ?? 'Proyek Tidak Ditemukan' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider
                                            {{ $absen->status == 'hadir' ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }}">
                                            {{ $absen->status }}
                                        </span>
                                        <p class="text-[9px] font-mono text-gray-400 font-bold mt-1">
                                            {{ date('H:i', strtotime($absen->jam_masuk)) }} WIB
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('date').textContent = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        function processSelfieImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;
                img.onload = function () {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const max_width = 500;
                    const scaleFactor = max_width / img.width;
                    canvas.width = max_width;
                    canvas.height = img.height * scaleFactor;
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    const base64 = canvas.toDataURL('image/jpeg', 0.7);
                    document.getElementById('base64-output').value = base64;
                    const preview = document.getElementById('image-preview');
                    preview.src = base64;
                    preview.classList.remove('hidden');
                }
            }
        }
    </script>
</body>
</html>
