<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Buku Besar
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
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">BUKU BESAR</h1>
                    <h2 class="text-xl text-gray-700 mb-2">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</h2>
                    <p class="text-gray-600">Periode: {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d F Y') : '' }} s/d {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d F Y') : '' }}</p>
                </div>

                <!-- Info Akun -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-semibold">Tipe Akun:</span> {{ ucfirst($akun->tipe_akun) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tabel Buku Besar -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border">Keterangan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase border">No. Jurnal</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase border">Debit</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase border">Kredit</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase border">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Saldo Awal -->
                            <tr class="bg-yellow-50 font-semibold">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border" colspan="3">Saldo Awal</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right border">-</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right border">-</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold border {{ $saldoAwal >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format(abs($saldoAwal), 0, ',', '.') }} {{ $saldoAwal >= 0 ? '(D)' : '(K)' }}
                                </td>
                            </tr>

                            @php
                                $runningSaldo = $saldoAwal;
                            @endphp

                            @forelse($details as $detail)
                            @php
                                $runningSaldo += ($detail->debit - $detail->kredit);
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border">{{ $detail->jurnal->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border">{{ $detail->jurnal->keterangan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900 border">{{ $detail->jurnal->no_jurnal }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right border {{ $detail->debit > 0 ? 'text-green-600 font-medium' : 'text-gray-400' }}">
                                    {{ $detail->debit > 0 ? 'Rp ' . number_format($detail->debit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right border {{ $detail->kredit > 0 ? 'text-red-600 font-medium' : 'text-gray-400' }}">
                                    {{ $detail->kredit > 0 ? 'Rp ' . number_format($detail->kredit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium border {{ $runningSaldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format(abs($runningSaldo), 0, ',', '.') }} {{ $runningSaldo >= 0 ? '(D)' : '(K)' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 border">
                                    Tidak ada transaksi pada periode ini
                                </td>
                            </tr>
                            @endforelse

                            <!-- Saldo Akhir -->
                            <tr class="bg-blue-50 font-bold">
                                <td class="px-6 py-4 text-sm text-gray-900 border" colspan="3">Saldo Akhir</td>
                                <td class="px-6 py-4 text-sm text-right border text-green-600">
                                    Rp {{ number_format($details->sum('debit'), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right border text-red-600">
                                    Rp {{ number_format($details->sum('kredit'), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right border {{ $runningSaldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format(abs($runningSaldo), 0, ',', '.') }} {{ $runningSaldo >= 0 ? '(D)' : '(K)' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Debit</p>
                            <p class="text-xl font-bold text-green-600">Rp {{ number_format($details->sum('debit'), 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Kredit</p>
                            <p class="text-xl font-bold text-red-600">Rp {{ number_format($details->sum('kredit'), 0, ',', '.') }}</p>
                        </div>
                        <div class="border-l-2 border-gray-300">
                            <p class="text-sm text-gray-600 mb-1">Saldo Akhir</p>
                            <p class="text-2xl font-bold {{ $runningSaldo >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                Rp {{ number_format(abs($runningSaldo), 0, ',', '.') }} {{ $runningSaldo >= 0 ? '(D)' : '(K)' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-6">
                    <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Laporan
                    </button>
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