<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Tampilkan semua data jabatan
     */
    public function index()
    {
        $jabatans = Jabatan::latest()->get();

        return view('pages.jabatan.index', compact('jabatans'));
    }

    /**
     * Form tambah jabatan
     */
    public function create()
    {
        return view('pages.jabatan.create');
    }

    /**
     * Simpan data jabatan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan',
            'gaji_pokok'   => 'required|numeric|min:0',
            'tunjangan'    => 'required|numeric|min:0',
        ]);

        Jabatan::create($validated);

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    /**
     * Detail jabatan
     */
    public function show($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        return view('pages.jabatan.show', compact('jabatan'));
    }

    /**
     * Form edit jabatan
     */
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        return view('pages.jabatan.edit', compact('jabatan'));
    }

    /**
     * Update data jabatan
     */
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan,' . $id,
            'gaji_pokok'   => 'required|numeric|min:0',
            'tunjangan'    => 'required|numeric|min:0',
        ]);

        $jabatan->update($validated);

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil diperbarui.');
    }

    /**
     * Hapus data jabatan
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $jabatan->delete();

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil dihapus.');
    }
}