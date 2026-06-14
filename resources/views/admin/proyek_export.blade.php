<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LAPORAN_LOGISTIK_{{ Str::slug($proyek->nama_proyek, '_') }}_{{ date('Ymd') }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #222; padding: 25px; font-size: 11px; line-height: 1.4; }

        /* PAKSA BROWSER UNTUK TETAP MENAMPILKAN WARNA & GAMBAR SAAT CETAK PDF */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .kop-surat { text-align: center; margin-bottom: 25px; border-bottom: 3px double #333; padding-bottom: 12px; }
        .kop-surat h2 { margin: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
        .kop-surat p { margin: 4px 0 0 0; font-size: 11px; color: #555; }

        .meta-grid { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .meta-grid td { padding: 4px 0; border: none; vertical-align: top; }

        .section-title { font-size: 11px; font-weight: bold; background: #1e293b; color: #fff; padding: 6px 10px; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 25px; margin-bottom: 10px; border-radius: 4px; }

        /* STYLING DASAR UNTUK STRUKTUR TABEL FIXED MURNI */
        table.fixed-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; table-layout: fixed; }
        table.fixed-table, table.fixed-table th, table.fixed-table td { border: 1px solid #cbd5e1; }
        table.fixed-table tr { page-break-inside: auto; }
        table.fixed-table th { background: #f8fafc; padding: 8px; font-size: 9px; text-transform: uppercase; text-align: left; color: #475569; font-weight: bold; }
        table.fixed-table td { padding: 10px; vertical-align: top; word-wrap: break-word; }

        /* FLEX STACK VERTIKAL UNTUK BARISAN GAMBAR KE BAWAH */
        .img-vertical-stack {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        /* FIX UKURAN ASLI FOTO PROGRES (TABEL 1) */
        .img-progres-large {
            width: 100%;
            max-width: 180px;
            max-height: 160px;
            height: auto;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            display: block;
            page-break-inside: avoid;
        }

        /* FIX UKURAN ASLI FOTO NOTA (TABEL 2) */
        .img-nota-large {
            width: 100%;
            max-width: 220px;
            max-height: 240px;
            height: auto;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #94a3b8;
            display: block;
            page-break-inside: avoid;
        }

        .font-mono { font-family: monospace; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <div class="kop-surat">
        <h2>Laporan Rekapitulasi Kolektif & Audit Proyek</h2>
        <p>Sistem Pemantauan Infrastruktur & Logistik Lapangan Terintegrasi</p>
        <small style="color: #64748b;">Dicetak pada: {{ date('d F Y H:i') }} WIB</small>
    </div>

    <table class="meta-grid">
        <tr>
            <td style="width: 15%; font-weight: bold;">Nama Proyek</td>
            <td style="width: 2%;">:</td>
            <td style="width: 48%; font-weight: bold; color: #1e3a8a;">{{ $proyek->nama_proyek }}</td>
            <td style="width: 15%; font-weight: bold;">Status Proyek</td>
            <td style="width: 2%;">:</td>
            <td style="width: 18%; text-transform: uppercase; font-weight: bold;">{{ $proyek->status }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Lokasi Tugas</td>
            <td>:</td>
            <td>{{ $proyek->lokasi }}</td>
            <td style="font-weight: bold;">Total Pengeluaran</td>
            <td>:</td>
            <td class="font-bold" style="color: #b91c1c;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- ====== 1. RINGKASAN BUKU LOG PROGRES FISIK LAPANGAN ====== -->
    <div class="section-title">1. Ringkasan Buku Log Progres Fisik Lapangan</div>
    <table class="fixed-table">
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 18%;">Mandor Pelapor</th>
                <th style="width: 38%;">Uraian Progres Kerja Lapangan</th>
                <th style="width: 32%; text-align: center;">Visual Lapangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporanHarians as $laporan)
                <tr>
                    <td class="font-mono font-bold">{{ date('d M Y', strtotime($laporan->tanggal)) }}</td>
                    <td class="font-bold">{{ $laporan->user->name }}</td>
                    <td style="white-space: pre-line;">{{ $laporan->keterangan_progres }}</td>
                    <td>
                        <div class="img-vertical-stack">
                            @foreach(array_filter(explode(',', $laporan->foto_progres)) as $fProg)
                                @if(!empty(trim($fProg)))
                                    <img src="{{ asset('uploads/laporan/' . trim($fProg)) }}" class="img-progres-large" onerror="this.onerror=null; this.src='https://placehold.co/150x110?text=No+Image';">
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="color: #94a3b8; padding: 15px;">Belum ada log progres fisik yang dilaporkan untuk proyek ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ====== 2. REKAM JEJAK ALIRAN KAS & DOKUMEN STRUK NOTA ====== -->
    <div class="section-title">2. Rekam Jejak Aliran Kas & Dokumen Struk Nota</div>
    <table class="fixed-table">
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal Upload</th>
                <th style="width: 23%;">Mandor Pelapor</th>
                <th class="text-center" style="width: 50%;">Visual Bukti Struk Nota Belanja (High-Resolution Preview)</th>
                <th style="width: 15%; text-align: right;">Waktu Masuk</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notaBelanjas as $nota)
                <tr>
                    <td class="font-mono font-bold">{{ date('d M Y', strtotime($nota->tanggal)) }}</td>
                    <td class="font-bold">
                        {{ $nota->user->name }}
                        <br><small style="font-weight: normal; color: #64748b;">{{ $nota->user->email }}</small>
                    </td>
                    <td>
                        <div class="img-vertical-stack">
                            @foreach(array_filter(explode(',', $nota->foto_nota)) as $fNot)
                                @if(!empty(trim($fNot)))
                                    <img src="{{ asset('uploads/nota/' . trim($fNot)) }}" class="img-nota-large" onerror="this.onerror=null; this.src='https://placehold.co/180x240?text=No+Image';">
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td class="text-right font-mono">{{ $nota->created_at->format('H:i') }} WIB</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="color: #94a3b8; padding: 15px;">Belum ada dokumen nota logistik yang dikirim untuk proyek ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ====== BARISAN BARU TABEL 3: SISA STOK MATERIAL LAPANGAN ====== -->
    <div class="section-title">3. Sisa Stok Material Gudang Lapangan</div>
    <table class="fixed-table">
        <thead>
            <tr>
                <th style="width: 20%;">Tanggal Opname</th>
                <th style="width: 50%;">Nama Item Material</th>
                <th style="width: 30%; text-align: center;">Sisa Volume Lapangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proyek->materialSisas->groupBy(function($item) { return $item->created_at->format('Y-m-d'); }) as $tanggal => $items)
                @foreach($items as $index => $item)
                    <tr>
                        @if($index === 0)
                            <td rowspan="{{ $items->count() }}" class="font-mono font-bold" style="vertical-align: middle;">
                                {{ date('d M Y', strtotime($tanggal)) }}
                            </td>
                        @endif
                        <td class="font-bold text-gray-800 capitalize">{{ $item->nama_material }}</td>
                        <td class="text-center font-mono font-bold" style="color: #d97706;">
                            {{ $item->jumlah_sisa }} <span style="font-family: sans-serif; font-size: 9px; color: #6b7280;">{{ $item->satuan }}</span>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="3" class="text-center" style="color: #94a3b8; padding: 15px;">Tidak ada catatan sisa material opname untuk proyek ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ====== BARISAN BARU TABEL 4: BUKU CATATAN RINCIAN BIAYA & PENGELUARAN KAS ====== -->
    <div class="section-title">4. Buku Catatan Rincian Biaya & Pengeluaran Kas (Jurnal Admin)</div>
    <table class="fixed-table">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 35%;">Kategori & Keterangan Barang</th>
                <th style="width: 15%; text-align: center;">Volume</th>
                <th style="width: 20%; text-align: right;">Harga Satuan</th>
                <th style="width: 15%; text-align: right;">Total Net (+PPN)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proyek->pengeluarans->groupBy('tanggal') as $tanggal => $items)
                @foreach($items as $index => $item)
                    <tr>
                        @if($index === 0)
                            <td rowspan="{{ $items->count() }}" class="font-mono font-bold" style="vertical-align: middle; background: #fdfdfd;">
                                {{ date('d M Y', strtotime($tanggal)) }}
                                <br><small style="color: #059669; font-weight: bold;">Rp {{ number_format($items->sum('harga_total'), 0, ',', '.') }}</small>
                            </td>
                        @endif
                        <td>
                            <span style="font-size: 8px; color: #9ca3af; text-transform: uppercase; display: block; margin-bottom: 2px;">{{ $item->tipe_pengeluaran }}</span>
                            <span class="font-bold" style="color: #1f2937;">{{ $item->nama_material }}</span>
                        </td>
                        <td class="text-center font-mono">
                            {{ $item->qty }} <span style="font-family: sans-serif; font-size: 9px; color: #9ca3af;">{{ $item->satuan }}</span>
                        </td>
                        <td class="text-right font-mono text-gray-500">
                            {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class="text-right font-mono font-bold" style="color: #059669; background: #f0fdf4/20;">
                            {{ number_format($item->harga_total, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #94a3b8; padding: 15px;">Belum ada rincian data transaksi pengeluaran kas keuangan untuk proyek ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 35px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 30px; font-weight: bold; background: #2563eb; color: #fff; border: none; border-radius: 6px; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            Cetak / Simpan PDF
        </button>
    </div>

</body>
</html>
