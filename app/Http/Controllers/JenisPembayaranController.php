<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $jenisPembayarans = JenisPembayaran::latest()->paginate(10);
        return view('admin.jenis-pembayaran.index', compact('jenisPembayarans'));
    }

    public function create()
    {
        return view('admin.jenis-pembayaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nominal' => 'nullable|numeric|min:0',
        ]);

        JenisPembayaran::create($validated);

        return redirect()->route('admin.jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil ditambahkan');
    }

    public function edit(JenisPembayaran $jenisPembayaran)
    {
        return view('admin.jenis-pembayaran.edit', compact('jenisPembayaran'));
    }

    public function update(Request $request, JenisPembayaran $jenisPembayaran)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nominal' => 'nullable|numeric|min:0',
        ]);

        $jenisPembayaran->update($validated);

        return redirect()->route('admin.jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil diperbarui');
    }

    public function destroy(JenisPembayaran $jenisPembayaran)
    {
        try {
            $jenisPembayaran->delete();
            return redirect()->route('admin.jenis-pembayaran.index')
                ->with('success', 'Jenis pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.jenis-pembayaran.index')
                ->with('error', 'Jenis pembayaran tidak dapat dihapus karena masih digunakan');
        }
    }
}