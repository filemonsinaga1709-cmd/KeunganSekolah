<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jurnal Umum</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="min-w-[150px]">
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tanggal Mulai">
                    </div>
                    <div class="min-w-[150px]">
                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tanggal Akhir">
                    </div>
                    <div class="min-w-[150px]">
                        <select name="jenis" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Jenis</option>
                            <option value="umum" {{ request('jenis') == 'umum' ? 'selected' : '' }}>Jurnal Umum</option>
                            <option value="penyesuaian" {{ request('jenis') == 'penyesuaian' ? 'selected' : '' }}>Jurnal Penyesuaian</option>
                            <option value="penutup" {{ request('jenis') == 'penutup' ? 'selected' : '' }}>Jurnal Penutup</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600  transition">Cari</button>
                    @if(request()->hasAny(['tanggal_mulai', 'jenis']))
                        <a href="{{ route('admin.jurnal.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Header Tabel + Tombol Tambah -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Jurnal Umum</h3>
                @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                <a href="{{ route(auth()->user()->route_prefix . '.jurnal.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition w-fit">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Jurnal
                </a>
                @endif
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ref</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Debit</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Kredit</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($jurnals as $jurnal)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jurnal->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($jurnal->keterangan, 60) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $jenisColors = [
                                            'umum' => 'bg-green-100 text-green-800',
                                            'penyesuaian' => 'bg-yellow-100 text-yellow-800',
                                            'penutup' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $jenisColors[$jurnal->jenis] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($jurnal->jenis) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($jurnal->ref_tipe)
                                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Auto</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-gray-900">
                                    Rp {{ number_format($jurnal->details->sum('debit'), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-gray-900">
                                    Rp {{ number_format($jurnal->details->sum('kredit'), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route(auth()->user()->route_prefix . '.jurnal.show', $jurnal) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition">Detail</a>
                                        @if(!$jurnal->ref_tipe)
                                            <form action="{{ route(auth()->user()->route_prefix . '.jurnal.destroy', $jurnal) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus jurnal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data jurnal</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($jurnals->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200">{{ $jurnals->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
