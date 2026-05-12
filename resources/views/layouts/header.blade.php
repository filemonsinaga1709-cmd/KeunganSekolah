<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-4 py-3">
        
        <!-- Mobile Menu Button -->
        <button 
            @click="sidebarOpen = !sidebarOpen" 
            class="flex-shrink-0 p-2 -ml-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 lg:hidden transition-colors"
            aria-label="Toggle menu"
        >
            <!-- Hamburger icon - selalu tampil, ikon berubah via Alpine x-bind -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"
                ></path>
            </svg>
        </button>

        <!-- Page Title (will be set from each page) -->
        <div class="flex-1 min-w-0 ml-3 lg:ml-0">
            @if(isset($header))
                {{ $header }}
            @endif
        </div>

        <!-- Right Side Icons -->
        <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">
            
            <!-- Notifications (hidden on very small screens) -->
            <button class="hidden sm:block text-gray-500 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg relative transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-500"></span>
            </button>

            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button 
                    @click="open = !open"
                    class="flex items-center space-x-1 sm:space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none p-1 rounded-lg hover:bg-gray-100 transition-colors"
                >
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-[100px] truncate">
                        {{ auth()->user()->name }}
                    </span>
                    <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div 
                    x-show="open"
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100"
                    style="display: none;"
                >
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-blue-600 font-medium mt-0.5">{{ auth()->user()->role_label }}</p>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Edit Profile
                        </div>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>