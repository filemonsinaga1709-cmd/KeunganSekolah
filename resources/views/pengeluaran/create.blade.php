<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pengeluaran</h2>
            <a href="{{ route('admin.pengeluaran.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 transition">Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-lg font-semibold text-white">Form Tambah Pengeluaran</h3>
                </div>

                <form action="{{ route(auth()->user()->route_prefix . '.pengeluaran.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal') border-red-500 @enderror" required>
                        @error('tanggal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: ATK, Operasional, dll">
                    </div>

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan <span class="text-red-500">*</span></label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('keterangan') border-red-500 @enderror" required>{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" class="block w-full pl-12 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror" required step="0.01" min="0">
                        </div>
                        @error('jumlah')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="akun_id" class="block text-sm font-medium text-gray-700 mb-2">Akun Beban</label>
                        <select name="akun_id" id="akun_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Akun (Opsional) --</option>
                            @foreach($akuns as $akun)
                                <option value="{{ $akun->id }}" {{ old('akun_id') == $akun->id  ? 'selected' : '' }}>{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak perlu mencatat ke jurnal</p>
                    </div>

                    <div>
                        <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">Format: PDF, JPG, PNG (Max: 2MB)</p>
                        @error('bukti_pembayaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route(auth()->user()->route_prefix . '.pengeluaran.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-xs text-gray-700 uppercase font-semibold hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 border border-transparent rounded-md text-xs text-white uppercase font-semibold hover:bg-blue-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
