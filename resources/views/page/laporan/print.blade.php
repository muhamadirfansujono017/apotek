<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laporan Data Barang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12pt;
            margin: 0;
            padding: 20px;
            background: #fff;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20pt;
            color: #4a4a4a;
        }

        .subtitle {
            text-align: center;
            font-size: 10pt;
            color: #777;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            color: #222;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .footer {
            margin-top: 30px;
            font-size: 10pt;
            text-align: right;
            color: #555;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 15mm;
            }
            .footer {
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>

    <h2>Laporan Data Barang</h2>
    <div class="subtitle">Dicetak oleh sistem pada {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</div>

    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $barang)
                <tr>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->satuan }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>{{ $barang->deskripsi ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; font-style: italic; color: #666;">Tidak ada data barang</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total Data: {{ $data->count() }} barang
    </div>

    <script>
        window.print();
    </script>

</body>
</html>
