<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password Baru <span class="text-gray-500 text-sm">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password" id="password"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option> 
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('user.index') }}"
                       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded mr-2 transition">
                        Kembali
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
