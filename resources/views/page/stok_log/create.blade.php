<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('stok_log.index') }}" class="h-10 w-10 bg-white dark:bg-gray-800 rounded-xl shadow-sm flex items-center justify-center text-gray-400 hover:text-indigo-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Update Stok Manual
                </h2>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Gunakan ini hanya untuk penyesuaian stok fisik</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-900 shadow-2xl shadow-indigo-100 dark:shadow-none rounded-[3rem] overflow-hidden border border-white dark:border-gray-800">
            <div class="bg-indigo-600 p-6 text-center">
                <div class="inline-flex p-3 rounded-2xl bg-white/20 text-white mb-2">
                    <i class="fas fa-box-open text-xl"></i>
                </div>
                <h3 class="text-white font-black uppercase tracking-widest text-sm">Formulir Penyesuaian</h3>
            </div>

            <form action="{{ route('stok_log.store') }}" method="POST" class="p-10">
                @csrf
                <div class="space-y-8">
                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] mb-3 ml-1 block">1. Pilih Nama Obat</label>
                        <div class="relative">
                            <select name="obat_id" required
                                class="w-full pl-5 pr-12 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white font-bold appearance-none cursor-pointer">
                                <option value="" disabled selected>Cari obat di sini...</option>
                                @foreach($obat as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_obat }} (Tersedia: {{ $item->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] mb-3 ml-1 block">2. Aksi Stok</label>
                            <select name="tipe" required
                                class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white font-black uppercase italic tracking-tighter">
                                <option value="masuk" class="text-emerald-500">✚ Stok Masuk</option>
                                <option value="keluar" class="text-rose-500">━ Stok Keluar</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] mb-3 ml-1 block">3. Jumlah Barang</label>
                            <div class="relative">
                                <input type="number" name="jumlah" required min="1" 
                                    class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white font-black text-xl"
                                    placeholder="0">
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-400 uppercase">Satuan</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] mb-3 ml-1 block">4. Alasan / Keterangan</label>
                        <textarea name="keterangan" rows="3" required
                            class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white text-sm font-medium" 
                            placeholder="Contoh: Barang rusak, retur supplier, atau koreksi data..."></textarea>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('stok_log.index') }}" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">
                            Batal & Kembali
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-black text-xs shadow-xl shadow-indigo-100 dark:shadow-none transition-all active:scale-95 uppercase tracking-widest">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>