<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - Apotek Irfan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page { margin: 1.5cm; }
            .no-print { display: none; }
        }
        body { background: white; font-family: 'serif'; }
    </style>
</head>
<body onload="window.print()">
    <div class="max-w-5xl mx-auto p-10">
        {{-- Tombol Navigasi --}}
        <div class="no-print mb-10 flex justify-between">
            <a href="{{ route('laporan.obat.index') }}" class="text-[10px] font-black uppercase text-gray-400 hover:text-indigo-600 tracking-widest">← Kembali</a>
            <button onclick="window.print()" class="text-[10px] font-black uppercase bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-lg">Print Sekarang</button>
        </div>

        {{-- KOP SURAT --}}
        <div class="text-center border-b-4 border-double border-gray-800 pb-6 mb-8 uppercase">
            <h1 class="text-4xl font-black tracking-tighter italic">APOTEK IRFAN</h1>
            <p class="text-sm font-bold tracking-widest text-gray-600">Jl. Cilolohan No. 81, Tasikmalaya, Jawa Barat</p>
            <p class="text-[10px] font-medium text-gray-500 mt-1">Laporan Stok Obat Inventaris Apotek</p>
        </div>

        {{-- Info Laporan --}}
        <div class="mb-8 flex justify-between items-end border-b pb-4">
            <div>
                <h2 class="text-lg font-black uppercase tracking-tighter">Laporan Stok Obat</h2>
                @if(request('tgl_awal') && request('tgl_akhir'))
                    <p class="text-[10px] font-bold text-indigo-600 uppercase">
                        Periode: {{ \Carbon\Carbon::parse(request('tgl_awal'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tgl_akhir'))->format('d/m/Y') }}
                    </p>
                @else
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Periode: Semua Data</p>
                @endif
            </div>
            <div class="text-right text-[9px] font-black uppercase text-gray-400 leading-tight">
                <p>Dicetak Oleh: {{ Auth::user()->name }}</p>
                <p>Waktu: {{ date('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- Tabel Utama --}}
        <table class="w-full text-left border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-[10px] font-black uppercase tracking-widest border border-gray-300 text-gray-700">
                    <th class="p-3 border border-gray-300 text-center">No</th>
                    <th class="p-3 border border-gray-300">Kode Obat</th>
                    <th class="p-3 border border-gray-300">Nama Obat</th>
                    <th class="p-3 border border-gray-300 text-center">Stok</th>
                    <th class="p-3 border border-gray-300 text-right pr-4">Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obat as $key => $item)
                <tr class="text-xs border border-gray-300">
                    <td class="p-3 border border-gray-300 text-center font-bold text-gray-400">{{ $key + 1 }}</td>
                    <td class="p-3 border border-gray-300 font-black uppercase tracking-tighter text-indigo-700">{{ $item->kode_obat }}</td>
                    <td class="p-3 border border-gray-300 font-bold uppercase">{{ $item->nama_obat }}</td>
                    <td class="p-3 border border-gray-300 text-center font-black {{ $item->stok <= 10 ? 'text-red-600' : '' }}">{{ $item->stok }}</td>
                    <td class="p-3 border border-gray-300 text-right font-bold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tanda Tangan --}}
        <div class="mt-20 flex justify-end">
            <div class="text-center w-64">
                <p class="text-xs font-bold text-gray-600">Tasikmalaya, {{ date('d F Y') }}</p>
                <p class="text-xs font-black uppercase mt-1">Penanggung Jawab,</p>
                <div class="mt-24 border-b-2 border-gray-800"></div>
                <p class="text-xs font-black uppercase mt-2 italic">{{ Auth::user()->name }}</p>
                <p class="text-[9px] text-gray-400 uppercase tracking-widest">Apotek Irfan Management</p>
            </div>
        </div>
    </div>
</body>
</html>