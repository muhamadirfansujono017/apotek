<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-file-import text-green-500 me-3"></i> Laporan Barang Masuk
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
            
            <div class="p-6 bg-gray-50/50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-600 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">Ringkasan Laporan</h3>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">Total Transaksi: <span class="text-indigo-600">{{ $stok_masuk->total() }}</span></p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('obatmasuk.export') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold uppercase rounded-xl shadow-lg shadow-emerald-100 transition-all hover:-translate-y-0.5">
                        <i class="fas fa-file-excel me-2"></i> Export Excel
                    </a>
                    <a href="{{ route('laporanmasuk.print') }}" target="_blank" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase rounded-xl shadow-lg shadow-indigo-100 transition-all hover:-translate-y-0.5">
                        <i class="fas fa-print me-2"></i> Print Laporan
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">No</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">Supplier</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">Nama Obat</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider text-center">Jumlah</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-600">
                        @forelse ($stok_masuk as $i => $masuk)
                            {{-- Pastikan relasi 'detail' sesuai dengan yang ada di Model Pembelian --}}
                            @php $rowspan = $masuk->detail->count(); @endphp
                            
                            @if ($rowspan > 0)
                                @foreach ($masuk->detail as $j => $item)
                                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-gray-700/50 transition-colors">
                                        @if ($j == 0)
                                            <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300" rowspan="{{ $rowspan }}">
                                                {{ $stok_masuk->firstItem() + $i }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400" rowspan="{{ $rowspan }}">
                                                <span class="bg-gray-100 px-3 py-1 rounded-lg font-mono text-xs">
                                                    {{ \Carbon\Carbon::parse($masuk->tanggal)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white" rowspan="{{ $rowspan }}">
                                                {{ $masuk->supplier->nama_supplier ?? 'Umum' }}
                                            </td>
                                        @endif
                                        
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 border-l border-gray-50 dark:border-gray-700">
                                            {{ $item->obat->nama_obat ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center font-black text-indigo-600">
                                            {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>

                                        @if ($j == 0)
                                            <td class="px-6 py-4 text-xs text-gray-500 italic" rowspan="{{ $rowspan }}">
                                                {{ $masuk->keterangan ?? 'Transaksi Pembelian' }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open text-gray-200 text-5xl mb-4"></i>
                                        <p class="text-gray-400 italic">Tidak ada data transaksi masuk.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($stok_masuk->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-600">
                    {{ $stok_masuk->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>