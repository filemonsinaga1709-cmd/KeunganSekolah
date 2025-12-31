<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Akun Baru
            </h2>
            <a href="{{ route('admin.akun.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none transition">
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
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Form Tambah Akun
                    </h3>
                </div>

                <form action="{{ route('admin.akun.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Kode Akun -->
                    <div class="mb-6">
                        <label for="kode_akun" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Akun <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="kode_akun" 
                               id="kode_akun" 
                               value="{{ old('kode_akun') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono @error('kode_akun') border-red-500 @enderror"
                               placeholder="Contoh: 1101"
                               required>
                        @error('kode_akun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kode unik untuk identifikasi akun</p>
                    </div>

                    <!-- Nama Akun -->
                    <div class="mb-6">
                        <label for="nama_akun" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Akun <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nama_akun" 
                               id="nama_akun" 
                               value="{{ old('nama_akun') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_akun') border-red-500 @enderror"
                               placeholder="Contoh: Kas"
                               required>
                        @error('nama_akun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipe Akun -->
                    <div class="mb-6">
                        <label for="tipe_akun" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Akun <span class="text-red-500">*</span>
                        </label>
                        <select name="tipe_akun" 
                                id="tipe_akun" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tipe_akun') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Tipe Akun --</option>
                            <option value="aset" {{ old('tipe_akun') == 'aset' ? 'selected' : '' }}>Aset</option>
                            <option value="kewajiban" {{ old('tipe_akun') == 'kewajiban' ? 'selected' : '' }}>Kewajiban</option>
                            <option value="modal" {{ old('tipe_akun') == 'modal' ? 'selected' : '' }}>Modal</option>
                            <option value="pendapatan" {{ old('tipe_akun') == 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                            <option value="beban" {{ old('tipe_akun') == 'beban' ? 'selected' : '' }}>Beban</option>
                        </select>
                        @error('tipe_akun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <strong>Tipe akun:</strong> Aset, Kewajiban, Modal, Pendapatan, atau Beban
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Akun Aktif</span>
                        </label>
                        <p class="mt-1 text-xs text-gray-500">Centang jika akun ini aktif digunakan</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.akun.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
