<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LAPORAN_SISA_STOK_MATERIAL_{{ date('Ymd') }}</title>
    <style>
        body { font-family: sans-serif; color: #333; padding: 20px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px double #333; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .date-group { margin-top: 25px; margin-bottom: 10px; font-weight: bold; font-size: 13px; background: #f0f0f0; padding: 6px; text-transform: uppercase; }
        table { w-full; width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table, th, td { border: 1px solid #aaa; }
        th { background: #f9f9f9; padding: 8px; font-size: 10px; text-transform: uppercase; text-align: left; }
        td { padding: 8px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Laporan Kolektif Sisa Stok Material</h2>
        <p style="margin: 5px 0 0 0;">Politeknik Negeri Padang Construction Infrastructure System</p>
        <small>Dicetak otomatis pada: {{ date('d M Y H:i:s') }} WIB</small>
    </div>

    @foreach($groupedMaterials as $tanggal => $items)
        <div class="date-group">Tanggal Pelaporan: {{ date('l, d F Y', strtotime($tanggal)) }}</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Material</th>
                    <th class="text-center" style="width: 150px;">Sisa Stok Gudang</th>
                    <th>Lokasi Proyek Kerja</th>
                    <th>Penanggung Jawab (Mandor)</th>
                    <th class="text-right" style="width: 100px;">Jam Upload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td style="text-transform: capitalize; font-weight: bold;">{{ $item->nama_material }}</td>
                        <td class="text-center" style="font-weight: bold;">{{ $item->jumlah_sisa }} {{ $item->satuan }}</td>
                        <td>{{ $item->proyek->nama_proyek ?? 'N/A' }}</td>
                        <td>{{ $item->user->name ?? 'Mandor Lapangan' }}</td>
                        <td class="text-right">{{ $item->created_at->format('H:i') }} WIB</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 8px 20px; font-weight: bold; cursor: pointer;">Cetak Ulang</button>
    </div>

</body>
</html>
