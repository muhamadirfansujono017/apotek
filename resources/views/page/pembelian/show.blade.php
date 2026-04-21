<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white flex items-center">
                <i class="fas fa-file-invoice text-indigo-600 me-3"></i> Detail Transaksi Pembelian
            </h2>
            <a href="{{ route('pembelian.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-bold transition">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">
            
            <div class="p-8 border-b border-gray-50 dark:border-gray-800">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mr-4">
                            <i class="fas fa-store text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Supplier</p>
                            <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $pembelian->supplier->nama_supplier }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Masuk</p>
                            <p class="text-lg font-bold text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($pembelian->tanggal)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center md:justify-end">
                        <div class="text-right">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Pembelian</p>
                            <p class="text-2xl font-black text-indigo-600">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Rincian Item Obat</p>
                <div class="overflow-hidden border border-gray-50 dark:border-gray-800 rounded-2xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-gray-800/50">
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">No</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Obat</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Jumlah</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Harga Satuan</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach ($pembelian->detail as $key => $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $key + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-800 dark:text-white">{{ $item->obat->nama_obat }}</div>
                                        <div class="text-[10px] text-gray-400">Satuan: {{ $item->obat->satuan ?? 'Pcs' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center font-bold text-indigo-600">
                                        {{ $item->jumlah }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right text-gray-600">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right font-black text-gray-900 dark:text-white">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-indigo-50/30 dark:bg-indigo-900/20">
                                <td colspan="4" class="px-6 py-5 text-sm font-black text-gray-500 text-right uppercase tracking-widest">Total Pembelian</td>
                                <td class="px-6 py-5 text-right font-black text-indigo-600 text-lg">
                                    Rp {{ number_format($pembelian->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="p-8 bg-gray-50 dark:bg-gray-800/50 flex justify-end space-x-4">
                <button onclick="window.print()" class="flex items-center bg-white border border-gray-200 text-gray-700 px-6 py-3 rounded-2xl font-bold text-sm shadow-sm hover:bg-gray-50 transition">
                    <i class="fas fa-print me-2 text-gray-400"></i> Cetak Nota
                </button>
                <a href="{{ route('pembelian.edit', $pembelian->id) }}" class="flex items-center bg-indigo-600 text-white px-8 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                    <i class="fas fa-edit me-2"></i> Edit Data
                </a>
            </div>
        </div>
    </div>
</x-app-layout>