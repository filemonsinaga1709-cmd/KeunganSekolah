<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Akun;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::with(['akun', 'user']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('no_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $pengeluarans = $query->latest('tanggal')->paginate(10);
        $totalPengeluaran = $query->sum('jumlah');

        return view('admin.pengeluaran.index', compact('pengeluarans', 'totalPengeluaran'));
    }

    public function create()
    {
        $akuns = Akun::where('tipe_akun', 'beban')->active()->get();
        return view('admin.pengeluaran.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akun_id' => 'nullable|exists:akuns,id',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('bukti_pembayaran')) {
                $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')
                    ->store('bukti-pembayaran', 'public');
            }

            $validated['user_id'] = auth()->id();
            $pengeluaran = Pengeluaran::create($validated);

            // Auto create jurnal
            if ($pengeluaran->akun_id) {
                $this->createJurnalPengeluaran($pengeluaran);
            }

            DB::commit();

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dicatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Pengeluaran $pengeluaran)
    {
        $pengeluaran->load(['akun', 'user', 'jurnal.details.akun']);
        return view('admin.pengeluaran.show', compact('pengeluaran'));
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $akuns = Akun::where('tipe_akun', 'beban')->active()->get();
        return view('admin.pengeluaran.edit', compact('pengeluaran', 'akuns'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akun_id' => 'nullable|exists:akuns,id',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('bukti_pembayaran')) {
                // Hapus file lama
                if ($pengeluaran->bukti_pembayaran) {
                    Storage::disk('public')->delete($pengeluaran->bukti_pembayaran);
                }
                
                $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')
                    ->store('bukti-pembayaran', 'public');
            }

            $pengeluaran->update($validated);

            // Update atau create jurnal
            if ($pengeluaran->jurnal) {
                $pengeluaran->jurnal->details()->delete();
                $pengeluaran->jurnal->delete();
            }

            if ($pengeluaran->akun_id) {
                $this->createJurnalPengeluaran($pengeluaran);
            }

            DB::commit();

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        DB::beginTransaction();
        try {
            if ($pengeluaran->jurnal) {
                $pengeluaran->jurnal->details()->delete();
                $pengeluaran->jurnal->delete();
            }

            if ($pengeluaran->bukti_pembayaran) {
                Storage::disk('public')->delete($pengeluaran->bukti_pembayaran);
            }

            $pengeluaran->delete();
            
            DB::commit();

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createJurnalPengeluaran(Pengeluaran $pengeluaran)
    {
        $akunKas = Akun::where('kode_akun', '1-101')->first();

        if (!$akunKas) {
            throw new \Exception('Akun kas tidak ditemukan');
        }

        $jurnal = Jurnal::create([
            'tanggal' => $pengeluaran->tanggal,
            'keterangan' => $pengeluaran->keterangan,
            'jenis' => 'umum',
            'ref_tipe' => 'pengeluaran',
            'ref_id' => $pengeluaran->id,
            'user_id' => auth()->id(),
        ]);

        // Debit Beban
        JurnalDetail::create([
            'jurnal_id' => $jurnal->id,
            'akun_id' => $pengeluaran->akun_id,
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