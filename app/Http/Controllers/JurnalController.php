<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    private function getRoutePrefix()
    {
        return str_replace('_', '-', auth()->user()->role);
    }

    public function index(Request $request)
    {
        $query = Jurnal::with(['details.akun', 'user']);

        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $jurnals = $query->latest('tanggal')->paginate(10);

        return view('jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        $akuns = Akun::where('is_active', true)->get();
        return view('jurnal.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'details' => 'required|array|min:2',
            'details.*.akun_id' => 'required|exists:akuns,id',
            'details.*.debit' => 'required|numeric|min:0',
            'details.*.kredit' => 'required|numeric|min:0',
        ]);

        // Validate debit = kredit
        $totalDebit = collect($validated['details'])->sum('debit');
        $totalKredit = collect($validated['details'])->sum('kredit');

        if ($totalDebit != $totalKredit) {
            return back()->withErrors(['details' => 'Total Debit harus sama dengan Total Kredit'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $jurnal = Jurnal::create([
                'tanggal' => $validated['tanggal'],
                'keterangan' => $validated['keterangan'],
                'jenis' => 'umum',
                'user_id' => auth()->id(),
            ]);

            foreach ($validated['details'] as $detail) {
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'akun_id' => $detail['akun_id'],
                    'debit' => $detail['debit'],
                    'kredit' => $detail['kredit'],
                ]);
            }

            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.jurnal.index')
                ->with('success', 'Jurnal berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Jurnal $jurnal)
    {
        $jurnal->load(['details.akun', 'user']);
        return view('jurnal.show', compact('jurnal'));
    }

    public function destroy(Jurnal $jurnal)
    {
        // Check authorization
        if (!auth()->user()->isAdmin() && !auth()->user()->isBendahara()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus jurnal');
        }

        // Prevent deleting auto-generated jurnal
        if ($jurnal->ref_tipe) {
            return back()->with('error', 'Jurnal otomatis tidak dapat dihapus. Hapus transaksi aslinya.');
        }

        DB::beginTransaction();
        try {
            $jurnal->details()->delete();
            $jurnal->delete();
            
            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.jurnal.index')
                ->with('success', 'Jurnal berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
