@php
    $layout = auth()->check() ? 'layouts.app' : 'layouts.guest';
@endphp

@extends($layout)

@section('title', 'Terjadi Kendala Sistem')

@section('content')
@if (auth()->check())
    {{-- ========================================================================= --}}
    {{-- TAMPILAN 500 UNTUK PENGGUNA YANG SEDANG LOGIN (DI DALAM SHELL DASHBOARD) --}}
    {{-- ========================================================================= --}}
    <div class="flex min-h-[65vh] flex-col items-center justify-center px-4 py-12 text-center">
        {{-- Ikon Utama --}}
        <div class="mb-5 grid h-16 w-16 place-items-center rounded-2xl bg-rose-50 text-rose-600 ring-1 ring-inset ring-rose-200">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </div>

        {{-- Badge Status --}}
        <div class="mb-3">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3.5 py-1 text-xs font-semibold text-rose-700 border border-rose-200">
                <span class="h-1.5 w-1.5 rounded-full bg-rose-600"></span>
                Error 500 · Kendala Server
            </span>
        </div>

        {{-- Judul Halaman --}}
        <h1 class="text-2xl font-extrabold tracking-tight text-ink sm:text-3xl font-display mb-2">
            Terjadi Kendala pada Server
        </h1>

        <p class="max-w-md text-sm leading-relaxed text-[#6c786e] mb-6 font-sans">
            Sistem sedang mengalami kendala pemrosesan atau jaringan sementara. Sesi login akun Anda tetap tersimpan dengan aman.
        </p>

        {{-- Tombol Aksi --}}
        <div class="flex flex-wrap items-center justify-center gap-3">
            <button type="button" onclick="window.location.reload()" class="button secondary inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-semibold transition">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
                Muat Ulang
            </button>
            <a href="{{ route('dashboard') }}" class="button primary inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-xs font-semibold shadow-sm transition">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@else
    {{-- ========================================================================= --}}
    {{-- TAMPILAN 500 MANDIRI UNTUK PENGUNJUNG TAMU (BELUM LOGIN)                  --}}
    {{-- ========================================================================= --}}
    <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-canvas px-4 py-12">
        <div class="relative w-full max-w-md rounded-[24px] bg-white text-center p-8 border border-[#e5eae3] shadow-[0_12px_40px_rgba(35,70,49,0.08)]">
            
            {{-- Brand Logo --}}
            <a href="{{ route('login') }}" class="inline-flex select-none items-center gap-2 font-display text-[26px] font-extrabold leading-none tracking-[-0.055em] text-ink mb-6">
                <span class="inline-flex -rotate-[9deg] items-end gap-[3px] leading-none">
                    <span class="w-[6px] h-[15px] rounded-[2px] bg-[#336b4b]"></span>
                    <span class="w-[6px] h-[23px] rounded-[2px] bg-[#5b8760]"></span>
                    <span class="w-[6px] h-[19px] rounded-[2px] bg-[#a3bd8b]"></span>
                </span>
                <span>gajiku<span class="text-forest">.</span></span>
            </a>

            <div class="w-full bg-[#edf1e8] h-px mb-6"></div>

            {{-- Ilustrasi Ikon Error --}}
            <div class="mx-auto mb-4 grid h-16 w-16 place-items-center rounded-2xl bg-rose-50 text-rose-600 ring-1 ring-inset ring-rose-200">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>

            {{-- Badge Status --}}
            <div class="mb-3">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3.5 py-1 text-xs font-semibold text-rose-700 border border-rose-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-600"></span>
                    Error 500 · Kendala Server
                </span>
            </div>

            <h1 class="text-xl font-bold tracking-tight text-ink sm:text-2xl font-display mb-2">
                Terjadi Kendala Sistem
            </h1>

            <p class="text-xs leading-relaxed text-[#6c786e] sm:text-sm mb-6 font-sans">
                Server sedang memproses permintaan atau mengalami kendala jaringan sesaat. Silakan coba beberapa saat lagi.
            </p>

            <div class="flex flex-col gap-3">
                <button type="button" onclick="window.location.reload()" class="flex h-[42px] w-full items-center justify-center gap-2 rounded-[10px] border border-[#d6e0ce] bg-white text-[12px] font-semibold text-ink hover:bg-[#f7faf4] transition">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <polyline points="1 20 1 14 7 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                    Muat Ulang Halaman
                </button>
                <a href="{{ route('login') }}" class="flex h-[44px] w-full items-center justify-center gap-2 rounded-[10px] bg-[linear-gradient(135deg,#3a7456_0%,#2f674a_60%,#2a5d43_100%)] text-[12px] font-semibold text-white shadow-[0_10px_24px_-12px_rgba(38,84,60,0.85)] transition hover:brightness-[1.04]">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Kembali ke Halaman Masuk
                </a>
            </div>

            <div class="mt-6 pt-4 border-t border-[#edf1e8]">
                <p class="text-[11px] text-[#939e94]">
                    © 2026 gajiku. · PT. Sejahtera Bersama
                </p>
            </div>
        </div>
    </div>
@endif
@endsection
