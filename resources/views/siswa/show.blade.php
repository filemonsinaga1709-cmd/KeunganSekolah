<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Siswa</h2>
            <a href="{{ route(auth()->user()->route_prefix . '.siswa.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Info Siswa Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">Informasi Siswa</h3>
                    @if(auth()->user()->isAdmin() || auth()->user()->isTu())
                    <a href="{{ route(auth()->user()->route_prefix . '.siswa.edit', $siswa) }}" 
                       class="bg-white text-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100 transition">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    @endif
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NIS -->
                        <div class="border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">NIS</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $siswa->nis }}</p>
                        </div>

                        <!-- Status -->
                        <div class="border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            @if($siswa->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tidak Aktif
                                </span>
                            @endif
                        </div>

                        <!-- Nama -->
                        <div class="border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $siswa->nama }}</p>
                        </div>

                        <!-- Kelas -->
                        <div class="border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kelas</label>
                            <p class="text-lg text-gray-900">{{ $siswa->kelas ?? '-' }}</p>
                        </div>

                        <!-- No Telp -->
                        <div class="border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                            <p class="text-lg text-gray-900">{{ $siswa->no_telp ?? '-' }}</p>
                        </div>

                        <!-- Tanggal Daftar -->
                        <div class="border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Daftar</label>
                            <p class="text-lg text-gray-900">{{ $siswa->created_at->format('d F Y') }}</p>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2 border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                            <p class="text-lg text-gray-900">{{ $siswa->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pembayaran Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                    <h3 class="text-lg font-semibold text-white">Ringkasan Pembayaran</h3>
                </div>
                <div class="p-6">
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-green-600 font-medium mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-bold text-green-700">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-4">
                                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pembayaran -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">Riwayat Pembayaran</h3>
                    <span class="bg-white text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $siswa->pembayarans->count() }} Transaksi
                    </span>
                </div>

                @if($siswa->pembayarans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($siswa->pembayarans->sortByDesc('tanggal') as $pembayaran)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pembayaran->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pembayaran->no_transaksi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pembayaran->jenisPembayaran->nama }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($pembayaran->metode_pembayaran == 'tunai') bg-green-100 text-green-800
                                        @elseif($pembayaran->metode_pembayaran == 'transfer') bg-blue-100 text-blue-800
                                        @else bg-purple-100 text-purple-800
                                        @endif">
                                        {{ ucfirst($pembayaran->metode_pembayaran) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-bold">
                                <td colspan="4" class="px-6 py-4 text-right text-gray-900">Total:</td>
                                <td class="px-6 py-4 text-right text-green-700">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada riwayat pembayaran</p>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            @if(auth()->user()->isAdmin() || auth()->user()->isTu())
            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route(auth()->user()->route_prefix . '.siswa.edit', $siswa) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Siswa
                </a>
                <form action="{{ route(auth()->user()->route_prefix . '.siswa.destroy', $siswa) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus siswa {{ $siswa->nama }}? Semua data pembayaran juga akan terhapus!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Siswa
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
```
