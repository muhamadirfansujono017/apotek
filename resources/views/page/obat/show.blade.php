<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
                <i class="fas fa-info-circle text-indigo-600 me-3"></i>
                Detail Obat: {{ $obat->nama_obat }}
            </h2>
            <a href="{{ route('obat.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-bold transition">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="bg-indigo-600 p-8 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-xs font-black uppercase tracking-[0.3em] opacity-80">Kode Obat</span>
                        <h3 class="text-3xl font-black mt-1 font-mono uppercase">{{ $obat->kode_obat }}</h3>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-2xl text-right">
                        <span class="text-[10px] font-black uppercase block opacity-80">Kategori</span>
                        <span class="font-bold">{{ $obat->kategori }}</span>
                    </div>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="flex items-center p-4 bg-slate-50 dark:bg-gray-700/50 rounded-2xl">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600 mr-4">
                            <i class="fas fa-box text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Stok Saat Ini</p>
                            <p class="text-lg font-black text-gray-800 dark:text-white">{{ $obat->stok }} <span class="text-sm font-bold text-gray-400">{{ $obat->satuan }}</span></p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-rose-50 dark:bg-rose-900/10 rounded-2xl">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-rose-600 mr-4">
                            <i class="fas fa-hourglass-end text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Kadaluarsa</p>
                            <p class="text-lg font-black text-rose-600">{{ \Carbon\Carbon::parse($obat->expired)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/10 rounded-2xl">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-blue-600 mr-4">
                            <i class="fas fa-tag text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga Beli</p>
                            <p class="text-lg font-black text-gray-800 dark:text-white">Rp {{ number_format($obat->harga_beli, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-emerald-600 mr-4">
                            <i class="fas fa-hand-holding-usd text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga Jual</p>
                            <p class="text-lg font-black text-emerald-600">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 border-t border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex justify-end space-x-3">
                <a href="{{ route('obat.edit', $obat->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-2xl font-black text-xs shadow-lg shadow-amber-100 transition">
                    <i class="fas fa-edit me-2"></i> EDIT DATA OBAT
                </a>
            </div>
        </div>
    </div>
</x-app-layout>