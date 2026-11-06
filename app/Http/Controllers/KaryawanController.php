<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Tampilkan semua data karyawan
     */
    public function index()
    {
        $karyawans = Karyawan::with('jabatan')
            ->latest()
            ->get();

        return view('pages.karyawan.index', compact('karyawans'));
    }

    /**
     * Form tambah karyawan
     */
    public function create()
    {
        // Cegah pembukaan form tambah jika kuota akun demo sudah penuh
        if (auth()->check() && auth()->user()->isDemo() && Karyawan::count() >= 20) {
            return redirect()
                ->route('karyawan.index')
                ->with('error', 'Batas kuota maksimal 20 karyawan untuk akun demo telah tercapai. Hapus salah satu data untuk menambah kembali.');
        }

        $jabatans = Jabatan::orderBy('nama_jabatan')->get();

        return view('pages.karyawan.create', compact('jabatans'));
    }

    /**
     * Simpan data karyawan
     */
    public function store(Request $request)
    {
        // Pembatasan Kuota Akun Demo (Maksimal 20 Karyawan)
        if (auth()->check() && auth()->user()->isDemo() && Karyawan::count() >= 20) {
            return redirect()
                ->route('karyawan.index')
                ->with('error', 'Batas kuota maksimal 20 karyawan untuk akun demo telah tercapai. Hapus salah satu data untuk mencoba menambah kembali.');
        }

        $validated = $request->validate([
            'nik'             => 'required|string|max:20|unique:karyawans,nik',
            'nama'   => 'required|string|max:255',
            'jabatan_id'      => 'required|exists:jabatans,id',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tanggal_masuk'   => 'required|date',
            'status'          => 'required|in:Aktif,Nonaktif',
        ]);

        Karyawan::create($validated);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Detail data karyawan
     */
    public function show($id)
    {
        $karyawan = Karyawan::with('jabatan')
            ->findOrFail($id);

        return view('pages.karyawan.show', compact('karyawan'));
    }

    /**
     * Form edit data karyawan
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $jabatans = Jabatan::orderBy('nama_jabatan')->get();

        return view('pages.karyawan.edit', compact(
            'karyawan',
            'jabatans'
        ));
    }

    /**
     * Update data karyawan
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validated = $request->validate([
            'nik'             => 'required|string|max:20|unique:karyawans,nik,' . $id,
            'nama'   => 'required|string|max:255',
            'jabatan_id'      => 'required|exists:jabatans,id',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tanggal_masuk'   => 'required|date',
            'status'          => 'required|in:Aktif,Nonaktif',
        ]);

        $karyawan->update($validated);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Hapus data karyawan
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->delete();

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}