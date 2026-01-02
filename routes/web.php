<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Master Data
    Route::resource('akun', AkunController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('jenis-pembayaran', JenisPembayaranController::class);
    
    // Transaksi
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('pembayaran/{pembayaran}/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
    Route::resource('pemasukan', PemasukanController::class);
    Route::resource('pengeluaran', PengeluaranController::class);
    Route::resource('jurnal', JurnalController::class);
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/buku-besar', [LaporanController::class, 'bukuBesar'])->name('buku-besar');
        Route::get('/neraca-saldo', [LaporanController::class, 'neracaSaldo'])->name('neraca-saldo');
        Route::get('/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laba-rugi');
        Route::get('/kas', [LaporanController::class, 'laporanKas'])->name('kas');
        
        // Print routes
        Route::get('/kas/print', [LaporanController::class, 'printLaporanKas'])->name('kas.print');
        Route::get('/laba-rugi/print', [LaporanController::class, 'printLabaRugi'])->name('laba-rugi.print');
        Route::get('/neraca-saldo/print', [LaporanController::class, 'printNeracaSaldo'])->name('neraca-saldo.print');
    });
});

// Bendahara Routes
Route::middleware(['auth', 'bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Master Data (view only)
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('jenis-pembayaran', [JenisPembayaranController::class, 'index'])->name('jenis-pembayaran.index');
    
    // View only akun (untuk referensi saat input transaksi)
    Route::get('akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('akun/{akun}', [AkunController::class, 'show'])->name('akun.show');
    
    // Full CRUD transaksi
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('pembayaran/{pembayaran}/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
    Route::resource('pemasukan', PemasukanController::class);
    Route::resource('pengeluaran', PengeluaranController::class);
    Route::resource('jurnal', JurnalController::class);
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/buku-besar', [LaporanController::class, 'bukuBesar'])->name('buku-besar');
        Route::get('/neraca-saldo', [LaporanController::class, 'neracaSaldo'])->name('neraca-saldo');
        Route::get('/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laba-rugi');
        Route::get('/kas', [LaporanController::class, 'laporanKas'])->name('kas');
        
        // Print routes
        Route::get('/kas/print', [LaporanController::class, 'printLaporanKas'])->name('kas.print');
        Route::get('/laba-rugi/print', [LaporanController::class, 'printLabaRugi'])->name('laba-rugi.print');
        Route::get('/neraca-saldo/print', [LaporanController::class, 'printNeracaSaldo'])->name('neraca-saldo.print');
    });
});

// TU Routes
Route::middleware(['auth', 'tu'])->prefix('tu')->name('tu.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Full access siswa
    Route::resource('siswa', SiswaController::class);
    
    // Jenis pembayaran (view only)
    Route::get('jenis-pembayaran', [JenisPembayaranController::class, 'index'])->name('jenis-pembayaran.index');
    
    // Pembayaran
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('pembayaran/{pembayaran}/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
    
    // Laporan kas
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/kas', [LaporanController::class, 'laporanKas'])->name('kas');
        
        // Print route
        Route::get('/kas/print', [LaporanController::class, 'printLaporanKas'])->name('kas.print');
    });
});

// Kepala Sekolah Routes
Route::middleware(['auth', 'kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // View only
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('pembayaran/{pembayaran}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::get('pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::get('pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::get('akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('akun/{akun}', [AkunController::class, 'show'])->name('akun.show');
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/buku-besar', [LaporanController::class, 'bukuBesar'])->name('buku-besar');
        Route::get('/neraca-saldo', [LaporanController::class, 'neracaSaldo'])->name('neraca-saldo');
        Route::get('/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laba-rugi');
        Route::get('/kas', [LaporanController::class, 'laporanKas'])->name('kas');
        
        // Print routes
        Route::get('/kas/print', [LaporanController::class, 'printLaporanKas'])->name('kas.print');
        Route::get('/laba-rugi/print', [LaporanController::class, 'printLabaRugi'])->name('laba-rugi.print');
        Route::get('/neraca-saldo/print', [LaporanController::class, 'printNeracaSaldo'])->name('neraca-saldo.print');
    });
});

require __DIR__.'/auth.php';