<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-xl p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Laporan Keuangan</h1>
                        <p class="text-lg opacity-90">Pilih jenis laporan yang ingin Anda lihat</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-24 h-24 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Laporan Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Laporan Kas -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <h3 class="text-2xl font-bold">Laporan Kas</h3>
                                <p class="mt-1 opacity-90">Laporan pemasukan dan pengeluaran kas</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route(auth()->user()->route_prefix . '.laporan.kas') }}" method="GET">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ date('Y-m-01') }}" required
                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" value="{{ date('Y-m-d') }}" required
                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                                </div>
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(auth()->user()->isAdmin() || auth()->user()->isBendahara() || auth()->user()->isKepalaSekolah())
                <!-- Laporan Buku Besar -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <h3 class="text-2xl font-bold">Buku Besar</h3>
                                <p class="mt-1 opacity-90">Laporan per akun</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route(auth()->user()->route_prefix . '.laporan.buku-besar') }}" method="GET">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Akun</label>
                                    <select name="akun_id" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Pilih Akun --</option>
                                        @foreach(\App\Models\Akun::all() as $akun)
                                        <option value="{{ $akun->id }}">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ date('Y-m-01') }}" required
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" value="{{ date('Y-m-d') }}" required
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Laporan Laba Rugi -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <h3 class="text-2xl font-bold">Laba Rugi</h3>
                                <p class="mt-1 opacity-90">Laporan pendapatan dan beban</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route(auth()->user()->route_prefix . '.laporan.laba-rugi') }}" method="GET">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ date('Y-m-01') }}" required
                                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" value="{{ date('Y-m-d') }}" required
                                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                                </div>
                                <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Laporan Neraca Saldo -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <h3 class="text-2xl font-bold">Neraca Saldo</h3>
                                <p class="mt-1 opacity-90">Laporan saldo per akun</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route(auth()->user()->route_prefix . '.laporan.neraca-saldo') }}" method="GET">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" value="{{ date('Y-m-d') }}" required
                                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>