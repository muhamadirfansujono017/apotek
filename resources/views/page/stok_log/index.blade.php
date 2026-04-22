<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    <i class="fas fa-history text-indigo-600 me-3"></i>
                    Catatan Arus Obat
                </h2>
                <p class="text-gray-500 dark:text-gray-400 font-medium text-sm mt-1">Pantau kapan obat masuk dan kapan obat terjual secara otomatis.</p>
            </div>
            <a href="{{ route('stok_log.create') }}" class="inline-flex items-center justify-center bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-2xl font-black shadow-xl transition-all text-xs uppercase tracking-widest active:scale-95">
                <i class="fas fa-edit me-2"></i> Update Stok Manual
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-4">
                <div class="h-12 w-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-plus-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Stok Masuk</p>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-200">Barang Bertambah</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-4">
                <div class="h-12 w-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-minus-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Stok Keluar</p>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-200">Barang Berkurang</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-2xl shadow-gray-200/50 dark:shadow-none rounded-[2.5rem] border border-white dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-50/50 dark:bg-gray-800/50 text-[10px] uppercase font-black text-gray-400 tracking-[0.2em]">
                        <tr>
                            <th class="px-8 py-6">Tanggal & Waktu</th>
                            <th class="px-8 py-6">Nama Obat</th>
                            <th class="px-4 py-6 text-center">Status</th>
                            <th class="px-4 py-6 text-center">Jumlah</th>
                            <th class="px-8 py-6">Alasan / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($logs as $log)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="font-bold text-gray-800 dark:text-white block tracking-tight">{{ $log->created_at->translatedFormat('d M Y') }}</span>
                                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-tighter italic">{{ $log->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-8 py-6 text-gray-500">
                                <div class="font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-indigo-600 transition-colors">{{ $log->obat->nama_obat }}</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase italic">Kode: {{ $log->obat->kode_obat }}</div>
                            </td>
                            <td class="px-4 py-6 text-center">
                                @if($log->tipe == 'masuk')
                                    <span class="inline-flex items-center px-4 py-1.5 bg-emerald-500 text-white rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg shadow-emerald-200/50">
                                        <i class="fas fa-arrow-down me-1.5"></i> Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-1.5 bg-rose-500 text-white rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg shadow-rose-200/50">
                                        <i class="fas fa-arrow-up me-1.5"></i> Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-6 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-xl font-black {{ $log->tipe == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $log->tipe == 'masuk' ? '+' : '-' }}{{ $log->jumlah }}
                                    </span>
                                    <span class="text-[9px] font-bold text-gray-300 uppercase">Satuan</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="bg-gray-50 dark:bg-gray-800/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 leading-relaxed italic">
                                        "{{ $log->keterangan ?? 'Tidak ada keterangan tambahan.' }}"
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="font-bold text-gray-400 uppercase text-xs tracking-widest">Belum ada riwayat pergerakan stok</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>