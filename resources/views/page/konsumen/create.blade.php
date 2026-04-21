<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">
      {{ isset($konsumen) ? 'Edit Konsumen' : 'Tambah Konsumen' }}
    </h2>
  </x-slot>

  <div class="p-6 max-w-md mx-auto bg-white shadow rounded-lg">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ isset($konsumen) ? route('konsumen.update', $konsumen->id) : route('konsumen.store') }}" method="POST" class="space-y-4">
      @csrf
      @isset($konsumen) @method('PATCH') @endisset

      <div>
        <label for="nama" class="block mb-1 text-sm font-medium text-gray-700">Nama Konsumen</label>
        <input type="text" name="nama" id="nama" required
          value="{{ old('nama', $konsumen->nama ?? '') }}"
          class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-300">
        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Status</label>
        <select name="status" id="status" required
          class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-300">
          <option value="" disabled {{ old('status', $konsumen->status ?? '') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
          <option value="Aktif" {{ old('status', $konsumen->status ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="Tidak Aktif" {{ old('status', $konsumen->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('konsumen.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-800">Batal</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 rounded text-white hover:bg-blue-700">
          {{ isset($konsumen) ? 'Update' : 'Simpan' }}
        </button>
      </div>
    </form>
  </div>
</x-app-layout>
