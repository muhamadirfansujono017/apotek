<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[2rem] overflow-hidden border border-gray-100 dark:border-gray-800">
            
            {{-- Header & Filter Section --}}
            <div class="p-10 border-b border-dashed border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-3xl font-black text-indigo-600 italic uppercase tracking-tighter">LAPORAN STOK OBAT</h1>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Apotek Irfan • Manajemen Inventaris</p>
                </div>
                
                {{-- Form Filter Tanggal --}}
                <form action="{{ route('laporan.obat.index') }}" method="GET" class="flex flex-wrap items-end gap-3 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}" 
                            class="block w-full bg-white dark:bg-gray-900 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 dark:text-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}" 
                            class="block w-full bg-white dark:bg-gray-900 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 dark:text-white">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gray-800 text-white p-2.5 rounded-xl hover:bg-black transition-all shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                        <a href="{{ route('laporan.obat.print', ['tgl_awal' => request('tgl_awal'), 'tgl_akhir' => request('tgl_akhir')]) }}" target="_blank" 
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            Cetak
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table Preview --}}
            <div class="p-10 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b-2 border-gray-100 dark:border-gray-800">
                            <th class="pb-4 pl-4 text-center">No</th>
                            <th class="pb-4">Kode Obat</th>
                            <th class="pb-4">Nama Obat</th>
                            <th class="pb-4">Kategori</th>
                            <th class="pb-4 text-center">Stok</th>
                            <th class="pb-4 text-right pr-4">Harga Jual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($obat as $key => $item)
                        <tr class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-900/20 transition-all">
                            <td class="py-5 pl-4 text-center text-xs font-bold text-gray-400">{{ $key + 1 }}</td>
                            <td class="py-5 font-black text-indigo-600 dark:text-indigo-400 text-sm uppercase">{{ $item->kode_obat }}</td>
                            <td class="py-5 font-bold text-gray-800 dark:text-white text-sm uppercase">{{ $item->nama_obat }}</td>
                            <td class="py-5 italic text-gray-500 text-xs uppercase">{{ $item->kategori }}</td>
                            <td class="py-5 text-center">
                                <span class="px-3 py-1 {{ $item->stok <= 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-lg font-black text-[10px]">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td class="py-5 text-right pr-4 font-black text-gray-800 dark:text-white">
                                Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest italic">Data obat tidak ditemukan pada periode ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>