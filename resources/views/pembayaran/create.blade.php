<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pembayaran</h2>
            <a href="{{ route(auth()->user()->route_prefix . '.pembayaran.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition w-fit">
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
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-lg font-semibold text-white">Form Tambah Pembayaran</h3>
                </div>

                <form action="{{ route(auth()->user()->route_prefix . '.pembayaran.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-2">Siswa <span class="text-red-500">*</span></label>
                        <select name="siswa_id" id="siswa_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('siswa_id') border-red-500 @enderror select2-siswa" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nis }} - {{ $siswa->nama }} ({{ $siswa->kelas }})
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="jenis_pembayaran_id" class="block text-sm font-medium text-gray-700 mb-2">Jenis Pembayaran <span class="text-red-500">*</span></label>
                        <select name="jenis_pembayaran_id" id="jenis_pembayaran_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_pembayaran_id') border-red-500 @enderror select2-jenis" required onchange="updateNominal(this)">
                            <option value="">-- Pilih Jenis Pembayaran --</option>
                            @foreach($jenisPembayarans as $jenis)
                                <option value="{{ $jenis->id }}" data-nominal="{{ $jenis->nominal }}" {{ old('jenis_pembayaran_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }} @if($jenis->nominal) - Rp {{ number_format($jenis->nominal, 0, ',', '.') }} @endif
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_pembayaran_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal') border-red-500 @enderror" required>
                        @error('tanggal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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
                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran <span class="text-red-500">*</span></label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('metode_pembayaran') border-red-500 @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="va" {{ old('metode_pembayaran') == 'va' ? 'selected' : '' }}>Virtual Account</option>
                        </select>
                        @error('metode_pembayaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route(auth()->user()->route_prefix . '.pembayaran.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-xs text-gray-700 uppercase font-semibold hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 border border-transparent rounded-md text-xs text-white uppercase font-semibold hover:bg-blue-700 transition">Simpan Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Custom Select2 styling */
        .select2-container--default .select2-selection--single {
            height: 42px;
            padding: 6px 12px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            color: #374151;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #3b82f6;
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }
        
        .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 8px 12px;
        }
        
        .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
        }
    </style>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2 untuk Siswa dengan search
            $('.select2-siswa').select2({
                placeholder: '-- Cari Siswa (NIS, Nama, atau Kelas) --',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Siswa tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            // Initialize Select2 untuk Jenis Pembayaran
            $('.select2-jenis').select2({
                placeholder: '-- Pilih Jenis Pembayaran --',
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 5 // Show search if more than 5 items
            });
        });

        function updateNominal(select) {
            const selectedOption = $(select).find(':selected');
            const nominal = selectedOption.data('nominal');
            
            if (nominal && nominal > 0) {
                document.getElementById('jumlah').value = nominal;
            }
        }
    </script>
    @endpush
</x-app-layout>