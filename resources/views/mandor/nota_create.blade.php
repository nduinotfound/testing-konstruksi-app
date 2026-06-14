<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto Nota Belanja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('mandor.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-base text-gray-800 tracking-tight">Upload Nota Belanja</h2>
        </div>
        <span class="text-xs font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full">Log Logistik</span>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">

            <div class="mb-6 border-b border-gray-100 pb-4">
                <span class="text-[10px] font-black uppercase tracking-wider text-red-600 bg-red-50 px-2 py-1 rounded">Jepret Bukti Nota</span>
                <p class="text-xs text-gray-400 mt-2">Kirim dokumen foto nota belanja langsung dari lapangan untuk arsip proyek.</p>
            </div>

            <form action="{{ route('mandor.nota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Lokasi Proyek</label>
                    <select name="proyek_id" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl px-4 py-3 text-sm font-semibold text-gray-800 outline-none transition">
                        <option value="" disabled selected>-- Pilih Lokasi Proyek --</option>
                        @foreach($proyeks as $proyek)
                            <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }} ({{ $proyek->lokasi }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Tanggal Pembelian / Kwitansi</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                           class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl px-4 py-3 text-sm font-semibold text-gray-800 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Foto Nota / Struk Pembelian (Bisa Tambah Berkali-kali)</label>

                    <div id="grid-preview-nota" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4 hidden"></div>

                    <div class="relative bg-gray-50 border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between border-dashed hover:border-red-500 transition cursor-pointer group bg-white">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V3z"></path></svg>
                            </div>
                            <span id="label-status-nota" class="text-xs font-bold text-gray-400 transition">Pilih Satu atau Banyak Struk Sekaligus...</span>
                        </div>

                        <input type="file" id="input-nota-multi" name="foto_nota[]" accept="image/*" multiple class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white font-black text-xs tracking-wider uppercase py-4 rounded-xl shadow-md hover:bg-red-700 active:scale-98 transition mt-3">
                    KIRIM FOTO NOTA KE KANTOR PUSAT
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputNota = document.getElementById('input-nota-multi');
            const gridPreview = document.getElementById('grid-preview-nota');
            const labelStatus = document.getElementById('label-status-nota');

            // Kontainer celengan data transfer file nota
            let wadahNotaMurni = new DataTransfer();

            inputNota.addEventListener('change', function (event) {
                const filesBaru = event.target.files;

                // Masukkan berkas struk baru ke dalam celengan tanpa menghapus yang lama
                for (let i = 0; i < filesBaru.length; i++) {
                    wadahNotaMurni.items.add(filesBaru[i]);
                }

                // Sinkronisasikan berkas asli HTML dengan celengan kita
                inputNota.files = wadahNotaMurni.files;

                // Render thumbnail preview nota ke layar
                renderPreviewNota();
            });

            function renderPreviewNota() {
                gridPreview.innerHTML = '';
                const totalFiles = wadahNotaMurni.files;

                if (totalFiles.length > 0) {
                    gridPreview.classList.remove('hidden');
                    labelStatus.innerText = `${totalFiles.length} Struk Nota Terpilih!`;
                    labelStatus.className = "text-xs font-extrabold text-red-600 transition";

                    for (let i = 0; i < totalFiles.length; i++) {
                        const urlGambar = URL.createObjectURL(totalFiles[i]);

                        // Menampilkan preview berbentuk square lengkap dengan tombol silang hapus (✕)
                        const elementHtml = `
                            <div class="relative aspect-square border border-gray-200 rounded-xl overflow-hidden shadow-3xs bg-gray-50 group">
                                <img src="${urlGambar}" class="w-full h-full object-cover">
                                <button type="button" data-index="${i}" class="btn-hapus-nota absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-black shadow-sm transition">
                                    ✕
                                </button>
                            </div>
                        `;
                        gridPreview.insertAdjacentHTML('beforeend', elementHtml);
                    }

                    // Aktifkan fungsi hapus item terpilih
                    aktifkanEventHapusNota();
                } else {
                    gridPreview.classList.add('hidden');
                    labelStatus.innerText = "Pilih Satu atau Banyak Struk Sekaligus...";
                    labelStatus.className = "text-xs font-bold text-gray-400 transition";
                }
            }

            function aktifkanEventHapusNota() {
                const tombolHapus = document.querySelectorAll('.btn-hapus-nota');
                tombolHapus.forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.preventDefault(); // Mengunci form agar tidak terkirim tidak sengaja
                        const indexHapus = parseInt(this.getAttribute('data-index'));

                        let wadahSaringanBaru = new DataTransfer();
                        const filesSaatIni = wadahNotaMurni.files;

                        for (let i = 0; i < filesSaatIni.length; i++) {
                            if (i !== indexHapus) {
                                wadahSaringanBaru.items.add(filesSaatIni[i]);
                            }
                        }

                        // Update kontainer utama dengan hasil saringan baru
                        wadahNotaMurni = wadahSaringanBaru;
                        inputNota.files = wadahNotaMurni.files;

                        // Segarkan preview di layar
                        renderPreviewNota();
                    });
                });
            }
        });
    </script>
</body>
</html>
