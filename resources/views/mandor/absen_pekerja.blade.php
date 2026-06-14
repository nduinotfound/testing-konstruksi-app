<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Regu Pekerja Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased pb-12">

    <div class="container mx-auto p-4 max-w-md space-y-4">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-4 flex justify-between items-center">
            <div>
                <h1 class="text-base font-extrabold text-gray-800 tracking-tight">Absen Regu Pekerja</h1>
                <p class="text-[11px] text-gray-400 mt-0.5 font-mono">📅 {{ date('l, d M Y') }}</p>
            </div>
            <a href="{{ route('mandor.dashboard') }}" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-600 font-black px-3 py-2 rounded-xl transition">⬅️ Panel</a>
        </div>

        @if(session('success'))
            <div class="p-3.5 text-xs bg-emerald-600 text-white font-black rounded-xl shadow-xs">
                🎉 {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <form action="{{ route('mandor.absen.create') }}" method="GET" id="form-filter-proyek">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1.5 pl-0.5">Pilih Proyek Tugas Hari Ini</label>
                <select name="proyek_id" onchange="document.getElementById('form-filter-proyek').submit()" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl px-3 py-2.5 text-xs font-bold text-gray-800 outline-none transition">
                    <option value="" disabled {{ !$proyekTerpilihId ? 'selected' : '' }}>-- Silakan Pilih Lokasi Proyek --</option>
                    @foreach($proyeks as $p)
                        <option value="{{ $p->id }}" {{ $proyekTerpilihId == $p->id ? 'selected' : '' }}>
                            🏗️ {{ $p->nama_proyek }} ({{ $p->lokasi }})
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($proyek)
            <div class="bg-gray-200/70 p-1 rounded-xl flex space-x-1">
                <button type="button" id="tab-button-input" onclick="switchTab('input')" class="flex-1 py-2.5 text-center text-xs font-black rounded-lg transition duration-200 bg-white text-gray-800 shadow-xs">
                    📝 Input Absen
                </button>
                <button type="button" id="tab-button-riwayat" onclick="switchTab('riwayat')" class="flex-1 py-2.5 text-center text-xs font-black rounded-lg transition duration-200 text-gray-500 hover:text-gray-800 flex items-center justify-center space-x-1.5">
                    <span>📋 Terkunci Hari Ini</span>
                    <span class="bg-slate-900 text-white text-[9px] font-mono px-1.5 py-0.5 rounded-full">{{ $absenHariIni->count() }}</span>
                </button>
            </div>

            <div id="tab-content-input" class="space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <form action="{{ route('mandor.absen.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="proyek_id" value="{{ $proyek->id }}">

                        <div id="wrapper-pekerja" class="space-y-3">
                            <div class="p-3 border border-gray-100 rounded-xl bg-gray-50/60 flex flex-col space-y-2 baris-pekerja shadow-3xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-mono text-gray-400 nomor-urut">Pekerja #1</span>
                                    <button type="button" onclick="hapusBaris(this)" class="text-[10px] text-red-500 font-bold hover:underline hidden tombol-hapus">❌ Hapus</button>
                                </div>
                                <input type="text" name="pekerja[0][nama]" required placeholder="Ketik nama pekerja..." class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-500 font-bold text-gray-800 shadow-3xs">
                                <select name="pekerja[0][status]" required class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-500 font-bold text-gray-700 outline-none shadow-3xs">
                                    <option value="hadir">🟢 Hadir</option>
                                    <option value="izin">🟡 Izin / Sakit</option>
                                    <option value="alfa">🔴 Alfa / Tidak Datang</option>
                                </select>
                            </div>
                        </div>

                        <button type="button" id="btn-tambah" class="w-full bg-white border border-dashed border-gray-300 text-gray-600 hover:bg-gray-50 font-black text-xs py-3 rounded-xl transition flex items-center justify-center space-x-1">
                            <span>➕ Tambah Baris Pekerja</span>
                        </button>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-xs tracking-wider uppercase py-3.5 rounded-xl shadow-md transition">
                            Lock & Simpan Absen Hari Ini
                        </button>
                    </form>
                </div>
            </div>

            <div id="tab-content-riwayat" class="space-y-4 hidden">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="divide-y divide-gray-50 border border-gray-100 rounded-xl overflow-hidden text-xs bg-white shadow-3xs">
                        @forelse($absenHariIni as $absenLap)
                            <div class="p-3.5 flex items-center justify-between bg-gray-50/20 hover:bg-gray-50/50 transition">
                                <div class="flex items-center space-x-2">
                                    <span class="text-base">👷</span>
                                    <span class="font-bold text-gray-900 capitalize tracking-tight">{{ $absenLap->nama_pekerja }}</span>
                                </div>
                                @if($absenLap->status_kehadiran === 'hadir')
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded border border-emerald-100">Hadir</span>
                                @elseif($absenLap->status_kehadiran === 'izin')
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 bg-amber-50 text-amber-700 rounded border border-amber-100">Izin</span>
                                @else
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 bg-red-50 text-red-700 rounded border border-red-100">Alfa</span>
                                @endif
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-400 font-medium text-xs leading-relaxed">
                                <span class="text-3xl block mb-2">📋</span>
                                Belum ada data absensi pekerja untuk proyek ini hari ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center shadow-xs">
                <span class="text-4xl block mb-2">🏗️</span>
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider">Pilih Proyek Terlebih Dahulu</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium leading-relaxed">Silakan tentukan lokasi proyek di atas untuk mulai memasukkan atau melihat rekap absensi regu harian pekerja lapangan.</p>
            </div>
        @endif

    </div>

    <script>
        function switchTab(target) {
            const btnInput = document.getElementById('tab-button-input');
            const btnRiwayat = document.getElementById('tab-button-riwayat');
            const contentInput = document.getElementById('tab-content-input');
            const contentRiwayat = document.getElementById('tab-content-riwayat');
            if(!btnInput || !btnRiwayat) return;

            if (target === 'input') {
                btnInput.className = "flex-1 py-2.5 text-center text-xs font-black rounded-lg transition duration-200 bg-white text-gray-800 shadow-xs";
                btnRiwayat.className = "flex-1 py-2.5 text-center text-xs font-black rounded-lg transition duration-200 text-gray-500 hover:text-gray-800 flex items-center justify-center space-x-1.5";
                contentInput.classList.remove('hidden');
                contentRiwayat.classList.add('hidden');
            } else {
                btnRiwayat.className = "flex-1 py-2.5 text-center text-xs font-black rounded-lg transition duration-200 bg-white text-gray-800 shadow-xs flex items-center justify-center space-x-1.5";
                btnInput.className = "flex-1 py-2.5 text-center text-xs font-black rounded-lg transition duration-200 text-gray-500 hover:text-gray-800";
                contentRiwayat.classList.remove('hidden');
                contentInput.classList.add('hidden');
            }
        }

        @if($proyek)
        let indexPekerja = 1;
        const wrapper = document.getElementById('wrapper-pekerja');
        const btnTambah = document.getElementById('btn-tambah');

        btnTambah.addEventListener('click', function() {
            const htmlBaru = `
                <div class="p-3 border border-gray-100 rounded-xl bg-gray-50/50 flex flex-col space-y-2 baris-pekerja shadow-3xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono text-gray-400 nomor-urut">Pekerja #${indexPekerja + 1}</span>
                        <button type="button" onclick="hapusBaris(this)" class="text-[10px] text-red-500 font-bold hover:underline">❌ Hapus</button>
                    </div>
                    <input type="text" name="pekerja[${indexPekerja}][nama]" required placeholder="Ketik nama pekerja..." class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-500 font-bold text-gray-800 shadow-3xs">
                    <select name="pekerja[${indexPekerja}][status]" required class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-500 font-bold text-gray-700 outline-none shadow-3xs">
                        <option value="hadir">🟢 Hadir</option>
                        <option value="izin">🟡 Izin / Sakit</option>
                        <option value="alfa">🔴 Alfa / Tidak Datang</option>
                    </select>
                </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', htmlBaru);
            indexPekerja++;
        });

        function hapusBaris(tombol) {
            tombol.closest('.baris-pekerja').remove();
            const seluruhBaris = wrapper.querySelectorAll('.nomor-urut');
            seluruhBaris.forEach((span, i) => { span.innerText = `Pekerja #${i + 1}`; });
        }
        @endif
    </script>
</body>
</html>
