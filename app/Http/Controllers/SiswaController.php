<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Helper method untuk get route prefix
    private function getRoutePrefix()
    {
        return str_replace('_', '-', auth()->user()->role);
    }

    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $siswas = $query->latest()->paginate(10);
        $kelasList = Siswa::distinct()->pluck('kelas');

        // Dynamic view path
        return view('siswa.index', compact('siswas', 'kelasList'));
    }

    public function create()
    {
        // Dynamic view path
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Siswa::create($validated);

        // Dynamic redirect
        return redirect()->route($this->getRoutePrefix() . '.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['pembayarans.jenisPembayaran']);
        $totalPembayaran = $siswa->pembayarans->sum('jumlah');

        // Dynamic view path
        return view('siswa.show', compact('siswa', 'totalPembayaran'));
    }

    public function edit(Siswa $siswa)
    {
        // Dynamic view path
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $siswa->update($validated);

        // Dynamic redirect
        return redirect()->route($this->getRoutePrefix() . '.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        // Check authorization (extra security layer)
        if (!auth()->user()->isAdmin() && !auth()->user()->isTu()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data siswa');
        }

        try {
            $siswa->delete();
            
            // Dynamic redirect
            return redirect()->route($this->getRoutePrefix() . '.siswa.index')
                ->with('success', 'Data siswa berhasil dihapus');
        } catch (\Exception $e) {
            // Dynamic redirect
            return redirect()->route($this->getRoutePrefix() . '.siswa.index')
                ->with('error', 'Data siswa tidak dapat dihapus karena memiliki riwayat pembayaran');
        }
    }
}