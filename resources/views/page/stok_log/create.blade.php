<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            Input Mutasi Stok Manual
        </h2>
    </x-slot>

    <div class="py-10 max-w-3xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl overflow-hidden p-8">
            <form action="{{ route('stok_log.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Pilih Obat</label>
                        <select name="obat_id" class="w-full rounded-2xl border-gray-100 bg-gray-50 focus:ring-indigo-500">
                            @foreach($obat as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_obat }} (Stok: {{ $item->stok }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Tipe Mutasi</label>
                            <select name="tipe" class="w-full rounded-2xl border-gray-100 bg-gray-50">
                                <option value="masuk">Stok Masuk (+)</option>
                                <option value="keluar">Stok Keluar (-)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Jumlah</label>
                            <input type="number" name="jumlah" required min="1" class="w-full rounded-2xl border-gray-100 bg-gray-50">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Keterangan / Alasan</label>
                        <textarea name="keterangan" rows="3" class="w-full rounded-2xl border-gray-100 bg-gray-50" placeholder="Contoh: Koreksi stok rusak atau penyesuaian stok fisik."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('stok_log.index') }}" class="px-6 py-3 text-gray-500 font-bold text-sm">Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-3 rounded-2xl font-black text-xs shadow-lg transition transform active:scale-95">
                            SIMPAN MUTASI
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>