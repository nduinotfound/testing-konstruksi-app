<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Progres Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('mandor.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-base text-gray-800 tracking-tight">Laporkan Progres Fisik</h2>
        </div>
        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Pelaporan Lapangan</span>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">

            <div class="mb-6 border-b border-gray-100 pb-4">
                <span class="text-[10px] font-black uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-1 rounded">Log Progres Kerja</span>
                <p class="text-xs text-gray-400 mt-2">Isi catatan kemajuan fisik proyek hari ini sebagai bukti valid ke kantor pusat.</p>
            </div>

            <form action="{{ route('mandor.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Pilih Proyek Tugas</label>
                    <select name="proyek_id" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl px-4 py-3 text-sm font-semibold text-gray-800 outline-none transition">
                        <option value="" disabled selected>-- Pilih Lokasi Proyek --</option>
                        @foreach($proyeks as $proyek)
                            <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }} ({{ $proyek->lokasi }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Tanggal Hari Ini</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                           class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl px-4 py-3 text-sm font-semibold text-gray-800 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Catatan Kemajuan Fisik</label>
                    <textarea name="keterangan_progres" rows="5" required placeholder="Contoh: Pengecoran tiang kolom lantai 1 sudah selesai, lanjut pemasangan batu bata dinding sisi barat..."
                              class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl px-4 py-3 text-sm font-semibold text-gray-800 placeholder-gray-400 outline-none transition resize-none leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                        Foto Dokumentasi Lapangan (Bisa Tambah Foto Berkali-kali)
                    </label>

                    <div id="grid-preview-foto" class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4 hidden"></div>

                    <div class="relative bg-gray-50 border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between border-dashed hover:border-blue-500 transition cursor-pointer group bg-white">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V3z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span id="label-status-foto" class="text-xs font-bold text-gray-400 transition">Pilih File / Ambil Gambar Progres</span>
                        </div>

                        <input type="file" id="input-foto-multi" name="foto_progres[]" accept="image/*" multiple class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-black text-xs tracking-wider uppercase py-4 rounded-xl shadow-md hover:bg-blue-700 active:scale-98 transition mt-3">
                    KIRIM LAPORAN FISIK KE PUSAT
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputFoto = document.getElementById('input-foto-multi');
            const gridPreview = document.getElementById('grid-preview-foto');
            const labelStatus = document.getElementById('label-status-foto');

            // Ini kontainer gaib buat nampung dan ngegabungin file-file foto
            let wadahFileSakti = new DataTransfer();

            inputFoto.addEventListener('change', function (event) {
                const filesBaru = event.target.files;

                // Memasukkan file yang baru dipilih ke dalam wadah utama tanpa nge-reset yang lama
                for (let i = 0; i < filesBaru.length; i++) {
                    wadahFileSakti.items.add(filesBaru[i]);
                }

                // Sinkronisasikan file asli di input file HTML dengan wadah sakti kita
                inputFoto.files = wadahFileSakti.files;

                // Render ulang tampilan preview ke layar HP mandor
                renderPreview();
            });

            function renderPreview() {
                gridPreview.innerHTML = '';
                const totalFiles = wadahFileSakti.files;

                if (totalFiles.length > 0) {
                    gridPreview.classList.remove('hidden');
                    labelStatus.innerText = totalFiles.length + " Foto progres siap dikirim!";
                    labelStatus.className = "text-xs font-extrabold text-blue-600 transition";

                    for (let i = 0; i < totalFiles.length; i++) {
                        const urlGambar = URL.createObjectURL(totalFiles[i]);

                        // Kita sekalian buatin tombol hapus (X) kecil di pojok kanan atas foto,
                        // mana tahu bapak-bapaknya salah masukin foto kucing/keluarga wkwk
                        const elementHtml = `
                            <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-3xs aspect-video group">
                                <img src="${urlGambar}" class="w-full h-full object-cover">
                                <span class="absolute bottom-1 right-1 bg-slate-900/70 text-white text-[9px] px-2 py-0.5 rounded font-bold">Foto ${i + 1}</span>
                                <button type="button" data-index="${i}" class="btn-hapus-foto absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-black shadow-sm transition">
                                    ✕
                                </button>
                            </div>
                        `;
                        gridPreview.insertAdjacentHTML('beforeend', elementHtml);
                    }

                    // Daftarkan event klik untuk tombol hapus foto
                    tambahEventHapus();
                } else {
                    gridPreview.classList.add('hidden');
                    labelStatus.innerText = "Pilih File / Ambil Gambar Progres";
                    labelStatus.className = "text-xs font-bold text-gray-400 transition";
                }
            }

            function tambahEventHapus() {
                const tombolHapus = document.querySelectorAll('.btn-hapus-foto');
                tombolHapus.forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.preventDefault(); // Mencegah form ke-submit secara tidak sengaja
                        const indexHapus = parseInt(this.getAttribute('data-index'));

                        // Buat kontainer data transfer baru untuk menyaring file yang tersisa
                        let wadahBaru = new DataTransfer();
                        const filesSaatIni = wadahFileSakti.files;

                        for (let i = 0; i < filesSaatIni.length; i++) {
                            if (i !== indexHapus) {
                                wadahBaru.items.add(filesSaatIni[i]);
                            }
                        }

                        // Update wadah utama dan sinkronisasi ke input file HTML
                        wadahFileSakti = wadahBaru;
                        inputFoto.files = wadahFileSakti.files;

                        // Render ulang preview terbaru
                        renderPreview();
                    });
                });
            }
        });
    </script>
</body>
</html>
