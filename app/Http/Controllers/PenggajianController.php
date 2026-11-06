<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    /**
     * Tampilkan seluruh data penggajian
     */
    public function index()
    {
        $penggajians = Penggajian::with('karyawan')
            ->latest()
            ->get();

        return view('pages.penggajian.index', compact('penggajians'));
    }


    /**
     * Form tambah penggajian
     */
    public function create()
    {
        // Cegah pembukaan form tambah jika kuota akun demo sudah penuh
        if (auth()->check() && auth()->user()->isDemo() && Penggajian::count() >= 20) {
            return redirect()
                ->route('penggajian.index')
                ->with('error', 'Batas kuota maksimal 20 transaksi penggajian untuk akun demo telah tercapai. Hapus salah satu transaksi untuk menambah kembali.');
        }

        $karyawans = Karyawan::with('jabatan')
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        return view('pages.penggajian.create', compact('karyawans'));
    }

    /**
     * Search karyawan (Autocomplete)
     */
    public function searchKaryawan(Request $request)
    {
        $keyword = $request->keyword;

        $karyawans = Karyawan::with('jabatan')
            ->where('status', 'Aktif')
            ->where(function ($query) use ($keyword) {

                $query->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('nik', 'like', '%' . $keyword . '%');

            })
            ->orderBy('nama')
            ->limit(10)
            ->get();

        return response()->json($karyawans);
    }
    
    public function getKaryawan($id)
    {
        $karyawan = Karyawan::with('jabatan')
            ->findOrFail($id);

        return response()->json([
            'id' => $karyawan->id,
            'nama' => $karyawan->nama,
            'nik' => $karyawan->nik,
            'gaji_pokok' => $karyawan->jabatan->gaji_pokok,
            'tunjangan' => $karyawan->jabatan->tunjangan,
        ]);
    }


    /**
     * Simpan data penggajian
     */
    public function store(Request $request)
    {
        // Pembatasan Kuota Akun Demo (Maksimal 20 Transaksi Penggajian)
        if (auth()->check() && auth()->user()->isDemo() && Penggajian::count() >= 20) {
            return redirect()
                ->route('penggajian.index')
                ->with('error', 'Batas kuota maksimal 20 transaksi penggajian untuk akun demo telah tercapai. Hapus salah satu transaksi untuk mencoba menambah kembali.');
        }

        $validated = $request->validate([

            'karyawan_id' => 'required|exists:karyawans,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|digits:4',
            'jam_lembur' => 'required|numeric|min:0',
            'tanggal_gaji' => 'required|date',
        ]);

        // Ambil data karyawan beserta jabatan
        $karyawan = Karyawan::with('jabatan')
            ->findOrFail($request->karyawan_id);

        // Ambil gaji berdasarkan jabatan
        $gajiPokok = $karyawan->jabatan->gaji_pokok;
        $tunjangan = $karyawan->jabatan->tunjangan;


        /*
        |--------------------------------------------------------------------------
        | Perhitungan Lembur
        |--------------------------------------------------------------------------
        */

        // Tarif lembur
        $tarifLembur = 25000;
        $totalLembur = 
            $request->jam_lembur * $tarifLembur;


        /*
        |--------------------------------------------------------------------------
        | Perhitungan Pendapatan
        |--------------------------------------------------------------------------
        */

        $totalPendapatan =
            $gajiPokok +
            $tunjangan +
            $totalLembur;


        /*
        |--------------------------------------------------------------------------
        | Potongan
        |--------------------------------------------------------------------------
        */

        // sementara belum ada potongan
        $totalPotongan = 0;


        /*
        |--------------------------------------------------------------------------
        | Take Home Pay
        |--------------------------------------------------------------------------
        */

        $thp =
            $totalPendapatan -
            $totalPotongan;

        Penggajian::create([

            'karyawan_id' => $request->karyawan_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jam_lembur' => $request->jam_lembur,
            'gaji_pokok' => $gajiPokok,
            'tunjangan' => $tunjangan,
            'total_lembur' => $totalLembur,
            'total_pendapatan' => $totalPendapatan,
            'total_potongan' => $totalPotongan,
            'thp' => $thp,
            'tanggal_gaji' => $request->tanggal_gaji,
        ]);



        return redirect()
            ->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil disimpan.');
    }


    /**
     * Detail penggajian
     */
    public function show($id)
    {
        $penggajian = Penggajian::with('karyawan.jabatan')
            ->findOrFail($id);

        return view('pages.penggajian.show', compact('penggajian'));
    }


    /**
     * Form edit penggajian
     */
    public function edit($id)
    {

        $penggajian = Penggajian::findOrFail($id);

        $karyawans = Karyawan::with('jabatan')
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        return view('pages.penggajian.edit', compact(
            'penggajian',
            'karyawans'
        ));
    }


    /**
     * Update data penggajian
     */
    public function update(Request $request, $id)
    {

        $penggajian = Penggajian::findOrFail($id);

        $validated = $request->validate([

            'karyawan_id' => 'required|exists:karyawans,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|digits:4',
            'jam_lembur' => 'required|numeric|min:0',
            'tanggal_gaji' => 'required|date',
        ]);

        // Ambil jabatan terbaru karyawan

        $karyawan = Karyawan::with('jabatan')
            ->findOrFail($request->karyawan_id);

        $gajiPokok = $karyawan->jabatan->gaji_pokok;

        $tunjangan = $karyawan->jabatan->tunjangan;

        $tarifLembur = 25000;

        $totalLembur =
            $request->jam_lembur * $tarifLembur;

        $totalPendapatan =
            $gajiPokok +
            $tunjangan +
            $totalLembur;

        // Ambil akumulasi rincian potongan eksisting dari database agar tidak ter-reset
        $totalPotongan = (float) $penggajian->potongans()->sum('nominal');

        $thp =
            $totalPendapatan -
            $totalPotongan;

        $penggajian->update([

            'karyawan_id' => $request->karyawan_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jam_lembur' => $request->jam_lembur,
            'gaji_pokok' => $gajiPokok,
            'tunjangan' => $tunjangan,
            'total_lembur' => $totalLembur,
            'total_pendapatan' => $totalPendapatan,
            'total_potongan' => $totalPotongan,
            'thp' => $thp,
            'tanggal_gaji' => $request->tanggal_gaji,
        ]);

        return redirect()
            ->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil diperbarui.');
    }


    /**
     * Hapus data penggajian
     */
    public function destroy($id)
    {

        $penggajian = Penggajian::findOrFail($id);

        $penggajian->delete();

        return redirect()
            ->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil dihapus.');
    }

    /**
     * Otorisasi / Approval Penggajian oleh Owner
     */
    public function approvePayroll($id)
    {
        $penggajian = Penggajian::with('karyawan')->findOrFail($id);
        $penggajian->status_approval = 'Disetujui';
        $penggajian->save();

        return back()->with('success', "Penggajian atas nama {$penggajian->karyawan->nama} periode {$penggajian->bulan} {$penggajian->tahun} BERHASIL DISETUJUI & DITERBITKAN.");
    }
}