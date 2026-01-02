<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Akun;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    private function getRoutePrefix()
    {
        return str_replace('_', '-', auth()->user()->role);
    }

    public function index(Request $request)
    {
        $query = Pemasukan::with('user');

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

        $pemasukans = $query->latest('tanggal')->paginate(10);
        $totalPemasukan = $pemasukans->sum('jumlah'); // Fix: use collection sum

        return view('pemasukan.index', compact('pemasukans', 'totalPemasukan'));
    }

    public function create()
    {
        // Pass akuns untuk dropdown
        $akuns = Akun::where('tipe_akun', 'pendapatan')
                     ->where('is_active', true)
                     ->orderBy('kode_akun')
                     ->get();
        
        return view('pemasukan.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'akun_id' => 'nullable|exists:akuns,id', // Optional akun selection
        ]);

        DB::beginTransaction();
        try {
            $validated['user_id'] = auth()->id();
            $pemasukan = Pemasukan::create($validated);

            // Auto create jurnal
            $this->createJurnalPemasukan($pemasukan, $request->akun_id);

            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.pemasukan.index')
                ->with('success', 'Pemasukan berhasil dicatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Pemasukan $pemasukan)
    {
        $pemasukan->load(['user', 'jurnal.details.akun']);
        return view('pemasukan.show', compact('pemasukan'));
    }

    public function edit(Pemasukan $pemasukan)
    {
        // Pass akuns untuk dropdown
        $akuns = Akun::where('tipe_akun', 'pendapatan')
                     ->where('is_active', true)
                     ->orderBy('kode_akun')
                     ->get();
        
        return view('pemasukan.edit', compact('pemasukan', 'akuns'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'akun_id' => 'nullable|exists:akuns,id',
        ]);

        DB::beginTransaction();
        try {
            // Delete old jurnal
            if ($pemasukan->jurnal) {
                $pemasukan->jurnal->details()->delete();
                $pemasukan->jurnal->delete();
            }

            $pemasukan->update($validated);

            // Create new jurnal
            $this->createJurnalPemasukan($pemasukan, $request->akun_id);

            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.pemasukan.index')
                ->with('success', 'Pemasukan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Pemasukan $pemasukan)
    {
        // Check authorization
        if (!auth()->user()->isAdmin() && !auth()->user()->isBendahara()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus pemasukan');
        }

        DB::beginTransaction();
        try {
            // Delete jurnal
            if ($pemasukan->jurnal) {
                $pemasukan->jurnal->details()->delete();
                $pemasukan->jurnal->delete();
            }

            $pemasukan->delete();
            
            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.pemasukan.index')
                ->with('success', 'Pemasukan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createJurnalPemasukan(Pemasukan $pemasukan, $selectedAkunId = null)
    {
        $akunKas = Akun::where('kode_akun', '1-101')->first();
        
        // Use selected akun or default to 4-999
        if ($selectedAkunId) {
            $akunPendapatan = Akun::find($selectedAkunId);
        } else {
            $akunPendapatan = Akun::where('kode_akun', '4-999')->first(); // Pendapatan Lain-lain
        }

        if (!$akunKas) {
            throw new \Exception('Akun Kas (1-101) tidak ditemukan');
        }
        
        if (!$akunPendapatan) {
            throw new \Exception('Akun Pendapatan tidak ditemukan');
        }

        $jurnal = Jurnal::create([
            'tanggal' => $pemasukan->tanggal,
            'keterangan' => "Pemasukan {$pemasukan->kategori} - {$pemasukan->keterangan}",
            'jenis' => 'umum',
            'ref_tipe' => 'pemasukan',
            'ref_id' => $pemasukan->id,
            'user_id' => auth()->id(),
        ]);

        // Debit Kas
        JurnalDetail::create([
            'jurnal_id' => $jurnal->id,
            'akun_id' => $akunKas->id,
            'debit' => $pemasukan->jumlah,
            'kredit' => 0,
        ]);

        // Kredit Pendapatan
        JurnalDetail::create([
            'jurnal_id' => $jurnal->id,
            'akun_id' => $akunPendapatan->id,
            'debit' => 0,
            'kredit' => $pemasukan->jumlah,
        ]);
    }
}