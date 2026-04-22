<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
                <i class="fas fa-pills text-indigo-600 me-3"></i>
                {{ __('Stok Obat Apotek JUJU') }}
            </h2>
            <a href="{{ route('obat.create') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center text-sm">
                <i class="fas fa-plus-circle me-2"></i> Tambah Obat Baru
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm flex items-center">
                <i class="fas fa-check-circle me-3 text-emerald-500"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-[10px] uppercase font-black text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-4 py-5 text-center w-16">NO</th>
                            <th class="px-6 py-5">Info Obat</th>
                            <th class="px-4 py-5">Kategori</th>
                            <th class="px-4 py-5 text-center">Stok</th>
                            <th class="px-4 py-5 text-center">Satuan</th>
                            <th class="px-6 py-5 text-right">Harga Beli</th>
                            <th class="px-6 py-5 text-right">Harga Jual</th>
                            <th class="px-6 py-5 text-center">Expired</th>
                            <th class="px-6 py-5 text-center w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($obat as $index => $item)
                            <tr class="hover:bg-indigo-50/30 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-4 py-4 text-center font-medium text-gray-400">{{ $obat->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 dark:text-white capitalize leading-tight">{{ $item->nama_obat }}</div>
                                    <div class="text-[10px] text-indigo-500 font-mono font-bold tracking-widest uppercase mt-0.5">{{ $item->kode_obat }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 bg-slate-100 dark:bg-gray-700 rounded-lg text-[10px] font-black text-slate-500 dark:text-gray-400 uppercase">
                                        {{ $item->kategori }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="font-black {{ $item->stok < 10 ? 'text-rose-500 bg-rose-50 px-2 py-1 rounded-md' : 'text-gray-700 dark:text-gray-300' }} text-sm">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ $item->satuan }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-500">
                                    <span class="text-[10px]">Rp</span> {{ number_format($item->harga_beli, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-black text-indigo-600 dark:text-indigo-400">
                                    <span class="text-[10px]">Rp</span> {{ number_format($item->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $expDate = \Carbon\Carbon::parse($item->expired);
                                        $statusClass = $expDate->isPast() ? 'text-rose-600 bg-rose-50' : ($expDate->diffInMonths(now()) < 3 ? 'text-amber-600 bg-amber-50' : 'text-emerald-600 bg-emerald-50');
                                        $statusLabel = $expDate->isPast() ? 'Expired' : ($expDate->diffInMonths(now()) < 3 ? 'Hampir' : 'Aman');
                                    @endphp
                                    <div class="inline-flex flex-col items-center">
                                        <div class="text-[11px] font-bold text-gray-700">{{ $expDate->translatedFormat('d M Y') }}</div>
                                        <span class="text-[8px] {{ $statusClass }} px-2 py-0.5 rounded-full font-black uppercase mt-1">{{ $statusLabel }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ route('obat.show', $item->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('obat.edit', $item->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm border border-amber-100">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('obat.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data obat {{ $item->nama_obat }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm border border-rose-100">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center italic text-gray-400 font-medium">
                                        <i class="fas fa-capsules text-4xl mb-3 opacity-20"></i>
                                        Belum ada data obat tersedia.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>