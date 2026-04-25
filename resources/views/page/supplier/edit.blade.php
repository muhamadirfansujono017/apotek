<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-user-edit text-amber-500 me-3"></i> Edit Data Supplier
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[2rem] overflow-hidden border border-gray-100 dark:border-gray-800">
            
            {{-- Header Visual --}}
            <div class="bg-amber-500 p-8 text-white">
                <h3 class="text-lg font-black uppercase tracking-widest">Informasi Supplier</h3>
                <p class="text-amber-100 text-sm">Pastikan data supplier Apotek Irfan diperbarui dengan benar.</p>
            </div>

            <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" class="p-8">
                @csrf 
                @method('PUT')

                <div class="grid grid-cols-1 gap-8">
                    {{-- Nama Supplier --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">Nama Supplier</label>
                        <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" 
                            class="w-full border-gray-100 rounded-2xl focus:ring-amber-500 focus:border-amber-500 py-4 px-6 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                            placeholder="Masukkan nama supplier..." required>
                        @error('nama_supplier')
                            <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4"
                            class="w-full border-gray-100 rounded-2xl focus:ring-amber-500 focus:border-amber-500 py-4 px-6 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                            placeholder="Masukkan alamat lengkap..." required>{{ old('alamat', $supplier->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No Telepon --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">No. Telepon / WhatsApp</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $supplier->no_telp) }}" 
                            class="w-full border-gray-100 rounded-2xl focus:ring-amber-500 focus:border-amber-500 py-4 px-6 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                            placeholder="Contoh: 08123456789" required>
                        @error('no_telp')
                            <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-12 flex flex-col md:flex-row gap-4">
                    <button type="submit" 
                        class="flex-1 bg-amber-500 text-white py-4 rounded-2xl font-black uppercase text-sm shadow-xl shadow-amber-200 dark:shadow-none hover:bg-amber-600 transition-all hover:-translate-y-1 active:scale-95">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('supplier.index') }}" 
                        class="flex-1 bg-gray-100 text-gray-500 py-4 rounded-2xl font-black uppercase text-sm text-center hover:bg-gray-200 transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>