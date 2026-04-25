<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-box-open text-orange-500 me-3"></i> Laporan Barang Keluar
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
            
            {{-- Header Laporan --}}
            <div class="p-6 bg-gray-50/50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-600 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">Ringkasan Penjualan</h3>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        Total Transaksi Keluar: <span class="text-orange-600">{{ $barangKeluar->total() }}</span>
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('obatkeluar.export') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold uppercase rounded-xl shadow-lg shadow-emerald-100 transition-all hover:-translate-y-0.5">
                        <i class="fas fa-file-excel me-2"></i> Ekspor Excel
                    </a>
                    <a href="{{ route('laporankeluar.print') }}" target="_blank" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase rounded-xl shadow-lg shadow-blue-100 transition-all hover:-translate-y-0.5">
                        <i class="fas fa-print me-2"></i> Print Laporan
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider text-center">No</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">Petugas/Kasir</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider">Nama Obat</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider text-center">Jumlah</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-wider text-right">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-600">
                        @forelse ($barangKeluar as $i => $keluar)
                            @php 
                                // Pastikan relasi detailPenjualan sudah didefinisikan di Model Penjualan
                                $rincian = $keluar->detailPenjualan; 
                                $rowspan = $rincian ? $rincian->count() : 0;
                            @endphp

                            @if ($rowspan > 0)
                                @foreach ($rincian as $j => $item)
                                    <tr class="hover:bg-orange-50/30 dark:hover:bg-gray-700/50 transition-colors">
                                        {{-- Kolom yang di-merge menggunakan rowspan --}}
                                        @if ($j === 0)
                                            <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300 text-center" rowspan="{{ $rowspan }}">
                                                {{ $barangKeluar->firstItem() + $i }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $rowspan }}">
                                                <span class="bg-gray-100 dark:bg-gray-600 px-3 py-1 rounded-lg font-mono text-xs text-gray-600 dark:text-gray-300">
                                                    {{ \Carbon\Carbon::parse($keluar->tanggal)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white" rowspan="{{ $rowspan }}">
                                                {{ $keluar->user->name ?? 'Kasir Umum' }}
                                            </td>
                                        @endif

                                        {{-- Kolom rincian obat per baris --}}
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 border-l border-gray-50 dark:border-gray-700">
                                            {{ $item->obat->nama_obat ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center font-black text-orange-600">
                                            {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>

                                        {{-- PERBAIKAN: Menggunakan total_harga agar tidak Rp 0 --}}
                                        @if ($j === 0)
                                            <td class="px-6 py-4 text-right font-black text-gray-900 dark:text-white" rowspan="{{ $rowspan }}">
                                                Rp {{ number_format($keluar->total_harga, 0, ',', '.') }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                {{-- Jika ada transaksi tapi rinciannya tidak sengaja terhapus --}}
                                <tr class="bg-red-50/50">
                                    <td class="px-6 py-4 text-center font-bold text-gray-400">{{ $barangKeluar->firstItem() + $i }}</td>
                                    <td class="px-6 py-4 font-mono text-xs">{{ \Carbon\Carbon::parse($keluar->tanggal)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 italic text-gray-400" colspan="3">Rincian item tidak ditemukan</td>
                                    <td class="px-6 py-4 text-right font-black text-gray-900">Rp {{ number_format($keluar->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-receipt text-gray-200 text-6xl mb-4"></i>
                                        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada transaksi barang keluar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($barangKeluar->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-600">
                    {{ $barangKeluar->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>