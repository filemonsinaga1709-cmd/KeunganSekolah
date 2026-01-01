<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Siswa</h2>
            <a href="{{ route(auth()->user()->route_prefix . '.siswa.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <h3 class="text-lg font-semibold text-white">Form Edit Siswa: {{ $siswa->nama }}</h3>
                </div>

                <form action="{{ route(auth()->user()->route_prefix . '.siswa.update', $siswa) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">NIS <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 @error('nis') border-red-500 @enderror" required>
                        @error('nis')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 @error('nama') border-red-500 @enderror" required>
                        @error('nama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $siswa->kelas) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                        @error('kelas')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $siswa->no_telp) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                        @error('no_telp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">{{ old('alamat', $siswa->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $siswa->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                            <span class="ml-2 text-sm text-gray-700">Siswa Aktif</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route(auth()->user()->route_prefix . '.siswa.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-xs text-gray-700 uppercase font-semibold hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-yellow-500 border border-transparent rounded-md text-xs text-white uppercase font-semibold hover:bg-yellow-600 transition">Perbarui Siswa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>