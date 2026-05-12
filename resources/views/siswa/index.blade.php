<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header dengan Tombol Tambah (hanya Admin & TU) -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Daftar Siswa</h3>
                
                @if(auth()->user()->isAdmin() || auth()->user()->isTu())
                <!-- Tombol Tambah - Hanya Admin & TU -->
                <a href="{{ route(auth()->user()->route_prefix . '.siswa.create') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg inline-flex items-center w-fit">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Siswa
                </a>
                @endif
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Telp</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->kelas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->no_telp }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($siswa->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    
                                    <!-- Tombol Detail - SEMUA ROLE bisa lihat -->
                                    <a href="{{ route(auth()->user()->route_prefix . '.siswa.show', $siswa) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->isAdmin() || auth()->user()->isTu())
                                    <!-- Tombol Edit - Hanya Admin & TU -->
                                    <a href="{{ route(auth()->user()->route_prefix . '.siswa.edit', $siswa) }}" 
                                       class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Tombol Delete - Hanya Admin & TU -->
                                    <form action="{{ route(auth()->user()->route_prefix . '.siswa.destroy', $siswa) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus siswa {{ $siswa->nama }}?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data siswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($siswas->hasPages())
            <div class="mt-6">
                {{ $siswas->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>