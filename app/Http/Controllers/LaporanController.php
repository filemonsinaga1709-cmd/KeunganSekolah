<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\JurnalDetail;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // View laporan sama untuk semua role
        return view('laporan.index');
    }

    // Laporan Buku Besar
    public function bukuBesar(Request $request)
    {
        $request->validate([
            'akun_id' => 'required|exists:akuns,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $akun = Akun::findOrFail($request->akun_id);
        
        $details = JurnalDetail::whereHas('jurnal', function($q) use ($request) {
                $q->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
            })
            ->where('akun_id', $akun->id)
            ->with(['jurnal'])
            ->get();

        // Hitung saldo awal
        $saldoAwal = JurnalDetail::whereHas('jurnal', function($q) use ($request) {
                $q->where('tanggal', '<', $request->tanggal_mulai);
            })
            ->where('akun_id', $akun->id)
            ->selectRaw('SUM(debit) - SUM(kredit) as saldo')
            ->first()
            ->saldo ?? 0;

        $akuns = Akun::all();

        return view('laporan.buku-besar', compact('akun', 'details', 'saldoAwal', 'akuns'));
    }

    // Laporan Neraca Saldo
    public function neracaSaldo(Request $request)
    {
        $request->validate([
            'tanggal_akhir' => 'required|date',
        ]);

        $akuns = Akun::with(['jurnalDetails' => function($q) use ($request) {
                $q->whereHas('jurnal', function($q2) use ($request) {
                    $q2->where('tanggal', '<=', $request->tanggal_akhir);
                });
            }])
            ->get()
            ->map(function($akun) {
                $totalDebit = $akun->jurnalDetails->sum('debit');
                $totalKredit = $akun->jurnalDetails->sum('kredit');
                $saldo = $totalDebit - $totalKredit;

                return [
                    'akun' => $akun,
                    'debit' => $totalDebit,
                    'kredit' => $totalKredit,
                    'saldo' => $saldo,
                ];
            });

        return view('laporan.neraca-saldo', compact('akuns'));
    }

    // Laporan Laba Rugi
    public function labaRugi(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Pendapatan
        $pendapatan = Akun::where('tipe_akun', 'pendapatan')
            ->with(['jurnalDetails' => function($q) use ($request) {
                $q->whereHas('jurnal', function($q2) use ($request) {
                    $q2->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
                });
            }])
            ->get()
            ->map(function($akun) {
                return [
                    'akun' => $akun,
                    'total' => $akun->jurnalDetails->sum('kredit') - $akun->jurnalDetails->sum('debit'),
                ];
            });

        // Beban
        $beban = Akun::where('tipe_akun', 'beban')
            ->with(['jurnalDetails' => function($q) use ($request) {
                $q->whereHas('jurnal', function($q2) use ($request) {
                    $q2->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
                });
            }])
            ->get()
            ->map(function($akun) {
                return [
                    'akun' => $akun,
                    'total' => $akun->jurnalDetails->sum('debit') - $akun->jurnalDetails->sum('kredit'),
                ];
            });

        $totalPendapatan = $pendapatan->sum('total');
        $totalBeban = $beban->sum('total');
        $labaRugi = $totalPendapatan - $totalBeban;

        return view('laporan.laba-rugi', compact('pendapatan', 'beban', 'totalPendapatan', 'totalBeban', 'labaRugi'));
    }

    // Laporan Kas
    public function laporanKas(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $pembayarans = Pembayaran::whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir])
            ->with(['siswa', 'jenisPembayaran'])
            ->get();

        $pemasukans = Pemasukan::whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir])
            ->get();

        $pengeluarans = Pengeluaran::whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir])
            ->get();

        $totalPemasukan = $pembayarans->sum('jumlah') + $pemasukans->sum('jumlah');
        $totalPengeluaran = $pengeluarans->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('laporan.kas', compact(
            'pembayarans',
            'pemasukans',
            'pengeluarans',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir'
        ));
    }
}