<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-800 dark:text-white uppercase">
                <i class="fas fa-file-invoice-dollar text-indigo-600 me-2"></i> Detail Transaksi
            </h2>
            <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg hover:bg-indigo-700 print:hidden">
                <i class="fas fa-print me-2"></i> CETAK STRUK
            </button>
        </div>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">
            
            <div class="p-10 border-b border-dashed border-gray-200 dark:border-gray-700">
                <div class="flex justify-between">
                    <div>
                        <h1 class="text-4xl font-black text-indigo-600 italic">APOTEK IRFAN</h1>
                        <p class="text-gray-500 text-sm">Jl. Cilolohan No. 81, Tasikmalaya</p>
                    </div>
                    <div class="text-right uppercase">
                        <h2 class="text-xl font-bold">#PJL-{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}</h2>
                        <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-10">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-black text-gray-400 uppercase border-b-2 border-gray-100">
                            <th class="pb-4">Nama Obat</th>
                            <th class="pb-4 text-center">Qty</th>
                            <th class="pb-4 text-right">Harga</th>
                            <th class="pb-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($penjualan->detailPenjualan as $detail)
                        <tr>
                            <td class="py-5 font-bold text-gray-800 dark:text-white uppercase">
                                {{ $detail->obat->nama_obat ?? 'PRODUK' }}
                            </td>
                            <td class="py-5 text-center font-bold">{{ $detail->jumlah }}</td>
                            <td class="py-5 text-right font-bold text-gray-600">
                                {{-- LOGIKA CADANGAN: Ambil harga_satuan atau harga --}}
                                Rp {{ number_format($detail->harga_satuan ?? $detail->harga ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-5 text-right font-black text-indigo-600">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-10 bg-indigo-600 text-white flex flex-col gap-2">
                <div class="flex justify-between text-sm font-bold opacity-80 uppercase">
                    <span>Total Belanja</span>
                    <span>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold opacity-80 uppercase">
                    <span>Bayar (Cash)</span>
                    <span>Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-indigo-400 mt-2">
                    <span class="text-xl font-black uppercase">Kembalian</span>
                    <span class="text-4xl font-black italic">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>