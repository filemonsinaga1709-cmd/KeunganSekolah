<!-- Sidebar Backdrop (Mobile) -->
<div 
    x-show="sidebarOpen" 
    @click="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
    x-cloak
></div>

<!-- Sidebar -->
<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-gradient-to-b from-gray-900 to-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
>
    <div class="flex flex-col h-full">
        
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-4 bg-gray-900 border-b border-gray-700">
           <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.dashboard') }}" class="flex items-center space-x-2" @click="sidebarOpen = false">
                <div class="bg-blue-500 rounded-lg p-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">SIKAS</span>
            </a>
            <!-- Close button - mobile only -->
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white p-2 rounded-lg transition-colors hover:bg-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
            
            <!-- Dashboard -->
            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.dashboard') }}"
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara() || auth()->user()->isTu() || auth()->user()->isKepalaSekolah())
            <!-- Master Data Section -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Master Data</p>
            </div>

            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara() || auth()->user()->isKepalaSekolah())
            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.akun.index') }}" 
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.akun.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Chart of Account
                @if(auth()->user()->isKepalaSekolah())
                <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded">View</span>
                @endif
            </a>
            @endif

            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.siswa.index') }}" 
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.siswa.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Data Siswa
                @if(auth()->user()->isKepalaSekolah() || auth()->user()->isBendahara())
                <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded">View</span>
                @endif
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.jenis-pembayaran.index') }}" 
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.jenis-pembayaran.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Jenis Pembayaran
                @if(auth()->user()->isBendahara())
                <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded">View</span>
                @endif
            </a>
            @endif
            @endif

            <!-- Transaksi Section -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Transaksi</p>
            </div>

            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.pembayaran.index') }}"
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.pembayaran.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Pembayaran SPP
                @if(auth()->user()->isKepalaSekolah())
                <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded">View</span>
                @endif
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara() || auth()->user()->isKepalaSekolah())
            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.pemasukan.index') }}" 
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.pemasukan.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                </svg>
                Pemasukan Lain
                @if(auth()->user()->isKepalaSekolah())
                <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded">View</span>
                @endif
            </a>

            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.pengeluaran.index') }}" 
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.pengeluaran.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                </svg>
                Pengeluaran
                @if(auth()->user()->isKepalaSekolah())
                <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded">View</span>
                @endif
            </a>

            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.jurnal.index') }}" 
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.jurnal.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Jurnal Umum
                @if(auth()->user()->isKepalaSekolah())
                <span class="ml-auto text-xs bg-gray-700 px-2 py-1 rounded">View</span>
                @endif
            </a>
            @endif

            <!-- Laporan Section -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan</p>
            </div>

            <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.laporan.index') }}"
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('*.laporan.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Laporan Keuangan
            </a>

            @if(auth()->user()->isAdmin())
            <!-- User Management -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengaturan</p>
            </div>

            <a href="{{ route('admin.users.index') }}" 
               @click="sidebarOpen = false"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Manajemen User
            </a>
            @endif

        </nav>

        <!-- User Profile at Bottom -->
        <div class="p-4 border-t border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ auth()->user()->role_label }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>