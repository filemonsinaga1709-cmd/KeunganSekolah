<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    /**
     * Get route prefix based on user role
     */
    private function getRoutePrefix()
    {
        return str_replace('_', '-', auth()->user()->role);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Akun::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_akun', 'like', "%{$search}%")
                  ->orWhere('nama_akun', 'like', "%{$search}%");
            });
        }

        // Filter by tipe_akun
        if ($request->filled('tipe')) {
            $query->where('tipe_akun', $request->tipe);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Get summary data for dashboard cards
        $summary = [
            'aset' => Akun::where('tipe_akun', 'aset')->where('is_active', true)->count(),
            'kewajiban' => Akun::where('tipe_akun', 'kewajiban')->where('is_active', true)->count(),
            'modal' => Akun::where('tipe_akun', 'modal')->where('is_active', true)->count(),
            'pendapatan' => Akun::where('tipe_akun', 'pendapatan')->where('is_active', true)->count(),
            'beban' => Akun::where('tipe_akun', 'beban')->where('is_active', true)->count(),
        ];

        // Order by kode_akun and paginate
        $akuns = $query->orderBy('kode_akun')->paginate(15)->withQueryString();

        return view('akun.index', compact('akuns', 'summary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only Admin can create (based on screenshot)
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menambah akun');
        }

        return view('akun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only Admin can create
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menambah akun');
        }

        $validated = $request->validate([
            'kode_akun' => 'required|string|unique:akuns,kode_akun|max:20',
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
            'is_active' => 'boolean',
        ], [
            'kode_akun.required' => 'Kode akun wajib diisi',
            'kode_akun.unique' => 'Kode akun sudah digunakan',
            'nama_akun.required' => 'Nama akun wajib diisi',
            'tipe_akun.required' => 'Tipe akun wajib dipilih',
            'tipe_akun.in' => 'Tipe akun tidak valid',
        ]);

        // Set default is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 1;

        Akun::create($validated);

        return redirect()->route($this->getRoutePrefix() . '.akun.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Akun $akun)
    {
        // Load relationships for detail view
        $akun->load(['jurnalDetails' => function($query) {
            $query->with('jurnal')->latest()->take(10);
        }]);

        // Get transaction summary for this account
        $totalDebit = $akun->jurnalDetails()->sum('debit');
        $totalKredit = $akun->jurnalDetails()->sum('kredit');
        $saldo = $totalDebit - $totalKredit;

        return view('akun.show', compact('akun', 'totalDebit', 'totalKredit', 'saldo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akun $akun)
    {
        // Only Admin can edit (based on screenshot)
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah akun');
        }

        return view('akun.edit', compact('akun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Akun $akun)
    {
        // Only Admin can edit
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah akun');
        }

        $validated = $request->validate([
            'kode_akun' => 'required|string|max:20|unique:akuns,kode_akun,' . $akun->id,
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
            'is_active' => 'boolean',
        ], [
            'kode_akun.required' => 'Kode akun wajib diisi',
            'kode_akun.unique' => 'Kode akun sudah digunakan',
            'nama_akun.required' => 'Nama akun wajib diisi',
            'tipe_akun.required' => 'Tipe akun wajib dipilih',
            'tipe_akun.in' => 'Tipe akun tidak valid',
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $akun->update($validated);

        return redirect()->route($this->getRoutePrefix() . '.akun.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Akun $akun)
    {
        // Only Admin can delete (based on screenshot, TU has X)
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus akun');
        }

        try {
            // Check if account is used in transactions
            $transactionCount = $akun->jurnalDetails()->count();
            
            if ($transactionCount > 0) {
                return redirect()->route($this->getRoutePrefix() . '.akun.index')
                    ->with('error', "Akun tidak dapat dihapus karena masih digunakan dalam {$transactionCount} transaksi");
            }

            $kodeAkun = $akun->kode_akun;
            $namaAkun = $akun->nama_akun;
            
            $akun->delete();
            
            return redirect()->route($this->getRoutePrefix() . '.akun.index')
                ->with('success', "Akun {$kodeAkun} - {$namaAkun} berhasil dihapus");
                
        } catch (\Exception $e) {
            return redirect()->route($this->getRoutePrefix() . '.akun.index')
                ->with('error', 'Terjadi kesalahan saat menghapus akun: ' . $e->getMessage());
        }
    }

    /**
     * Toggle account status (activate/deactivate) - AJAX
     */
    public function toggleStatus(Akun $akun)
    {
        // Only Admin can toggle status
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses'
            ], 403);
        }

        $akun->is_active = !$akun->is_active;
        $akun->save();

        return response()->json([
            'success' => true,
            'message' => $akun->is_active ? 'Akun diaktifkan' : 'Akun dinonaktifkan',
            'is_active' => $akun->is_active
        ]);
    }
}