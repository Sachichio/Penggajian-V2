<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Potongan;
use Illuminate\Http\Request;

class PotonganController extends Controller
{
    public function index($penggajianId)
    {
        $penggajian = Penggajian::with([
            'karyawan',
            'potongans'
        ])->findOrFail($penggajianId);

        return view(
            'pages.potongan.index',
            compact('penggajian')
        );
    }
    
    public function create($penggajianId)
    {
        $penggajian = Penggajian::with('karyawan')
            ->findOrFail($penggajianId);

        return view('pages.potongan.create', compact('penggajian'));
    }

    public function edit($id)
    {
        $potongan = Potongan::with([
            'penggajian.karyawan'
        ])->findOrFail($id);

        return view(
            'pages.potongan.edit',
            compact('potongan')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'penggajian_id' => 'required|exists:penggajians,id',
            'jenis_potongan' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Potongan::create([
            'penggajian_id' => $request->penggajian_id,
            'jenis_potongan' => $request->jenis_potongan,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        $penggajian = Penggajian::findOrFail($request->penggajian_id);

        $this->updateTotalPotongan($penggajian);

        return redirect()
            ->route('potongan.index', $request->penggajian_id)
            ->with('success', 'Potongan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_potongan' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $potongan = Potongan::findOrFail($id);

        $potongan->update([
            'jenis_potongan' => $request->jenis_potongan,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        // hitung ulang total potongan & THP
        $this->updateTotalPotongan($potongan->penggajian);

        return redirect()
            ->route('potongan.index', $potongan->penggajian_id)
            ->with('success', 'Potongan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $potongan = Potongan::findOrFail($id);

        $penggajian = $potongan->penggajian;

        $potongan->delete();

        $this->updateTotalPotongan($penggajian);

        return redirect()
            ->route('potongan.index', $penggajian->id)
            ->with('success', 'Potongan berhasil dihapus.');
    }

    private function updateTotalPotongan(Penggajian $penggajian)
    {
        // jumlah seluruh nominal potongan
        $totalPotongan = $penggajian->potongans()->sum('nominal');

        // hitung ulang THP
        $thp =
            $penggajian->total_pendapatan -
            $totalPotongan;

        // update tabel penggajian
        $penggajian->update([
            'total_potongan' => $totalPotongan,
            'thp' => $thp,
        ]);
    }
}