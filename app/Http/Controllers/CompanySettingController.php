<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanySettingController extends Controller
{
    /**
     * Tampilkan formulir pengaturan profil perusahaan
     */
    public function edit()
    {
        $setting = CompanySetting::getSettings();

        return view('pages.company.edit', compact('setting'));
    }

    /**
     * Simpan pembaruan profil perusahaan
     */
    public function update(Request $request)
    {
        $setting = CompanySetting::getSettings();

        $validated = $request->validate([
            'nama_perusahaan'  => 'required|string|max:255',
            'email_perusahaan' => 'required|email|max:255',
            'telepon'          => 'required|string|max:50',
            'alamat'           => 'nullable|string|max:1000',
            'npwp'             => 'nullable|string|max:50',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'latitude'         => 'required|string|max:50',
            'longitude'        => 'required|string|max:50',
            'radius_meter'     => 'required|numeric|min:10|max:50000',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'company_logo_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/company');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Hapus logo lama jika ada
            if ($setting->logo && File::exists(public_path($setting->logo))) {
                File::delete(public_path($setting->logo));
            }

            $file->move($destinationPath, $filename);
            $validated['logo'] = 'uploads/company/' . $filename;
        }

        $setting->update($validated);

        return redirect()
            ->route('company.edit')
            ->with('success', 'Profil dan identitas perusahaan berhasil diperbarui.');
    }
}
