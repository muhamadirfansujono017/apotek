<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[3rem] overflow-hidden border border-gray-100 dark:border-gray-800">
            
            {{-- Header --}}
            <div class="p-10 border-b border-dashed border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-black text-indigo-600 italic uppercase tracking-tighter">EDIT PENJUALAN</h1>
                </div>
                <div class="text-right">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">No. Faktur</span>
                    <span class="text-lg font-black text-indigo-500 uppercase">{{ $penjualan->no_faktur }}</span>
                </div>
            </div>

            <div class="p-10">
                {{-- Alert Peringatan --}}
                <div class="mb-8 p-6 bg-amber-50 border-l-4 border-amber-400 rounded-2xl flex gap-4">
                    <svg class="w-6 h-6 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-xs font-medium text-amber-800 leading-relaxed">
                        <span class="font-bold uppercase italic">Peringatan:</span> Fitur edit ini hanya untuk mengubah data pembayaran dan tanggal. Untuk mengubah item obat, disarankan hapus penjualan dan buat baru agar stok <span class="font-bold">Apotek Irfan</span> tetap akurat.
                    </p>
                </div>

                <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Input Tanggal --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Tanggal Penjualan</label>
                            <input type="date" name="tanggal" value="{{ $penjualan->tanggal }}" 
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl p-4 font-bold text-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>

                        {{-- Total Harga (Read Only) --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Total Harga (Read Only)</label>
                            <div class="w-full bg-blue-50 dark:bg-gray-800/50 border-2 border-blue-100 dark:border-indigo-900 rounded-2xl p-4 font-black text-gray-800 dark:text-white text-xl">
                                Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Input Bayar Baru --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Jumlah Bayar Baru (Cash)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-indigo-500 text-2xl italic">Rp</span>
                            <input type="number" name="bayar" id="bayar" value="{{ (int)$penjualan->bayar }}" required
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-3xl py-8 pl-16 pr-8 font-black text-indigo-600 text-4xl italic tracking-tighter focus:ring-4 focus:ring-indigo-500/20 transition-all outline-none"
                                placeholder="0">
                        </div>
                        <p class="text-[9px] font-bold text-gray-400 italic ml-4">*Masukkan nominal tanpa titik atau koma.</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="pt-8 flex flex-col md:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-200 dark:shadow-none transition-all hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('penjualan.index') }}" class="px-10 py-5 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 font-black rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all text-center uppercase tracking-widest text-sm">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>