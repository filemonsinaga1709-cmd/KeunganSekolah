<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $akuns = Akun::latest()->paginate(10);
        return view('admin.akun.index', compact('akuns'));
    }

    public function create()
    {
        return view('admin.akun.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_akun' => 'required|string|max:20|unique:akuns,kode_akun',
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
            'is_active' => 'boolean',
        ]);

        Akun::create($validated);

        return redirect()->route('admin.akun.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    public function show(Akun $akun)
    {
        $akun->load(['jurnalDetails.jurnal']);
        return view('admin.akun.show', compact('akun'));
    }

    public function edit(Akun $akun)
    {
        return view('admin.akun.edit', compact('akun'));
    }

    public function update(Request $request, Akun $akun)
    {
        $validated = $request->validate([
            'kode_akun' => 'required|string|max:20|unique:akuns,kode_akun,' . $akun->id,
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
            'is_active' => 'boolean',
        ]);

        $akun->update($validated);

        return redirect()->route('admin.akun.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    public function destroy(Akun $akun)
    {
        try {
            $akun->delete();
            return redirect()->route('admin.akun.index')
                ->with('success', 'Akun berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.akun.index')
                ->with('error', 'Akun tidak dapat dihapus karena masih digunakan');
        }
    }
}