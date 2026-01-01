<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Neraca Saldo
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
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">NERACA SALDO</h1>
                    <p class="text-gray-600">Per Tanggal: {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d F Y') : '' }}</p>
                </div>

                <!-- Summary Cards -->
                @php
                    $totalDebit = $akuns->sum('debit');
                    $totalKredit = $akuns->sum('kredit');
                    $isBalanced = $totalDebit == $totalKredit;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-green-600 font-medium mb-1">Total Debit</p>
                                <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-red-600 font-medium mb-1">Total Kredit</p>
                                <p class="text-2xl font-bold text-red-700">Rp {{ number_format($totalKredit, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-red-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-{{ $isBalanced ? 'blue' : 'yellow' }}-50 border-l-4 border-{{ $isBalanced ? 'blue' : 'yellow' }}-500 p-6 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-{{ $isBalanced ? 'blue' : 'yellow' }}-600 font-medium mb-1">Status</p>
                                <p class="text-xl font-bold text-{{ $isBalanced ? 'blue' : 'yellow' }}-700">{{ $isBalanced ? 'Seimbang' : 'Tidak Seimbang' }}</p>
                            </div>
                            <div class="bg-{{ $isBalanced ? 'blue' : 'yellow' }}-100 rounded-full p-3">
                                @if($isBalanced)
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @else
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if(!$isBalanced)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-semibold">Peringatan:</span> Total Debit dan Kredit tidak seimbang. Selisih: Rp {{ number_format(abs($totalDebit - $totalKredit), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tabel Neraca Saldo -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase border">Kode Akun</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase border">Nama Akun</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase border">Tipe</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase border">Debit</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase border">Kredit</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $groupedAkuns = $akuns->groupBy(function($item) {
                                    return $item['akun']->tipe_akun;
                                });
                            @endphp

                            @foreach(['aset', 'kewajiban', 'modal', 'pendapatan', 'beban'] as $tipe)
                                @if($groupedAkuns->has($tipe))
                                    <!-- Header Tipe Akun -->
                                    <tr class="bg-gray-100">
                                        <td colspan="5" class="px-6 py-3 text-left font-bold text-gray-900 uppercase border">
                                            {{ ucfirst($tipe) }}
                                        </td>
                                    </tr>

                                    @foreach($groupedAkuns[$tipe] as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border">{{ $item['akun']->kode_akun }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 border">{{ $item['akun']->nama_akun }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center border">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                @if($tipe == 'aset') bg-blue-100 text-blue-800
                                                @elseif($tipe == 'kewajiban') bg-red-100 text-red-800
                                                @elseif($tipe == 'modal') bg-purple-100 text-purple-800
                                                @elseif($tipe == 'pendapatan') bg-green-100 text-green-800
                                                @else bg-orange-100 text-orange-800
                                                @endif">
                                                {{ ucfirst($tipe) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right border">
                                            @if($item['saldo'] > 0)
                                                <span class="font-medium text-green-600">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right border">
                                            @if($item['saldo'] < 0)
                                                <span class="font-medium text-red-600">Rp {{ number_format(abs($item['saldo']), 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    <!-- Subtotal per Tipe -->
                                    @php
                                        $subtotalDebit = $groupedAkuns[$tipe]->filter(fn($i) => $i['saldo'] > 0)->sum('saldo');
                                        $subtotalKredit = abs($groupedAkuns[$tipe]->filter(fn($i) => $i['saldo'] < 0)->sum('saldo'));
                                    @endphp
                                    <tr class="bg-gray-50 font-semibold">
                                        <td colspan="3" class="px-6 py-3 text-right text-gray-700 border">Subtotal {{ ucfirst($tipe) }}:</td>
                                        <td class="px-6 py-3 text-right text-green-700 border">Rp {{ number_format($subtotalDebit, 0, ',', '.') }}</td>
                                        <td class="px-6 py-3 text-right text-red-700 border">Rp {{ number_format($subtotalKredit, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            <!-- TOTAL -->
                            <tr class="bg-gradient-to-r from-blue-100 to-indigo-100 font-bold text-lg">
                                <td colspan="3" class="px-6 py-4 text-right text-gray-900 border">TOTAL:</td>
                                <td class="px-6 py-4 text-right text-green-700 border">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right text-red-700 border">Rp {{ number_format($totalKredit, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Verification Box -->
                <div class="mt-8 bg-gradient-to-r from-{{ $isBalanced ? 'blue' : 'yellow' }}-50 to-{{ $isBalanced ? 'indigo' : 'orange' }}-50 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Verifikasi Neraca</h3>
                            <p class="text-gray-600">
                                @if($isBalanced)
                                    ✓ Neraca dalam kondisi seimbang. Total Debit = Total Kredit
                                @else
                                    ⚠ Neraca tidak seimbang. Perlu dilakukan pengecekan jurnal.
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            @if($isBalanced)
                                <div class="bg-blue-100 rounded-full p-4 inline-block">
                                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="bg-yellow-100 rounded-full p-4 inline-block">
                                    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

               <!-- Action Buttons -->
<div class="flex justify-end space-x-4 mt-6">
    <a href="{{ route(auth()->user()->route_prefix . '.laporan.neraca-saldo.print', request()->all()) }}" 
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