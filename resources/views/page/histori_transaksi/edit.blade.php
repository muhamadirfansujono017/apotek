<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('histori_transaksi.index') }}" class="h-12 w-12 bg-white dark:bg-gray-800 rounded-2xl shadow-sm flex items-center justify-center text-gray-400 hover:text-indigo-600 transition-all border border-gray-100 dark:border-gray-700">
                <i class="fas fa-chevron-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Koreksi Transaksi <span class="text-indigo-600">#PJL-{{ $penjualan->id }}</span>
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Halaman Penyesuaian Data Penjualan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-2xl shadow-indigo-100 dark:shadow-none rounded-[3rem] overflow-hidden border border-white dark:border-gray-800">
            <div class="bg-amber-500 p-8 text-white flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Petugas Kasir</p>
                    <p class="font-bold text-lg uppercase italic">{{ $penjualan->user->name }}</p>
                </div>
                <div class="h-14 w-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <i class="fas fa-edit text-2xl"></i>
                </div>
            </div>

            <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST" class="p-10">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] mb-3 ml-1 block">1. Tanggal Transaksi</label>
                        <div class="relative">
                            <input type="date" name="tanggal" value="{{ $penjualan->tanggal }}" required
                                class="w-full pl-5 pr-5 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-amber-500 transition-all text-gray-900 dark:text-white font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] mb-3 ml-1 block">2. Total Nominal Pembayaran (Rp)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-black text-sm">Rp</span>
                            </div>
                            <input type="number" name="total" value="{{ $penjualan->total }}" required
                                class="w-full pl-14 pr-5 py-5 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-amber-500 transition-all text-gray-900 dark:text-white font-black text-2xl tracking-tighter">
                        </div>
                        <p class="mt-2 text-[9px] text-gray-400 italic">*Pastikan nominal sesuai dengan total item yang terjual.</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-[2rem] p-6 border border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Item dalam transaksi ini:</p>
                        <ul class="space-y-3">
                            @foreach($penjualan->detailPenjualan as $detail)
                            <li class="flex justify-between items-center text-sm">
                                <span class="font-bold text-gray-700 dark:text-gray-300 uppercase">{{ $detail->obat->nama_obat }}</span>
                                <span class="px-3 py-1 bg-white dark:bg-gray-700 rounded-lg font-black text-indigo-600 text-xs">x{{ $detail->jumlah }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('histori_transaksi.index') }}" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-all">
                            Batal
                        </a>
                        <button type="submit" class="bg-gray-900 hover:bg-black text-white px-10 py-4 rounded-2xl font-black text-xs shadow-xl transition-all active:scale-95 uppercase tracking-widest">
                            Update Transaksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>