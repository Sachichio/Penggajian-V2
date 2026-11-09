@extends('layouts.app')

@section('title', 'Profil Perusahaan')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">PENGATURAN SISTEM</div>
        <h1>Profil Perusahaan</h1>
        <p>Kelola identitas resmi, logo, kontak, dan titik koordinat GPS kantor untuk presensi mandiri.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('dashboard') }}" class="button secondary">
            ← Kembali ke Dashboard
        </a>
    </div>
</section>

{{-- Notifikasi Sukses / Error --}}
@if(session('success'))
<div class="mb-5 flex items-center gap-2.5 rounded-[8px] border border-[#d6e5cd] bg-[#f2f8ed] px-4 py-3 text-[11.5px] font-medium text-[#3b6b47]">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-forest shrink-0">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-5 flex items-center gap-2.5 rounded-[8px] border border-red-200 bg-red-50/80 px-4 py-3 text-[11.5px] font-medium text-red-700">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 shrink-0">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
    <span>{{ session('error') }}</span>
</div>
@endif

<div class="max-w-4xl mb-10">
    <div class="form-card">
        <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- 1. IDENTITAS UTAMA PERUSAHAAN --}}
            <div>
                <h2 class="text-[12.5px] font-bold text-forest uppercase tracking-wider mb-3">1. Identitas Badan Usaha</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                            Nama Resmi Perusahaan (PT/CV) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama_perusahaan"
                            value="{{ old('nama_perusahaan', $setting->nama_perusahaan) }}"
                            placeholder="Contoh: PT. Sejahtera Bersama"
                            required
                            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                        @error('nama_perusahaan')
                            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                            NPWP Perusahaan
                        </label>
                        <input
                            type="text"
                            name="npwp"
                            value="{{ old('npwp', $setting->npwp) }}"
                            placeholder="01.234.567.8-012.000"
                            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                        @error('npwp')
                            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Logo Upload --}}
                <div class="mt-4">
                    <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                        Logo Perusahaan (Untuk Kiosk, Slip Gaji & Kop Laporan)
                    </label>
                    <div class="flex items-center gap-4">
                        @if($setting->logo && file_exists(public_path($setting->logo)))
                            <img id="logo-preview" src="{{ asset($setting->logo) }}" alt="Logo" class="h-14 w-14 rounded-lg object-contain border border-[#d6e0ce] bg-white p-1">
                        @else
                            <div id="logo-preview" class="h-14 w-14 rounded-lg border border-dashed border-[#d6e0ce] bg-[#fbfdfa] grid place-items-center text-[10px] text-[#8e9c8a]">
                                No Logo
                            </div>
                        @endif
                        <div class="flex-1">
                            <input
                                type="file"
                                name="logo"
                                accept="image/png,image/jpeg,image/webp"
                                onchange="previewImage(this)"
                                class="block w-full text-[11px] text-ink file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-[#f0f6eb] file:text-forest hover:file:bg-[#e4eedc]">
                            <p class="text-[10px] text-[#8e9c8a] mt-1">Format gambar: PNG, JPG, WEBP. Maksimal ukuran 2MB.</p>
                        </div>
                    </div>
                    @error('logo')
                        <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-[#edf1e8] pt-5">
                <h2 class="text-[12.5px] font-bold text-forest uppercase tracking-wider mb-3">2. Kontak & Alamat Kantor</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                            Email Resmi Kantor <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            name="email_perusahaan"
                            value="{{ old('email_perusahaan', $setting->email_perusahaan) }}"
                            placeholder="info@perusahaan.com"
                            required
                            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                        @error('email_perusahaan')
                            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                            Nomor Telepon Kantor <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="telepon"
                            value="{{ old('telepon', $setting->telepon) }}"
                            placeholder="(021) 555-0192"
                            required
                            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                        @error('telepon')
                            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                        Alamat Kantor Lengkap
                    </label>
                    <textarea
                        name="alamat"
                        rows="2"
                        placeholder="Contoh: Jl. Jenderal Sudirman Kav. 21, Jakarta Selatan"
                        class="w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] p-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">{{ old('alamat', $setting->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 3. KOORDINAT GPS KIOSK --}}
            <div class="border-t border-[#edf1e8] pt-5">
                <h2 class="text-[12.5px] font-bold text-forest uppercase tracking-wider mb-1">3. Lokasi Presensi Radar GPS (Terminal Kiosk)</h2>
                <p class="text-[11px] text-[#7d8b7d] mb-3">Koordinat ini menjadi titik acuan verifikasi kehadiran mandiri karyawan pada rute <code>/absen-masuk</code>.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                            Latitude Kantor <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="latitude"
                            value="{{ old('latitude', $setting->latitude) }}"
                            required
                            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                        @error('latitude')
                            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                            Longitude Kantor <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="longitude"
                            value="{{ old('longitude', $setting->longitude) }}"
                            required
                            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                        @error('longitude')
                            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                            Radius Toleransi (Meter) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="radius_meter"
                            min="10"
                            value="{{ old('radius_meter', $setting->radius_meter) }}"
                            required
                            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                        @error('radius_meter')
                            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-[#edf1e8] pt-5">
                <button type="submit" class="button primary">
                    Simpan Perubahan Profil
                </button>
                <a href="{{ route('dashboard') }}" class="button secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logo-preview');
            if (preview.tagName.toLowerCase() === 'img') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = 'logo-preview';
                img.src = e.target.result;
                img.className = 'h-14 w-14 rounded-lg object-contain border border-[#d6e0ce] bg-white p-1';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
