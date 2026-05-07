<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - Apotek JUJU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page { 
                margin: 1.5cm; 
                size: portrait;
            }
            .no-print { display: none; }
            tr { page-break-inside: avoid !important; }
        }
        body { background: white; font-family: 'serif'; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000 !important; }
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
            <h1 class="text-4xl font-black tracking-tighter italic">APOTEK JUJU</h1>
            <p class="text-sm font-bold tracking-widest text-gray-600">Jl. Cilolohan No. 81, Tasikmalaya, Jawa Barat</p>
            <p class="text-[10px] font-medium text-gray-500 mt-1">Laporan Stok Obat Inventaris Apotek</p>
        </div>

        {{-- Info Laporan --}}
        <div class="mb-8 flex justify-between items-end border-b pb-4 border-gray-200">
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
        <table class="w-full text-left border-collapse border border-black">
            <thead>
                <tr class="bg-gray-100 text-[10px] font-black uppercase tracking-widest text-gray-700">
                    <th class="p-3 text-center w-10">No</th>
                    <th class="p-3">Tanggal Input</th> {{-- Tambahan Kolom Tanggal --}}
                    <th class="p-3">Kode Obat</th>
                    <th class="p-3">Nama Obat</th>
                    <th class="p-3 text-center">Kategori</th> {{-- Tambahan Kolom Kategori --}}
                    <th class="p-3 text-center">Stok</th>
                    <th class="p-3 text-right pr-4">Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @forelse($obat as $key => $item)
                <tr class="text-xs">
                    <td class="p-3 text-center font-bold text-gray-400">{{ $key + 1 }}</td>
                    <td class="p-3 text-gray-600">
                        {{ $item->created_at->format('d/m/Y') }}
                    </td>
                    <td class="p-3 font-black uppercase tracking-tighter text-indigo-700">{{ $item->kode_obat }}</td>
                    <td class="p-3 font-bold uppercase">{{ $item->nama_obat }}</td>
                    <td class="p-3 text-center italic text-gray-500 uppercase text-[10px]">{{ $item->kategori }}</td>
                    <td class="p-3 text-center font-black {{ $item->stok <= 10 ? 'text-red-600' : '' }}">{{ $item->stok }}</td>
                    <td class="p-3 text-right font-black">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-10 text-center text-gray-400 italic font-bold uppercase tracking-widest">
                        Data tidak ditemukan untuk periode ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Tanda Tangan --}}
        <div class="mt-20 flex justify-end">
            <div class="text-center w-64">
                <p class="text-xs font-bold text-gray-600">Tasikmalaya, {{ date('d F Y') }}</p>
                <p class="text-xs font-black uppercase mt-1">Penanggung Jawab,</p>
                <div class="mt-20 border-b-2 border-gray-800"></div>
                <p class="text-xs font-black uppercase mt-2 italic">{{ Auth::user()->name }}</p>
                <p class="text-[9px] text-gray-400 uppercase tracking-widest">Apotek JUJU Management</p>
            </div>
        </div>
    </div>
</body>
</html>