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
    public function index(Request $request)
    {
        $query = Pemasukan::with(['akun', 'user']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('no_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $pemasukans = $query->latest('tanggal')->paginate(10);
        $totalPemasukan = $query->sum('jumlah');

        return view('admin.pemasukan.index', compact('pemasukans', 'totalPemasukan'));
    }

    public function create()
    {
        $akuns = Akun::where('tipe_akun', 'pendapatan')->active()->get();
        return view('admin.pemasukan.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'akun_id' => 'nullable|exists:akuns,id',
        ]);

        DB::beginTransaction();
        try {
            $validated['user_id'] = auth()->id();
            $pemasukan = Pemasukan::create($validated);

            // Auto create jurnal
            if ($pemasukan->akun_id) {
                $this->createJurnalPemasukan($pemasukan);
            }

            DB::commit();

            return redirect()->route('admin.pemasukan.index')
                ->with('success', 'Pemasukan berhasil dicatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Pemasukan $pemasukan)
    {
        $pemasukan->load(['akun', 'user', 'jurnal.details.akun']);
        return view('admin.pemasukan.show', compact('pemasukan'));
    }

    public function edit(Pemasukan $pemasukan)
    {
        $akuns = Akun::where('tipe_akun', 'pendapatan')->active()->get();
        return view('admin.pemasukan.edit', compact('pemasukan', 'akuns'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'akun_id' => 'nullable|exists:akuns,id',
        ]);

        DB::beginTransaction();
        try {
            $pemasukan->update($validated);

            // Update atau create jurnal
            if ($pemasukan->jurnal) {
                $pemasukan->jurnal->details()->delete();
                $pemasukan->jurnal->delete();
            }

            if ($pemasukan->akun_id) {
                $this->createJurnalPemasukan($pemasukan);
            }

            DB::commit();

            return redirect()->route('admin.pemasukan.index')
                ->with('success', 'Pemasukan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Pemasukan $pemasukan)
    {
        DB::beginTransaction();
        try {
            if ($pemasukan->jurnal) {
                $pemasukan->jurnal->details()->delete();
                $pemasukan->jurnal->delete();
            }

            $pemasukan->delete();
            
            DB::commit();

            return redirect()->route('admin.pemasukan.index')
                ->with('success', 'Pemasukan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createJurnalPemasukan(Pemasukan $pemasukan)
    {
        $akunKas = Akun::where('kode_akun', '1-1-1')->first();

        if (!$akunKas) {
            throw new \Exception('Akun kas tidak ditemukan');
        }

        $jurnal = Jurnal::create([
            'tanggal' => $pemasukan->tanggal,
            'keterangan' => $pemasukan->keterangan,
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
            'akun_id' => $pemasukan->akun_id,
            'debit' => 0,
            'kredit' => $pemasukan->jumlah,
        ]);
    }
}