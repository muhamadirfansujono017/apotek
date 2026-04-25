<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-4">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black text-indigo-600 italic uppercase tracking-tighter">
                    Tabel Penjualan <span class="text-gray-400"></span>
                </h1>
                <p class="text-gray-500 font-medium mt-1">Kelola dan pantau seluruh rincian penjualan obat.</p>
            </div>
            <a href="{{ route('penjualan.create') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all">
                + Transaksi Baru
            </a>
        </div>

        {{-- Table Container --}}
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-800">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">No. Faktur</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kasir</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Total Transaksi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($penjualan as $p)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-8 py-6 font-bold text-indigo-600 italic">
                            {{ $p->no_faktur }}
                        </td>
                        <td class="px-8 py-6 text-gray-600 dark:text-gray-400 text-sm font-medium">
                            {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-black uppercase bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg text-gray-600 dark:text-gray-300">
                                {{ $p->user->name ?? 'Admin' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right font-black text-gray-800 dark:text-white text-lg">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($p->bayar >= $p->total_harga)
                                <span class="px-4 py-1.5 bg-green-100 text-green-600 text-[10px] font-black rounded-full border border-green-200">
                                    LUNAS
                                </span>
                            @else
                                <span class="px-4 py-1.5 bg-red-100 text-red-600 text-[10px] font-black rounded-full border border-red-200 animate-pulse">
                                    BELUM LUNAS
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('penjualan.show', $p->id) }}" class="p-3 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Lihat Struk">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                {{-- TOMBOL EDIT (BARU) --}}
                                <a href="{{ route('penjualan.edit', $p->id) }}" class="p-3 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm" title="Edit Transaksi">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('penjualan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Belum ada data transaksi tersimpan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Branding --}}
        <div class="mt-12 text-center">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">
                &copy; 2026 Apotek Irfan. Politeknik LP3I Tasikmalaya.
            </p>
        </div>
    </div>
</x-app-layout>