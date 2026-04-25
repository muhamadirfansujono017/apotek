<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4">
        {{-- Kartu Struk Utama --}}
        <div
            class="bg-white dark:bg-gray-900 shadow-2xl rounded-[3rem] overflow-hidden border border-gray-100 dark:border-gray-800 relative">

            {{-- Penanda Status Watermark (PAID/DUE) --}}
            <div class="absolute top-10 right-10 opacity-10 transform rotate-12 pointer-events-none print:opacity-20">
                @if ($penjualan->bayar >= $penjualan->total_harga)
                    <div class="border-8 border-green-600 p-4 rounded-3xl">
                        <h1 class="text-7xl font-black text-green-600 uppercase">PAID</h1>
                    </div>
                @else
                    <div class="border-8 border-red-600 p-4 rounded-3xl">
                        <h1 class="text-7xl font-black text-red-600 uppercase">DUE</h1>
                    </div>
                @endif
            </div>

            {{-- Header Struk --}}
            <div class="p-10 border-b border-dashed border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row justify-between items-start">
                    <div>
                        <h1 class="text-4xl font-black text-indigo-600 italic uppercase tracking-tighter">APOTEK IRFAN
                        </h1>
                        <p class="text-gray-400 text-sm font-bold">Jl. Cilolohan No. 81, Tasikmalaya</p>

                        <div class="mt-4 inline-flex items-center gap-2">
                            @if ($penjualan->bayar >= $penjualan->total_harga)
                                <span
                                    class="px-4 py-1.5 bg-green-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-green-200 uppercase tracking-widest">
                                    ● TERBAYAR LUNAS
                                </span>
                            @else
                                <span
                                    class="px-4 py-1.5 bg-red-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-red-200 uppercase tracking-widest animate-pulse">
                                    ● BELUM LUNAS
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="text-right mt-8 md:mt-0">
                        <h2 class="text-2xl font-black uppercase text-gray-800 dark:text-white leading-none">
                            {{ $penjualan->no_faktur }}
                        </h2>
                        <p class="text-gray-400 font-bold mt-2 uppercase text-xs tracking-[0.2em]">
                            {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d F Y') }}
                        </p>
                        <p class="text-[10px] font-black text-indigo-500 uppercase mt-1">
                            KASIR: {{ $penjualan->user->name ?? 'ADMIN' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Tabel Item Belanja --}}
            <div class="p-10">
                <table class="w-full text-left">
                    <thead class="text-[10px] font-black text-gray-400 uppercase border-b-2 tracking-widest">
                        <tr>
                            <th class="pb-4">ITEM OBAT</th>
                            <th class="pb-4 text-center">QTY</th>
                            <th class="pb-4 text-right">HARGA</th>
                            <th class="pb-4 text-right">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        {{-- Menggunakan relasi detailPenjualan --}}
                        @forelse ($penjualan->detailPenjualan as $item)
                            <tr>
                                <td class="py-6 font-black uppercase dark:text-white text-sm tracking-tight">
                                    {{ $item->obat->nama_obat ?? 'PRODUK OBAT' }}
                                </td>
                                <td class="py-6 text-center font-bold text-gray-600">
                                    {{ $item->jumlah }}
                                </td>
                                <td class="py-6 text-right font-medium text-gray-500">
                                    {{-- Pastikan memanggil 'harga' atau 'harga_satuan' sesuai database --}}
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </td>
                                <td class="py-6 text-right font-black text-indigo-600 text-lg">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            {{-- Tampilan jika data benar-benar tidak ditemukan --}}
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-400">
                                    Data item tidak ditemukan di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Keuangan (Sesuai Struktur DB Kamu) --}}
            <div class="p-10 bg-indigo-600 text-white rounded-b-[3rem] shadow-inner">
                <div class="space-y-3 mb-10">
                    <div class="flex justify-between text-xs opacity-70 font-black uppercase tracking-[0.3em]">
                        <span>TOTAL BELANJA</span>
                        <span>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs opacity-70 font-black uppercase tracking-[0.3em]">
                        <span>JUMLAH BAYAR</span>
                        <span>Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div
                    class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-indigo-400/40 gap-4">
                    <div class="text-center md:text-left leading-none">
                        <span class="text-[10px] font-black uppercase tracking-[0.4em] opacity-60 block mb-2">
                            {{ $penjualan->bayar >= $penjualan->total_harga ? 'KEMBALIAN' : 'KEKURANGAN' }}
                        </span>
                        <span class="text-2xl font-black uppercase tracking-tighter italic">
                            {{ $penjualan->bayar >= $penjualan->total_harga ? 'SUDAH LUNAS' : 'BELUM LUNAS' }}
                        </span>
                    </div>
                    <span class="text-7xl font-black italic tracking-tighter drop-shadow-2xl">
                        {{-- Menggunakan kolom 'kembalian' sesuai database kamu --}}
                        Rp {{ number_format(abs($penjualan->kembalian), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Navigasi Tombol --}}
        <div class="mt-12 flex flex-wrap justify-center gap-6 print:hidden">
            <button onclick="window.print()"
                class="bg-gray-900 text-white px-12 py-4 rounded-2xl font-black uppercase text-xs shadow-xl hover:bg-black transition-all hover:-translate-y-1 active:scale-95">
                CETAK STRUK
            </button>
            <a href="{{ route('penjualan.index') }}"
                class="bg-white text-gray-400 border-2 border-gray-100 px-12 py-4 rounded-2xl font-black uppercase text-xs hover:bg-gray-50 transition-all shadow-sm">
                KEMBALI
            </a>
        </div>

        {{-- Footer Branding --}}
        <div class="mt-12 text-center print:hidden">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">
                &copy; 2026 Apotek Irfan. Politeknik LP3I Tasikmalaya.
            </p>
        </div>
    </div>

    {{-- CSS Khusus Cetak --}}
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }

            nav,
            .print\:hidden {
                display: none !important;
            }

            .shadow-2xl,
            .shadow-xl {
                box-shadow: none !important;
            }

            .rounded-\[3rem\] {
                border-radius: 0 !important;
                border: none !important;
            }

            .py-12 {
                padding: 0 !important;
            }

            .bg-indigo-600 {
                background-color: #4f46e5 !important;
                -webkit-print-color-adjust: exact;
                color: white !important;
            }

            .text-indigo-600 {
                color: #4f46e5 !important;
            }

            .bg-green-500 {
                background-color: #22c55e !important;
                -webkit-print-color-adjust: exact;
            }

            .bg-red-500 {
                background-color: #ef4444 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</x-app-layout>
