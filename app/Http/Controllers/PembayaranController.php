<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\JenisPembayaran;
use App\Models\Akun;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['siswa', 'jenisPembayaran', 'user']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('no_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('siswa', function($q2) use ($request) {
                      $q2->where('nama', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $pembayarans = $query->latest('tanggal')->paginate(10);
        $totalPembayaran = $query->sum('jumlah');

        return view('admin.pembayaran.index', compact('pembayarans', 'totalPembayaran'));
    }

    public function create()
    {
        $siswas = Siswa::active()->get();
        $jenisPembayarans = JenisPembayaran::all();
        
        return view('admin.pembayaran.create', compact('siswas', 'jenisPembayarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayarans,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer,va',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $validated['user_id'] = auth()->id();
            $pembayaran = Pembayaran::create($validated);

            // Auto create jurnal
            $this->createJurnalPembayaran($pembayaran);

            DB::commit();

            return redirect()->route('admin.pembayaran.index')
                ->with('success', 'Pembayaran berhasil dicatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['siswa', 'jenisPembayaran', 'user', 'jurnal.details.akun']);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function destroy(Pembayaran $pembayaran)
    {
        DB::beginTransaction();
        try {
            // Hapus jurnal terkait
            if ($pembayaran->jurnal) {
                $pembayaran->jurnal->details()->delete();
                $pembayaran->jurnal->delete();
            }

            $pembayaran->delete();
            
            DB::commit();

            return redirect()->route('admin.pembayaran.index')
                ->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createJurnalPembayaran(Pembayaran $pembayaran)
    {
        // Cari akun kas dan pendapatan SPP
        $akunKas = Akun::where('kode_akun', '1-1-1')->first(); // Sesuaikan kode akun
        $akunPendapatan = Akun::where('kode_akun', '4-1-1')->first(); // Sesuaikan kode akun

        if (!$akunKas || !$akunPendapatan) {
            throw new \Exception('Akun kas atau pendapatan tidak ditemukan');
        }

        $jurnal = Jurnal::create([
            'tanggal' => $pembayaran->tanggal,
            'keterangan' => "Pembayaran {$pembayaran->jenisPembayaran->nama} - {$pembayaran->siswa->nama}",
            'jenis' => 'umum',
            'ref_tipe' => 'pembayaran',
            'ref_id' => $pembayaran->id,
            'user_id' => auth()->id(),
        ]);

        // Debit Kas
        JurnalDetail::create([
            'jurnal_id' => $jurnal->id,
            'akun_id' => $akunKas->id,
            'debit' => $pembayaran->jumlah,
            'kredit' => 0,
        ]);

        // Kredit Pendapatan
        JurnalDetail::create([
            'jurnal_id' => $jurnal->id,
            'akun_id' => $akunPendapatan->id,
            'debit' => 0,
            'kredit' => $pembayaran->jumlah,
        ]);
    }

    public function print(Pembayaran $pembayaran)
    {
        $pembayaran->load(['siswa', 'jenisPembayaran']);
        return view('pembayaran.print', compact('pembayaran'));
    }
}