<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Jenis Pembayaran</h2>
            <a href="{{ route('admin.jenis-pembayaran.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
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
                    <h3 class="text-lg font-semibold text-white">Form Edit Jenis Pembayaran: {{ $jenisPembayaran->nama }}</h3>
                </div>

                <form action="{{ route('admin.jenis-pembayaran.update', $jenisPembayaran) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Jenis Pembayaran <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $jenisPembayaran->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 @error('nama') border-red-500 @enderror" required>
                        @error('nama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="nominal" class="block text-sm font-medium text-gray-700 mb-2">Nominal (Opsional)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="nominal" id="nominal" value="{{ old('nominal', $jenisPembayaran->nominal) }}" class="block w-full pl-12 rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 @error('nominal') border-red-500 @enderror" step="0.01" min="0">
                        </div>
                        @error('nominal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika nominal tidak tetap atau bervariasi</p>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route('admin.jenis-pembayaran.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-xs text-gray-700 uppercase font-semibold hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-yellow-500 border border-transparent rounded-md text-xs text-white uppercase font-semibold hover:bg-yellow-600 transition">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
