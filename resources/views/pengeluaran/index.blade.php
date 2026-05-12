<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Pengeluaran</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="min-w-[150px]">
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="min-w-[150px]">
                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Cari</button>
                    @if(request()->hasAny(['search', 'tanggal_mulai']))
                        <a href="{{ route(auth()->user()->route_prefix . '.pengeluaran.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Summary -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-md p-6 mb-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Total Pengeluaran</p>
                        <p class="text-3xl font-bold">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>

            <!-- Header Tabel + Tombol Tambah -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Pengeluaran</h3>
                @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                <a href="{{ route(auth()->user()->route_prefix . '.pengeluaran.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition w-fit">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengeluaran
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pengeluarans as $pengeluaran)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-semibold">{{ $pengeluaran->no_transaksi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengeluaran->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pengeluaran->kategori)
                                        <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">{{ $pengeluaran->kategori }}</span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($pengeluaran->keterangan, 50) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $pengeluaran->akun->nama_akun ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                     @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route(auth()->user()->route_prefix . '.pengeluaran.edit', $pengeluaran) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium rounded-md transition">Edit</a>
                                        <form action="{{ route(auth()->user()->route_prefix . '.pengeluaran.destroy', $pengeluaran) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pengeluaran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition">Hapus</button>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data pengeluaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($pengeluarans->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200">{{ $pengeluarans->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
