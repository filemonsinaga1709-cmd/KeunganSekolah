<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Akun;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurnal::with(['details.akun', 'user']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $jurnals = $query->latest('tanggal')->paginate(15);

        return view('admin.jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        $akuns = Akun::active()->get();
        return view('admin.jurnal.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'jenis' => 'required|in:umum,penyesuaian,penutup',
            'details' => 'required|array|min:2',
            'details.*.akun_id' => 'required|exists:akuns,id',
            'details.*.debit' => 'required|numeric|min:0',
            'details.*.kredit' => 'required|numeric|min:0',
        ]);

        // Validasi balance debit = kredit
        $totalDebit = collect($request->details)->sum('debit');
        $totalKredit = collect($request->details)->sum('kredit');

        if ($totalDebit != $totalKredit) {
            return back()->withErrors(['details' => 'Total debit dan kredit harus sama'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $jurnal = Jurnal::create([
                'tanggal' => $validated['tanggal'],
                'keterangan' => $validated['keterangan'],
                'jenis' => $validated['jenis'],
                'user_id' => auth()->id(),
            ]);

            foreach ($request->details as $detail) {
                if ($detail['debit'] > 0 || $detail['kredit'] > 0) {
                    JurnalDetail::create([
                        'jurnal_id' => $jurnal->id,
                        'akun_id' => $detail['akun_id'],
                        'debit' => $detail['debit'],
                        'kredit' => $detail['kredit'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('jurnal.index')
                ->with('success', 'Jurnal berhasil dicatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Jurnal $jurnal)
    {
        $jurnal->load(['details.akun', 'user']);
        return view('admin.jurnal.show', compact('jurnal'));
    }

    public function destroy(Jurnal $jurnal)
    {
        // Cek apakah jurnal adalah hasil auto-generate
        if ($jurnal->ref_tipe && $jurnal->ref_id) {
            return back()->with('error', 'Jurnal otomatis tidak dapat dihapus. Hapus transaksi aslinya.');
        }

        DB::beginTransaction();
        try {
            $jurnal->details()->delete();
            $jurnal->delete();
            
            DB::commit();

            return redirect()->route('jurnal.index')
                ->with('success', 'Jurnal berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}