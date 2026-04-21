<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
                <i class="fas fa-exchange-alt text-indigo-600 me-3"></i>
                Riwayat Mutasi Stok (Kartu Stok)
            </h2>
            <a href="{{ route('stok_log.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg transition-all text-sm">
                <i class="fas fa-plus me-2"></i> Koreksi Stok Manual
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-[10px] uppercase font-black text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-6 py-5">Waktu</th>
                            <th class="px-6 py-5">Informasi Obat</th>
                            <th class="px-4 py-5 text-center">Tipe</th>
                            <th class="px-4 py-5 text-center">Jumlah Mutasi</th>
                            <th class="px-6 py-5">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-600 dark:text-gray-300">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-gray-800 dark:text-white block">{{ $log->created_at->translatedFormat('d M Y') }}</span>
                                <span class="text-[10px] font-mono opacity-60">{{ $log->created_at->format('H:i:s') }} WIB</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-indigo-600 uppercase">{{ $log->obat->nama_obat }}</div>
                                <div class="text-[10px] opacity-60">ID: {{ $log->obat->kode_obat }}</div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($log->tipe == 'masuk')
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase border border-emerald-100">
                                        <i class="fas fa-arrow-down me-1"></i> MASUK
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-black uppercase border border-rose-100">
                                        <i class="fas fa-arrow-up me-1"></i> KELUAR
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center font-black text-lg">
                                <span class="{{ $log->tipe == 'masuk' ? 'text-emerald-500' : 'text-rose-500' }}">
                                    {{ $log->tipe == 'masuk' ? '+' : '-' }} {{ $log->jumlah }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs italic leading-relaxed text-gray-400">
                                    {{ $log->keterangan }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center italic text-gray-400">Belum ada mutasi stok terdeteksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>