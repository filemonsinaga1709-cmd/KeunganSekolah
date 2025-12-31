<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Stats
        $stats = [
            'total_siswa' => Siswa::active()->count(),
            'pembayaran_hari_ini' => Pembayaran::whereDate('tanggal', $today)->sum('jumlah'),
            'pembayaran_bulan_ini' => Pembayaran::where('tanggal', '>=', $thisMonth)->sum('jumlah'),
            'pengeluaran_bulan_ini' => Pengeluaran::where('tanggal', '>=', $thisMonth)->sum('jumlah'),
        ];

        // Recent transactions
        $recentPembayarans = Pembayaran::with(['siswa', 'jenisPembayaran'])
            ->latest('tanggal')
            ->take(5)
            ->get();

        // Chart data - Pembayaran per bulan (6 bulan terakhir)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartData[] = [
                'month' => $month->format('M Y'),
                'pemasukan' => Pembayaran::whereYear('tanggal', $month->year)
                    ->whereMonth('tanggal', $month->month)
                    ->sum('jumlah') + 
                    Pemasukan::whereYear('tanggal', $month->year)
                    ->whereMonth('tanggal', $month->month)
                    ->sum('jumlah'),
                'pengeluaran' => Pengeluaran::whereYear('tanggal', $month->year)
                    ->whereMonth('tanggal', $month->month)
                    ->sum('jumlah'),
            ];
        }

        // Get role user untuk menentukan view
        $role = auth()->user()->role;
        
        // Return view berdasarkan role
        return view("{$role}.dashboard", compact('stats', 'recentPembayarans', 'chartData'));
    }
}