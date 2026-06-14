<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Sisa Stok Material Proyek</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 pb-12 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center space-x-3">
            <a href="{{ route('mandor.dashboard') }}" class="p-2 -ml-2 text-gray-600 active:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-base text-gray-800 tracking-tight">Stok Sisa Material</h2>
        </div>
        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">Log Logistik</span>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ materials: [{ nama_material: '', jumlah_sisa: '', satuan: '' }] }">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">

            <div class="mb-6 border-b border-gray-100 pb-4">
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-600 bg-amber-50 px-2 py-1 rounded">Kendali Opname Gudang Multi-Baris</span>
                <p class="text-xs text-gray-400 mt-2">Catat seluruh sisa material yang belum terpakai di lapangan secara kolektif agar mempercepat pelaporan logistik.</p>
            </div>

            <form action="{{ route('mandor.material.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Lokasi Proyek Tujuan Tugas</label>
                    <select name="proyek_id" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl px-4 py-3 text-sm font-semibold text-gray-800 outline-none transition">
                        <option value="" disabled selected>-- Pilih Lokasi Proyek --</option>
                        @foreach($proyeks as $proyek)
                            <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }} ({{ $proyek->lokasi }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-4">
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1">Daftar Item Material Lapangan</label>

                    <template x-for="(material, index) in materials" :key="index">
                        <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4 relative space-y-3 sm:space-y-0 sm:flex sm:items-center sm:space-x-3">

                            <div class="absolute -top-2.5 -left-2 sm:static bg-gray-200 text-gray-700 w-6 h-6 rounded-full flex items-center justify-center text-xs font-black shadow-3xs" x-text="index + 1"></div>

                            <div class="flex-1">
                                <input type="text" :name="`materials[${index}][nama_material]`" required placeholder="Nama Material (Semen Padang, Besi 10mm)"
                                       class="w-full bg-white border border-gray-200 focus:border-blue-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                            </div>

                            <div class="w-full sm:w-32">
                                <input type="number" :name="`materials[${index}][jumlah_sisa]`" min="0" required placeholder="Sisa"
                                       class="w-full bg-white border border-gray-200 focus:border-blue-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                            </div>

                            <div class="w-full sm:w-32">
                                <input type="text" :name="`materials[${index}][satuan]`" required placeholder="Satuan (Sak, Btg)"
                                       class="w-full bg-white border border-gray-200 focus:border-blue-500 rounded-xl px-3 py-2.5 text-xs font-semibold text-gray-800 outline-none transition">
                            </div>

                            <div class="text-right sm:text-center">
                                <button type="button" @click="if(materials.length > 1) materials.splice(index, 1)"
                                        class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition active:scale-95"
                                        :class="materials.length === 1 ? 'opacity-30 cursor-not-allowed' : ''">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>

                        </div>
                    </template>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <button type="button" @click="materials.push({ nama_material: '', jumlah_sisa: '', satuan: '' })"
                            class="border border-dashed border-amber-500 text-amber-600 bg-amber-50/40 hover:bg-amber-50 font-black text-xs tracking-wider uppercase px-5 py-3 rounded-xl transition flex items-center justify-center space-x-2 active:scale-98">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Tambah Baris Material</span>
                    </button>

                    <button type="submit" class="bg-amber-500 text-white font-black text-xs tracking-wider uppercase px-8 py-3.5 rounded-xl shadow-md hover:bg-amber-600 active:scale-98 transition">
                        SIMPAN SEMUA MATERIAL
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
