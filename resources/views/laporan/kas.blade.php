<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Kas
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
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">LAPORAN KAS</h1>
                    <p class="text-gray-600">Periode: {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d F Y') : '' }} s/d {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d F Y') : '' }}</p>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-green-600 font-medium mb-1">Total Pemasukan</p>
                                <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-red-600 font-medium mb-1">Total Pengeluaran</p>
                                <p class="text-2xl font-bold text-red-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-red-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-blue-600 font-medium mb-1">Saldo Akhir</p>
                                <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-blue-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pemasukan dari Pembayaran SPP -->
                @if($pembayarans->count() > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full mr-3">Pemasukan</span>
                        Pembayaran SPP
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pembayarans as $pembayaran)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pembayaran->tanggal->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pembayaran->no_transaksi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pembayaran->siswa->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pembayaran->jenisPembayaran->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-green-600">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-green-50 font-semibold">
                                    <td colspan="4" class="px-6 py-4 text-right text-gray-900">Subtotal Pembayaran SPP:</td>
                                    <td class="px-6 py-4 text-right text-green-700">Rp {{ number_format($pembayarans->sum('jumlah'), 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Pemasukan Lain -->
                @if($pemasukans->count() > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full mr-3">Pemasukan</span>
                        Pemasukan Lain
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pemasukans as $pemasukan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemasukan->tanggal->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemasukan->no_transaksi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pemasukan->kategori }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $pemasukan->keterangan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-green-600">Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-green-50 font-semibold">
                                    <td colspan="4" class="px-6 py-4 text-right text-gray-900">Subtotal Pemasukan Lain:</td>
                                    <td class="px-6 py-4 text-right text-green-700">Rp {{ number_format($pemasukans->sum('jumlah'), 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Pengeluaran -->
                @if($pengeluarans->count() > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full mr-3">Pengeluaran</span>
                        Pengeluaran
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengeluarans as $pengeluaran)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengeluaran->tanggal->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengeluaran->no_transaksi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengeluaran->kategori }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $pengeluaran->keterangan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-red-600">Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-red-50 font-semibold">
                                    <td colspan="4" class="px-6 py-4 text-right text-gray-900">Total Pengeluaran:</td>
                                    <td class="px-6 py-4 text-right text-red-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Summary Akhir -->
                <div class="border-t-2 border-gray-300 pt-6">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Pemasukan</p>
                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Pengeluaran</p>
                                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                            </div>
                            <div class="border-l-2 border-gray-300">
                                <p class="text-sm text-gray-600 mb-1">Saldo Akhir</p>
                                <p class="text-3xl font-bold {{ $saldoAkhir >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                                </p>
                            </div>
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