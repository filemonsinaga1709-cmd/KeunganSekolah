<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Akun;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    private function getRoutePrefix()
    {
        return str_replace('_', '-', auth()->user()->role);
    }

    public function index(Request $request)
    {
        $query = Pengeluaran::with('user');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('no_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $pengeluarans = $query->latest('tanggal')->paginate(10);
        $totalPengeluaran = $query->sum('jumlah');

        return view('pengeluaran.index', compact('pengeluarans', 'totalPengeluaran'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $validated['user_id'] = auth()->id();
            $pengeluaran = Pengeluaran::create($validated);

            // Auto create jurnal
            $this->createJurnalPengeluaran($pengeluaran);

            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dicatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Pengeluaran $pengeluaran)
    {
        $pengeluaran->load(['user', 'jurnal.details.akun']);
        return view('pengeluaran.show', compact('pengeluaran'));
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Delete old jurnal
            if ($pengeluaran->jurnal) {
                $pengeluaran->jurnal->details()->delete();
                $pengeluaran->jurnal->delete();
            }

            $pengeluaran->update($validated);

            // Create new jurnal
            $this->createJurnalPengeluaran($pengeluaran);

            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        // Check authorization
        if (!auth()->user()->isAdmin() && !auth()->user()->isBendahara()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus pengeluaran');
        }

        DB::beginTransaction();
        try {
            // Delete jurnal
            if ($pengeluaran->jurnal) {
                $pengeluaran->jurnal->details()->delete();
                $pengeluaran->jurnal->delete();
            }

            $pengeluaran->delete();
            
            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createJurnalPengeluaran(Pengeluaran $pengeluaran)
    {
        $akunKas = Akun::where('kode_akun', '1-101')->first();
        $akunBeban = Akun::where('kode_akun', '5-999')->first(); // Beban Lain-lain

        if (!$akunKas || !$akunBeban) {
            throw new \Exception('Akun kas atau beban tidak ditemukan');
        }

        $jurnal = Jurnal::create([
            'tanggal' => $pengeluaran->tanggal,
            'keterangan' => "Pengeluaran {$pengeluaran->kategori}",
            'jenis' => 'umum',
            'ref_tipe' => 'pengeluaran',
            'ref_id' => $pengeluaran->id,
            'user_id' => auth()->id(),
        ]);

        // Debit Beban
        JurnalDetail::create([
            'jurnal_id' => $jurnal->id,
            'akun_id' => $akunBeban->id,
            'debit' => $pengeluaran->jumlah,
            'kredit' => 0,
        ]);

        // Kredit Kas
        JurnalDetail::create([
            'jurnal_id' => $jurnal->id,
            'akun_id' => $akunKas->id,
            'debit' => 0,
            'kredit' => $pengeluaran->jumlah,
        ]);
    }
}