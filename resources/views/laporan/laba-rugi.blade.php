<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Laba Rugi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route(auth()->user()->route_prefix . '.laporan.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Menu Laporan
                </a>
            </div>

            <!-- Header Laporan -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">LAPORAN LABA RUGI</h1>
                    <p class="text-gray-600">Periode: {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d F Y') : '' }} s/d {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d F Y') : '' }}</p>
                </div>

                <!-- Quick Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <p class="text-sm text-green-600 font-medium mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                        <p class="text-sm text-red-600 font-medium mb-1">Total Beban</p>
                        <p class="text-2xl font-bold text-red-700">Rp {{ number_format($totalBeban, 0, ',', '.') }}</p>
                    </div>

                    <div class="bg-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-50 border-l-4 border-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-500 p-6 rounded-lg">
                        <p class="text-sm text-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-600 font-medium mb-1">{{ $labaRugi >= 0 ? 'Laba' : 'Rugi' }}</p>
                        <p class="text-2xl font-bold text-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-700">Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- PENDAPATAN -->
                    <div>
                        <div class="bg-green-100 px-6 py-3 rounded-t-lg">
                            <h3 class="text-lg font-bold text-green-800">PENDAPATAN</h3>
                        </div>
                        <div class="border border-t-0 rounded-b-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Akun</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Akun</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($pendapatan as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['akun']->kode_akun }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item['akun']->nama_akun }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-green-600">
                                            Rp {{ number_format($item['total'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data pendapatan</td>
                                    </tr>
                                    @endforelse
                                    <tr class="bg-green-50 font-bold">
                                        <td colspan="2" class="px-6 py-4 text-right text-gray-900">Total Pendapatan:</td>
                                        <td class="px-6 py-4 text-right text-green-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- BEBAN -->
                    <div>
                        <div class="bg-red-100 px-6 py-3 rounded-t-lg">
                            <h3 class="text-lg font-bold text-red-800">BEBAN</h3>
                        </div>
                        <div class="border border-t-0 rounded-b-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Akun</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Akun</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($beban as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['akun']->kode_akun }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item['akun']->nama_akun }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-red-600">
                                            Rp {{ number_format($item['total'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data beban</td>
                                    </tr>
                                    @endforelse
                                    <tr class="bg-red-50 font-bold">
                                        <td colspan="2" class="px-6 py-4 text-right text-gray-900">Total Beban:</td>
                                        <td class="px-6 py-4 text-right text-red-700">Rp {{ number_format($totalBeban, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- LABA/RUGI BERSIH -->
                <div class="mt-8 bg-gradient-to-r from-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-50 to-{{ $labaRugi >= 0 ? 'indigo' : 'orange' }}-50 rounded-lg p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $labaRugi >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}</h3>
                            <p class="text-gray-600">Pendapatan - Beban</p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-600">
                                Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}
                            </p>
                            @if($labaRugi >= 0)
                            <p class="text-sm text-green-600 mt-2 flex items-center justify-end">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Kondisi Keuangan Sehat
                            </p>
                            @else
                            <p class="text-sm text-red-600 mt-2 flex items-center justify-end">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Perlu Evaluasi Keuangan
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

              <!-- Action Buttons -->
<div class="flex justify-end space-x-4 mt-6">
    <a href="{{ route(auth()->user()->route_prefix . '.laporan.laba-rugi.print', request()->all()) }}" 
       target="_blank"
       class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        Cetak Laporan
    </a>
</div>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .bg-white.rounded-lg.shadow-lg, .bg-white.rounded-lg.shadow-lg * {
                visibility: visible;
            }
            .bg-white.rounded-lg.shadow-lg {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            button, .mb-6 {
                display: none !important;
            }
        }
    </style>
    @endpush
</x-app-layout>