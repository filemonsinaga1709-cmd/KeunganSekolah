<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Pembayaran Siswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Transaksi atau Nama Siswa..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="min-w-[150px]">
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tanggal Mulai">
                    </div>
                    <div class="min-w-[150px]">
                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tanggal Akhir">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Cari</button>
                    @if(request('search') || request('tanggal_mulai'))
                        <a href="{{ route(auth()->user()->route_prefix . '.pembayaran.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Summary Card -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-6 mb-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Total Pembayaran</p>
                        <p class="text-3xl font-bold">Rp {{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Header Tabel + Tombol Tambah -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Pembayaran</h3>
                @if(auth()->user()->isAdmin() || auth()->user()->isBendahara() || auth()->user()->isTu())
                <a href="{{ route(auth()->user()->route_prefix . '.pembayaran.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition w-fit">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pembayaran
                </a>
                @endif
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pembayarans as $pembayaran)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-semibold text-gray-900">{{ $pembayaran->no_transaksi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pembayaran->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $pembayaran->siswa->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $pembayaran->jenisPembayaran->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $metodeColors = [
                                            'tunai' => 'bg-green-100 text-green-800',
                                            'transfer' => 'bg-blue-100 text-blue-800',
                                            'va' => 'bg-purple-100 text-purple-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $metodeColors[$pembayaran->metode_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ strtoupper($pembayaran->metode_pembayaran) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route(auth()->user()->route_prefix . '.pembayaran.print', $pembayaran) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-md transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Print
                                        </a>
                                        
                                        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara() || auth()->user()->isTu())
                                        <form action="{{ route(auth()->user()->route_prefix . '.pembayaran.destroy', $pembayaran) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">Tidak ada data pembayaran</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($pembayarans->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $pembayarans->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>