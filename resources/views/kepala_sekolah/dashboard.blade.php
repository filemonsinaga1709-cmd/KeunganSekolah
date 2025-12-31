<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Kepala Sekolah
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p>Dashboard Kepala Sekolah berhasil dimuat.</p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h4 class="text-gray-600 text-sm">Total Siswa</h4>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_siswa'] ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h4 class="text-gray-600 text-sm">Pembayaran Hari Ini</h4>
                            <p class="text-xl font-bold text-green-600">Rp {{ number_format($stats['pembayaran_hari_ini'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-indigo-100 p-6 rounded-lg">
                            <h4 class="text-gray-600 text-sm">Pemasukan Bulan Ini</h4>
                            <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($stats['pembayaran_bulan_ini'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-red-100 p-6 rounded-lg">
                            <h4 class="text-gray-600 text-sm">Pengeluaran Bulan Ini</h4>
                            <p class="text-xl font-bold text-red-600">Rp {{ number_format($stats['pengeluaran_bulan_ini'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>