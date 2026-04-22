<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[3rem] overflow-hidden border border-gray-100 dark:border-gray-800">
            <div class="p-10 border-b border-dashed border-gray-200 text-center md:text-left">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-black text-indigo-600 italic">APOTEK JUJU</h1>
                        <p class="text-gray-400 text-sm">Jl. Cilolohan No. 81, Tasikmalaya</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-2xl font-black uppercase text-gray-800 dark:text-white">#PJL-{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}</h2>
                        <p class="text-gray-400 font-bold">{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-10">
                <table class="w-full text-left">
                    <thead class="text-xs font-black text-gray-400 uppercase border-b-2">
                        <tr>
                            <th class="pb-4">Item</th>
                            <th class="pb-4 text-center">Qty</th>
                            <th class="pb-4 text-right">Harga</th>
                            <th class="pb-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($penjualan->detailPenjualan as $detail)
                        <tr>
                            <td class="py-5 font-bold uppercase dark:text-white">{{ $detail->obat->nama_obat ?? 'Produk' }}</td>
                            <td class="py-5 text-center">{{ $detail->jumlah }}</td>
                            <td class="py-5 text-right font-medium text-gray-500">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-5 text-right font-black text-indigo-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-10 bg-indigo-600 text-white space-y-2">
                <div class="flex justify-between text-sm opacity-70 font-bold uppercase">
                    <span>Total Belanja</span>
                    <span>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm opacity-70 font-bold uppercase">
                    <span>Bayar (Cash)</span>
                    <span>Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-indigo-400 mt-2">
                    <span class="text-xl font-black uppercase">Kembalian</span>
                    <span class="text-4xl font-black italic">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="mt-8 flex justify-center gap-4 print:hidden">
            <button onclick="window.print()" class="bg-gray-800 text-white px-8 py-3 rounded-xl font-bold uppercase text-xs">Cetak Struk</button>
            <a href="{{ route('penjualan.index') }}" class="bg-gray-100 text-gray-400 px-8 py-3 rounded-xl font-bold uppercase text-xs">Kembali</a>
        </div>
    </div>
</x-app-layout>