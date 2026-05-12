<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKAS - Sistem Keuangan Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 min-h-screen">
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-1/2 -right-1/2 w-full h-full bg-gradient-to-tl from-green-500/20 to-blue-500/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Content -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-8 items-center">
            
            <!-- Left Side - Info -->
            <div class="text-white space-y-6">
                <div class="space-y-4">
                    <h1 class="text-6xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        SIKAS
                    </h1>
                    <p class="text-3xl font-semibold text-gray-200">
                        Sistem Informasi Keuangan <br>& Administrasi Sekolah
                    </p>
                    <p class="text-xl text-gray-400">
                        Platform modern untuk mengelola keuangan sekolah dengan mudah dan efisien
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-4 pt-8">
                    <div class="flex items-center space-x-4 bg-white/5 backdrop-blur-lg rounded-xl p-4 border border-white/10">
                        <div class="bg-blue-500 rounded-lg p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Pembayaran SPP</h3>
                            <p class="text-sm text-gray-400">Kelola pembayaran siswa secara real-time</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 bg-white/5 backdrop-blur-lg rounded-xl p-4 border border-white/10">
                        <div class="bg-purple-500 rounded-lg p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Laporan Lengkap</h3>
                            <p class="text-sm text-gray-400">Dashboard dan laporan keuangan detail</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 bg-white/5 backdrop-blur-lg rounded-xl p-4 border border-white/10">
                        <div class="bg-green-500 rounded-lg p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Multi User Role</h3>
                            <p class="text-sm text-gray-400">Admin, Bendahara, TU, Kepala Sekolah</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Card -->
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-8 md:p-12 border border-white/20 shadow-2xl">
                <div class="text-center mb-8">
                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
                    <p class="text-gray-300">Silakan login untuk melanjutkan</p>
                </div>

                <div class="space-y-4">
                    @auth
                        <a href="{{ url('/'.auth()->user()->role.'/dashboard') }}" 
                           class="group relative w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <span class="text-lg">Buka Dashboard</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="group relative w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-lg">Login Sekarang</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="block w-full bg-white/10 hover:bg-white/20 text-white font-semibold py-4 px-6 rounded-xl text-center border-2 border-white/30 hover:border-white/50 transition-all duration-300 backdrop-blur-sm">
                                <span class="text-lg">Daftar Akun Baru</span>
                            </a>
                        @endif
                    @endauth
                </div>

              

        </div>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-6">
        <p class="text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} SIKAS - Sistem Keuangan Sekolah. All rights reserved.
        </p>
    </div>
</body>
</html>