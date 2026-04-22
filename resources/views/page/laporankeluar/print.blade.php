<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Barang Keluar - Apotek JUJU</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            padding: 10px;
            color: #000;
        }
        .header-kop {
            text-align: center;
            border-bottom: 3px double #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header-kop h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .header-kop p {
            margin: 2px 0;
            font-size: 10pt;
        }
        h2 {
            text-align: center;
            text-transform: uppercase;
            font-size: 14pt;
            margin-bottom: 5px;
        }
        p.subtitle {
            text-align: center;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
            text-align: center;
            text-transform: uppercase;
            font-size: 9pt;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer-sign {
            margin-top: 40px;
            width: 100%;
        }
        .footer-sign td {
            border: none;
            width: 50%;
            text-align: center;
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

    <div class="header-kop">
        <h1>APOTEK JUJU</h1>
        <p>Jl. Cilolohan No. 81, Tasikmalaya, Jawa Barat</p>
        <p>Telp: (0265) 123456 | Email: apotekJUJU@gmail.com</p>
    </div>

    <h2>Laporan Barang Keluar</h2>
    <p class="subtitle">Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th width="120">Petugas</th>
                <th>Nama Obat</th>
                <th width="50">Jumlah</th>
                <th width="100">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($barangKeluar as $keluar)
                {{-- PERBAIKAN: Gunakan detailPenjualan sesuai Model --}}
                @php $rowCount = $keluar->detailPenjualan->count(); @endphp
                
                @if ($rowCount > 0)
                    @foreach ($keluar->detailPenjualan as $j => $item)
                        <tr>
                            @if ($j === 0)
                                <td rowspan="{{ $rowCount }}" class="text-center">{{ $no++ }}</td>
                                <td rowspan="{{ $rowCount }}" class="text-center">
                                    {{ \Carbon\Carbon::parse($keluar->tanggal)->format('d/m/Y') }}
                                </td>
                                <td rowspan="{{ $rowCount }}">
                                    {{ $keluar->user->name ?? 'Kasir Umum' }}
                                </td>
                            @endif
                            
                            <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>

                            @if ($j === 0)
                                <td rowspan="{{ $rowCount }}" class="text-right">
                                    Rp {{ number_format($keluar->total, 0, ',', '.') }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data penjualan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="font-size: 9pt; margin-top: 10px;">* Total Transaksi: <strong>{{ $barangKeluar->count() }}</strong></p>

    <table class="footer-sign">
        <tr>
            <td>
                <p>Dicetak Oleh,</p>
                <br><br><br>
                <p><strong>( {{ auth()->user()->name }} )</strong></p>
                <p style="font-size: 8pt;">Petugas Kasir</p>
            </td>
            <td>
                <p>Tasikmalaya, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                <p>Mengetahui,</p>
                <br><br><br>
                <p><strong>( ............................ )</strong></p>
                <p style="font-size: 8pt;">Pemilik Apotek</p>
            </td>
        </tr>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>