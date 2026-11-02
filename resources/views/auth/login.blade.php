@extends('layouts.guest')

@section('title', 'Masuk ke Akun — gajiku.')

@section('content')
<div class="min-h-screen bg-canvas font-sans text-ink">
    <main class="grid min-h-screen grid-cols-1 lg:grid-cols-[1.06fr_0.94fr] xl:grid-cols-[1.08fr_0.92fr]">

        {{-- ========================================================= --}}
        {{-- SISI KIRI: BRAND PANEL (PERSIS GAMBAR 3)                  --}}
        {{-- ========================================================= --}}
        <section aria-label="Tentang gajiku" class="hero-surface no-scrollbar relative hidden min-h-screen overflow-x-hidden overflow-y-auto border-r border-[#e1ead8] lg:flex lg:flex-col">
            {{-- Background Decorative Accents --}}
            <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                <div class="absolute -left-28 -top-28 h-80 w-80 rounded-full bg-[#dcead0]/70 blur-3xl"></div>
                <div class="absolute -bottom-40 -right-28 h-[430px] w-[430px] rounded-full bg-[#d3e5c4]/60 blur-3xl"></div>
                <div class="dot-field absolute inset-0 opacity-60 [mask-image:radial-gradient(75%_65%_at_72%_18%,black,transparent)]"></div>
                
                {{-- Decorative concentric circles --}}
                <svg class="absolute -bottom-24 -left-20 h-80 w-80 text-[#c9dbbc]" viewBox="0 0 320 320" fill="none">
                    <circle cx="160" cy="160" r="90" stroke="currentColor" stroke-width="1.2" />
                    <circle cx="160" cy="160" r="130" stroke="currentColor" stroke-width="1.2" opacity="0.7" />
                    <circle cx="160" cy="160" r="158" stroke="currentColor" stroke-width="1.2" opacity="0.45" />
                </svg>

                {{-- Wavy line top right --}}
                <svg class="absolute right-9 top-11 h-24 w-24 text-[#b9cea9]" viewBox="0 0 96 96" fill="none">
                    <path d="M4 60c14 0 20-16 34-16s20 22 34 22 16-10 20-14" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                    <path d="M4 74c14 0 20-16 34-16s20 22 34 22 16-10 20-14" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" opacity="0.55" />
                </svg>

                <span class="absolute right-[16%] top-[30%] h-2 w-2 rounded-full bg-[#a9c599]"></span>
                <span class="absolute left-[12%] top-[62%] h-1.5 w-1.5 rounded-full bg-[#c0d4b1]"></span>
            </div>

            <div class="relative z-10 mx-auto flex w-full max-w-[620px] flex-1 flex-col px-8 py-6 lg:px-9 xl:px-11 xl:py-8">
                {{-- Top Brand Header --}}
                <header class="flex items-center justify-between gap-4">
                    <div class="inline-flex select-none items-center gap-2 font-display text-[28px] font-extrabold leading-none tracking-[-0.055em] text-ink">
                        <span class="inline-flex -rotate-[9deg] items-end gap-[3px] leading-none">
                            <span class="w-[7px] h-[17px] rounded-[2px] bg-[#336b4b]"></span>
                            <span class="w-[7px] h-[26px] rounded-[2px] bg-[#5b8760]"></span>
                            <span class="w-[7px] h-[21px] rounded-[2px] bg-[#a3bd8b]"></span>
                        </span>
                        <span>gajiku<span class="text-forest">.</span></span>
                    </div>

                    <span class="inline-flex items-center gap-2 rounded-full border border-[#dbe6d0] bg-white/60 px-3 py-1.5 text-[9px] font-bold uppercase tracking-[0.16em] text-[#617a58] backdrop-blur">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#6d9563] opacity-60"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-forest"></span>
                        </span>
                        Portal HR
                    </span>
                </header>

                {{-- Hero Copy & Visual --}}
                <div class="my-auto w-full py-5 xl:py-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#dae6cf] bg-white/70 px-3 py-1.5 text-[9.5px] font-bold uppercase tracking-[0.17em] text-[#68815d] shadow-[0_1px_2px_rgba(35,70,49,0.04)] backdrop-blur">
                        <svg class="h-3.5 w-3.5 text-forest" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        Penggajian yang lebih tenang
                    </div>

                    <h2 class="mt-4 font-display text-[clamp(1.85rem,2.8vw,2.75rem)] font-extrabold leading-[1.08] tracking-[-0.04em] text-[#27332c]">
                        Semua lebih mudah,<br />
                        dalam
                        <span class="relative inline-block whitespace-nowrap text-[#244734]">
                            satu tempat.
                            <svg class="absolute -bottom-1.5 left-0 w-[102%] text-[#9fbd8d]" viewBox="0 0 230 10" fill="none" aria-hidden="true">
                                <path d="M2.5 7.2C52 2.6 139 2.4 227.5 5.6" stroke="currentColor" stroke-width="3.4" stroke-linecap="round" />
                            </svg>
                        </span>
                    </h2>

                    <p class="mt-4 max-w-[430px] text-[12.5px] leading-[1.75] text-[#6a796c]">
                        Kelola data karyawan, proses penggajian, dan bagikan slip gaji digital — rapi, akurat, dan selalu tepat waktu.
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-[#dde8d3] bg-white/65 px-2.5 py-1.5 text-[10px] font-medium text-[#5f7659] backdrop-blur">
                            <svg class="h-3.5 w-3.5 text-[#75916a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Payroll otomatis
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-[#dde8d3] bg-white/65 px-2.5 py-1.5 text-[10px] font-medium text-[#5f7659] backdrop-blur">
                            <svg class="h-3.5 w-3.5 text-[#75916a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Slip gaji digital
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-[#dde8d3] bg-white/65 px-2.5 py-1.5 text-[10px] font-medium text-[#5f7659] backdrop-blur">
                            <svg class="h-3.5 w-3.5 text-[#75916a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Laporan siap audit
                        </span>
                    </div>

                    {{-- Mini Dashboard Preview Card (Persis Gambar 3) --}}
                    <div class="relative mt-5" aria-hidden="true">
                        <div class="preview-shadow relative overflow-hidden rounded-[20px] border border-white/90 bg-white/90 p-3.5 ring-1 ring-[#dde8d4]/80 backdrop-blur-sm">
                            <div class="pointer-events-none absolute -right-10 -top-14 h-32 w-32 rounded-full bg-[#edf4e5]"></div>

                            <div class="relative flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-2.5">
                                    <span class="brand-tile h-7 w-7 rounded-[8px] text-white">
                                        <span class="inline-flex -rotate-[9deg] items-end gap-[1.5px] leading-none">
                                            <span class="w-[2.5px] h-[7px] rounded-[1px] bg-[#dce8d2]"></span>
                                            <span class="w-[2.5px] h-[11px] rounded-[1px] bg-[#f8fbf4]"></span>
                                            <span class="w-[2.5px] h-[9px] rounded-[1px] bg-[#a9c599]"></span>
                                        </span>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate text-[11.5px] font-semibold tracking-[-0.1px] text-[#2f3c35]">
                                            Ringkasan penggajian
                                        </p>
                                        <p class="mt-0.5 truncate text-[9px] text-[#8f9b90]">PT. Sejahtera Bersama</p>
                                    </div>
                                </div>
                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-md border border-[#e6ede0] bg-[#fbfdf8] px-2 py-1 text-[8.5px] font-medium text-[#71816a]">
                                    <svg class="h-3 w-3 text-[#8a9c80]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Juli 2026
                                </span>
                            </div>

                            {{-- 3 Mini Stats --}}
                            <div class="relative mt-3 grid grid-cols-3 gap-2">
                                <div class="rounded-[9px] border border-[#eef2e9] bg-[#fbfcf9] px-2.5 py-2">
                                    <div class="flex items-center justify-between gap-1">
                                        <span class="truncate text-[8px] text-[#8b9784]">Total karyawan</span>
                                        <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-[5px] bg-[#eaf1e3] text-[#5f7d52]">
                                            <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m20 0v-2a4 4 0 00-3-3.87M16 3a4 4 0 010 8" />
                                                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </span>
                                    </div>
                                    <p class="mt-1 flex items-baseline gap-1 font-display text-[16px] font-extrabold leading-none tracking-[-0.04em] text-[#2c3a31]">
                                        11 <span class="font-sans text-[7.5px] font-medium tracking-normal text-[#9ba596]">orang</span>
                                    </p>
                                </div>

                                <div class="rounded-[9px] border border-[#eef2e9] bg-[#fbfcf9] px-2.5 py-2">
                                    <div class="flex items-center justify-between gap-1">
                                        <span class="truncate text-[8px] text-[#8b9784]">Payroll Juli</span>
                                        <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-[5px] bg-[#f6ecdf] text-[#a8825d]">
                                            <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <p class="mt-1 flex items-baseline gap-1 font-display text-[16px] font-extrabold leading-none tracking-[-0.04em] text-[#2c3a31]">
                                        184,5 <span class="font-sans text-[7.5px] font-medium tracking-normal text-[#9ba596]">jt</span>
                                    </p>
                                </div>

                                <div class="rounded-[9px] border border-[#eef2e9] bg-[#fbfcf9] px-2.5 py-2">
                                    <div class="flex items-center justify-between gap-1">
                                        <span class="truncate text-[8px] text-[#8b9784]">Slip terkirim</span>
                                        <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-[5px] bg-[#e8eef4] text-[#6a8399]">
                                            <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <p class="mt-1 flex items-baseline gap-1 font-display text-[16px] font-extrabold leading-none tracking-[-0.04em] text-[#2c3a31]">
                                        11/11
                                    </p>
                                </div>
                            </div>

                            {{-- Mini Bar Chart Tren --}}
                            <div class="relative mt-2.5 rounded-[9px] border border-[#eef2e9] bg-white px-3 pb-2.5 pt-2.5">
                                <div class="flex items-center justify-between">
                                    <p class="text-[8.5px] font-medium text-[#7b8a75]">Tren penggajian</p>
                                    <div class="flex items-center gap-2.5 text-[7.5px] text-[#98a391]">
                                        <span class="inline-flex items-center gap-1">
                                            <i class="h-[5px] w-[5px] rounded-[2px] bg-forest"></i> 2026
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <i class="h-[5px] w-[5px] rounded-[2px] bg-[#d7e3cb]"></i> 2025
                                        </span>
                                    </div>
                                </div>

                                <div class="relative mt-2 h-[56px]">
                                    <div class="pointer-events-none absolute inset-x-0 top-0 bottom-[15px] flex flex-col justify-between">
                                        <i class="border-t border-dashed border-[#eef2e8]"></i>
                                        <i class="border-t border-dashed border-[#eef2e8]"></i>
                                        <i class="border-t border-dashed border-[#eef2e8]"></i>
                                    </div>
                                    <div class="relative flex h-full items-end justify-between gap-2">
                                        @php
                                            $chartBars = [
                                                ['month' => 'Jan', 'value' => 44],
                                                ['month' => 'Feb', 'value' => 58],
                                                ['month' => 'Mar', 'value' => 51],
                                                ['month' => 'Apr', 'value' => 69],
                                                ['month' => 'Mei', 'value' => 63],
                                                ['month' => 'Jun', 'value' => 82],
                                                ['month' => 'Jul', 'value' => 97],
                                            ];
                                        @endphp
                                        @foreach($chartBars as $index => $bar)
                                        @php $isCurrent = ($index === count($chartBars) - 1); @endphp
                                        <div class="flex h-full flex-1 flex-col items-center justify-end">
                                            <div class="flex w-full flex-1 items-end justify-center">
                                                <span 
                                                    style="height: {{ $bar['value'] }}%;" 
                                                    class="block w-full max-w-[15px] rounded-t-[3px] {{ $isCurrent ? 'bg-[linear-gradient(180deg,#3f7856,#2c5f44)]' : 'bg-[#d8e4cd]' }}"
                                                ></span>
                                            </div>
                                            <span class="mt-1.5 text-[7.5px] leading-none {{ $isCurrent ? 'font-semibold text-[#4d6c43]' : 'text-[#a3ac9d]' }}">
                                                {{ $bar['month'] }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Mini Bottom Completed Box --}}
                            <div class="relative mt-2.5 flex items-center justify-between gap-3 rounded-[9px] border border-[#eaf1e0] bg-[#f5f9ef] px-2.5 py-2">
                                <div class="flex min-w-0 items-center gap-2">
                                    <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-forest text-white">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate text-[9px] font-semibold text-[#455a3c]">Penggajian Juli selesai</p>
                                        <p class="mt-0.5 truncate text-[7.5px] text-[#8b9780]">11 dari 11 slip gaji terkirim</p>
                                    </div>
                                </div>
                                <span class="shrink-0 rounded-[5px] bg-white px-1.5 py-1 text-[8px] font-semibold text-[#5d7d4f] ring-1 ring-[#e4ecd9]">
                                    100%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Left Footer --}}
                <footer class="flex flex-wrap items-center justify-between gap-4 border-t border-[#d9e5ce] pt-4">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <span class="grid h-7 w-7 place-items-center rounded-full border-2 border-[#f3f7ed] text-[8px] font-semibold bg-[#e6edd9] text-[#5c7450]">AD</span>
                            <span class="grid h-7 w-7 place-items-center rounded-full border-2 border-[#f3f7ed] text-[8px] font-semibold bg-[#e3ebf0] text-[#5b7482]">RN</span>
                            <span class="grid h-7 w-7 place-items-center rounded-full border-2 border-[#f3f7ed] text-[8px] font-semibold bg-[#f1e8dc] text-[#8a7357]">SP</span>
                            <span class="grid h-7 w-7 place-items-center rounded-full border-2 border-[#f3f7ed] text-[8px] font-semibold bg-[#ece5ef] text-[#7a6782]">MK</span>
                            <span class="grid h-7 w-7 place-items-center rounded-full border-2 border-[#f3f7ed] bg-white text-[8px] font-semibold text-[#7c8b74] ring-1 ring-[#e3ebda]">+2k</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-0.5 text-[#8aa474]">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="h-2.5 w-2.5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @endfor
                            </div>
                            <p class="mt-1 text-[9.5px] leading-none text-[#7f8d79]">
                                <strong class="font-semibold text-[#536a4c]">2.400+ tim HR</strong> sudah beralih ke gajiku
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </section>

        {{-- ========================================================= --}}
        {{-- SISI KANAN: LOGIN CARD & FORM (PERSIS GAMBAR 3)           --}}
        {{-- ========================================================= --}}
        <section id="login" aria-label="Formulir masuk gajiku" class="auth-canvas relative flex min-h-screen flex-col overflow-hidden px-4 py-5 sm:px-6 sm:py-6 lg:px-8">
            {{-- Background ambient --}}
            <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                <div class="absolute -right-28 -top-24 h-72 w-72 rounded-full bg-[#e5efda]/80 blur-3xl"></div>
                <div class="dot-field absolute -bottom-8 right-0 h-56 w-56 opacity-50 [mask-image:radial-gradient(closest-side,black,transparent)]"></div>
                <span class="absolute left-[16%] top-[18%] h-1.5 w-1.5 rounded-full bg-[#c4d7b5]"></span>
                <span class="absolute bottom-[24%] left-[8%] h-1 w-1 rounded-full bg-[#c4d7b5]"></span>
            </div>

            {{-- Top Navbar Right --}}
            <header class="relative z-10 mx-auto flex w-full max-w-[420px] items-center justify-between gap-3">
                <span class="lg:hidden">
                    <div class="inline-flex select-none items-center gap-2 font-display text-[23px] font-extrabold leading-none tracking-[-0.055em] text-ink">
                        <span class="inline-flex -rotate-[9deg] items-end gap-[3px] leading-none">
                            <span class="w-[6px] h-[15px] rounded-[2px] bg-[#336b4b]"></span>
                            <span class="w-[6px] h-[22px] rounded-[2px] bg-[#5b8760]"></span>
                            <span class="w-[6px] h-[18px] rounded-[2px] bg-[#a3bd8b]"></span>
                        </span>
                        <span>gajiku<span class="text-forest">.</span></span>
                    </div>
                </span>
                <span class="hidden items-center gap-1.5 rounded-full border border-[#e3eadd] bg-white/60 px-3 py-1.5 text-[9.5px] font-medium text-[#7b8975] backdrop-blur lg:inline-flex">
                    <svg class="h-3.5 w-3.5 text-[#8da082]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Akses internal workspace
                </span>
            </header>

            {{-- Floating Center Card (Persis Gambar 3) --}}
            <div class="relative z-10 flex flex-1 items-center justify-center py-5 sm:py-6">
                <div class="auth-card-shadow w-full max-w-[420px] rounded-[24px] border border-[#e8eee2] bg-white p-5 sm:p-7">
                    {{-- Card Header --}}
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="brand-tile h-9 w-9 rounded-[10px] text-white">
                                <span class="inline-flex -rotate-[9deg] items-end gap-[2px] leading-none">
                                    <span class="w-[3px] h-[9px] rounded-[1px] bg-[#dce8d2]"></span>
                                    <span class="w-[3px] h-[15px] rounded-[1px] bg-[#f8fbf4]"></span>
                                    <span class="w-[3px] h-[12px] rounded-[1px] bg-[#a9c599]"></span>
                                </span>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[12.5px] font-semibold tracking-[-0.1px] text-ink">Sistem Penggajian</p>
                                <p class="mt-0.5 truncate text-[10.5px] text-[#8b968c]">PT. Sejahtera Bersama</p>
                            </div>
                        </div>
                        <span class="shrink-0 items-center gap-1.5 rounded-full border border-[#e2ebdb] bg-[#f7faf2] px-2.5 py-1 text-[8.5px] font-bold uppercase tracking-[0.12em] text-[#6d8463] inline-flex">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#779c69] opacity-60"></span>
                                <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-[#557d54]"></span>
                            </span>
                            Aman
                        </span>
                    </div>

                    <div class="my-5 h-px bg-[#edf2e8] sm:my-6"></div>

                    {{-- Greetings --}}
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-forest-600">
                            Selamat datang
                        </p>
                        <h1 class="mt-2 font-display text-[26px] font-extrabold leading-[1.15] tracking-[-0.04em] text-ink sm:text-[27px]">
                            Masuk ke akun Anda
                        </h1>
                        <p class="mt-2 text-[12px] leading-relaxed text-[#758276]">
                            Masuk untuk mengelola data penggajian karyawan.
                        </p>
                    </div>

                    {{-- Alert Login Error --}}
                    @if($errors->has('login'))
                    <div class="mt-4 flex items-start gap-2 rounded-xl border border-red-200 bg-red-50/80 p-3 text-xs text-red-800">
                        <svg class="w-4 h-4 text-red-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ $errors->first('login') }}</span>
                    </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('login.process') }}" method="POST" class="mt-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="login-email" class="mb-1.5 flex items-center justify-between text-[11px] font-semibold text-[#5c6d59]">
                                <span>Email</span>
                                <span class="text-[9px] font-normal text-[#a4aea3]">Email kantor</span>
                            </label>
                            <div class="group relative flex items-center rounded-[10px] border border-[#d6e0ce] bg-[#fbfdfa] transition-all focus-within:border-forest focus-within:bg-white focus-within:ring-2 focus-within:ring-forest/15">
                                <svg class="pointer-events-none absolute left-3.5 h-[16px] w-[16px] text-[#98a493] group-focus-within:text-forest-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                                <input 
                                    id="login-email" 
                                    name="email" 
                                    type="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus 
                                    placeholder="nama@sejahtera.co.id" 
                                    class="h-[46px] w-full rounded-[10px] bg-transparent pl-10 pr-3 text-[13px] text-ink placeholder:text-[#a6b0a6] outline-none"
                                >
                            </div>
                        </div>

                        {{-- Kata Sandi --}}
                        <div class="mt-3.5">
                            <label for="login-password" class="mb-1.5 block text-[11px] font-semibold text-[#5c6d59]">
                                Kata sandi
                            </label>
                            <div class="group relative flex items-center rounded-[10px] border border-[#d6e0ce] bg-[#fbfdfa] transition-all focus-within:border-forest focus-within:bg-white focus-within:ring-2 focus-within:ring-forest/15">
                                <svg class="pointer-events-none absolute left-3.5 h-[16px] w-[16px] text-[#98a493] group-focus-within:text-forest-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input 
                                    id="login-password" 
                                    name="password" 
                                    type="password" 
                                    required 
                                    placeholder="Masukkan kata sandi" 
                                    class="h-[46px] w-full rounded-[10px] bg-transparent pl-10 pr-11 text-[13px] text-ink placeholder:text-[#a6b0a6] outline-none"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility()" 
                                    class="absolute right-1.5 grid h-8 w-8 place-items-center rounded-md text-[#97a292] transition hover:bg-[#f1f5ec] hover:text-forest-600"
                                    aria-label="Tampilkan kata sandi"
                                >
                                    <svg id="eye-icon" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Options Row --}}
                        <div class="mt-3.5 flex items-center justify-between gap-3">
                            <label class="group flex cursor-pointer select-none items-center gap-2 text-[11px] text-[#6b7a69]">
                                <input 
                                    type="checkbox" 
                                    name="remember" 
                                    id="remember" 
                                    class="h-4 w-4 rounded-[4px] border-[#d3ddcc] text-forest focus:ring-forest/20"
                                >
                                <span>Ingat saya</span>
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <button 
                            type="submit" 
                            class="group relative mt-4 flex h-[46px] w-full items-center justify-center gap-2 overflow-hidden rounded-[10px] bg-[linear-gradient(135deg,#3a7456_0%,#2f674a_60%,#2a5d43_100%)] text-[12px] font-semibold text-white shadow-[0_10px_24px_-12px_rgba(38,84,60,0.85)] transition hover:shadow-[0_14px_28px_-12px_rgba(38,84,60,0.95)] hover:brightness-[1.04]"
                        >
                            <span>Masuk ke sistem</span>
                            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </form>

                    {{-- Demo Account Box --}}
                    <div class="mt-4 rounded-[10px] border border-dashed border-[#d9e5cf] bg-[#f7faf3] p-2.5">
                        <div class="flex items-center gap-2.5">
                            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg border border-[#e5ecdc] bg-white text-forest-600">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-semibold text-[#54684d]">Coba dengan akun demo</p>
                                <p class="mt-0.5 truncate text-[9.5px] text-[#8b967f]">
                                    admin@sejahtera.co.id <span class="text-[#b3bcab]">·</span> gajiku2026
                                </p>
                            </div>
                            <button 
                                type="button" 
                                onclick="fillDemoCredentials()" 
                                class="shrink-0 rounded-md border border-[#dde8d4] bg-white px-2 py-1.5 text-[9.5px] font-semibold text-[#5a7a4d] shadow-[0_1px_1px_rgba(35,70,49,0.03)] transition hover:border-[#c9dabb] hover:bg-[#f1f7ea]"
                            >
                                Isi otomatis
                            </button>
                        </div>
                    </div>

                    {{-- Encrypted Subtext --}}
                    <p class="mt-4 flex items-center justify-center gap-1.5 text-center text-[10px] text-[#87948a]">
                        <svg class="h-3.5 w-3.5 text-[#a3b09c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Koneksi aman & terenkripsi. Data Anda terlindungi.
                    </p>
                </div>
            </div>

            {{-- Right Bottom Footer --}}
            <footer class="relative z-10 mx-auto flex w-full max-w-[420px] flex-col items-center justify-between gap-2 text-[10px] text-[#7d8b80] sm:flex-row sm:gap-3">
                <p class="flex items-center gap-1">
                    <span>© 2026 gajiku.</span>
                    <span class="px-0.5 text-[#c3cbc1]">·</span>
                    <span class="text-ink font-medium">Privasi</span>
                    <span class="px-0.5 text-[#c3cbc1]">·</span>
                    <span class="text-ink font-medium">Ketentuan</span>
                </p>
                <p class="inline-flex items-center gap-1.5">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#779c69] opacity-50"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-[#6d9563]"></span>
                    </span>
                    Semua sistem normal
                    <svg class="ml-0.5 h-3 w-3 text-[#a3b09c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </p>
            </footer>
        </section>

    </main>
</div>

<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('login-password');
        const eyeIcon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }

    function fillDemoCredentials() {
        document.getElementById('login-email').value = 'admin@sejahtera.co.id';
        document.getElementById('login-password').value = 'gajiku2026';
    }
</script>
@endsection
