<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('obat.index') }}" class="text-gray-400 hover:text-indigo-600 transition"><i class="fas fa-arrow-left text-xl"></i></a>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">{{ __('Edit Data Obat') }}</h2>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-8 py-6 bg-indigo-50/50 border-b border-indigo-100">
                <h3 class="font-bold text-indigo-900 flex items-center text-sm uppercase tracking-wider">
                    <i class="fas fa-pen-square me-2 text-indigo-600"></i> Mengubah Data: {{ $obat->nama_obat }}
                </h3>
            </div>
            
            <form action="{{ route('obat.update', $obat->id) }}" method="POST" class="p-8 space-y-6">
                @csrf 
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Baris 1 --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Kode Obat (Read Only)</label>
                        <input type="text" value="{{ $obat->kode_obat }}" readonly class="block w-full rounded-2xl border-gray-100 bg-gray-50 text-gray-500 font-mono shadow-inner">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nama Obat</label>
                        <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required class="block w-full rounded-2xl border-gray-200 shadow-sm focus:ring-indigo-500">
                    </div>
                    
                    {{-- Baris 2 --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Kategori</label>
                        <select name="kategori" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500">
                            @foreach(['Tablet', 'Sirup', 'Kapsul', 'Injeksi', 'Salep'] as $k)
                                <option value="{{ $k }}" {{ (old('kategori', $obat->kategori) == $k) ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Satuan</label>
                        <select name="satuan" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500">
                            @foreach(['Botol', 'Strip', 'Pcs', 'Box', 'Tube'] as $s)
                                <option value="{{ $s }}" {{ (old('satuan', $obat->satuan) == $s) ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Baris 3 --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}" required class="block w-full rounded-2xl border-gray-200 shadow-sm focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Kadaluarsa</label>
                        <input type="date" name="expired" value="{{ old('expired', $obat->expired) }}" required class="block w-full rounded-2xl border-gray-200 shadow-sm focus:ring-indigo-500">
                    </div>

                    {{-- Baris 4 --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Harga Beli (Rp)</label>
                        <input type="number" name="harga_beli" value="{{ old('harga_beli', $obat->harga_beli) }}" required class="block w-full rounded-2xl border-gray-200 shadow-sm focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Harga Jual (Rp)</label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual', $obat->harga_jual) }}" required class="block w-full rounded-2xl border-gray-200 shadow-sm focus:ring-indigo-500">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-50">
                    <a href="{{ route('obat.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-indigo-600 transition">Batal</a>
                    <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-indigo-700 hover:-translate-y-1 transition-all active:scale-95">
                        <i class="fas fa-check-circle me-2"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>