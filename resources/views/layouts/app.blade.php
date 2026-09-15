<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistem Penggajian')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ocean: '#0F172A',
                        'ocean-lt': '#1E293B',
                        teal: '#14B8A6',
                        sand: '#F8FAFC',
                    }
                }
            }
        }
    </script>

</head>

<body class="bg-slate-100 min-h-screen">

<div class="flex">

    {{-- ========================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================= --}}
    <aside class="w-72 min-h-screen bg-ocean text-white flex flex-col">

        {{-- Logo --}}
        <div class="p-6 border-b border-white/10">

            <h1 class="text-2xl font-bold">
                💰 Sistem Gaji
            </h1>

            <p class="text-slate-300 text-sm mt-1">
                PT. Sejahtera Bersama
            </p>

        </div>

        {{-- User Login --}}
        <div class="p-6">

            <div class="bg-white/10 rounded-2xl p-4">

                <p class="text-xs text-slate-300">
                    Login Sebagai
                </p>

                <p class="font-semibold text-lg mt-1">
                    {{ auth()->user()->name }}
                </p>

                <span class="inline-block mt-3 px-3 py-1 rounded-full bg-teal text-xs font-semibold">
                    {{ ucfirst(auth()->user()->role) }}
                </span>

            </div>

        </div>

        {{-- Menu --}}
        <nav class="flex-1 px-6 space-y-2">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-xl transition
               {{ request()->routeIs('dashboard')
                    ? 'bg-teal text-white'
                    : 'hover:bg-white/10' }}">

                🏠 Dashboard

            </a>

            @if(auth()->user()->role == 'admin')

                <a href="{{ route('karyawan.index') }}"
                   class="block px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('karyawan.*')
                        ? 'bg-teal text-white'
                        : 'hover:bg-white/10' }}">

                    👨‍💼 Data Karyawan

                </a>

                <a href="{{ route('jabatan.index') }}"
                   class="block px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('jabatan.*')
                        ? 'bg-teal text-white'
                        : 'hover:bg-white/10' }}">

                    🏢 Data Jabatan

                </a>

                <a href="{{ route('penggajian.index') }}"
                   class="block px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('penggajian.*')
                        ? 'bg-teal text-white'
                        : 'hover:bg-white/10' }}">

                    💰 Penggajian

                </a>

            @endif

            <a href="{{ route('slip-gaji.index') }}"
               class="block px-4 py-3 rounded-xl transition
               {{ request()->routeIs('slip-gaji.*')
                    ? 'bg-teal text-white'
                    : 'hover:bg-white/10' }}">

                📄 Slip Gaji

            </a>

            <a href="{{ route('laporan.index') }}"
               class="block px-4 py-3 rounded-xl transition
               {{ request()->routeIs('laporan.*')
                    ? 'bg-teal text-white'
                    : 'hover:bg-white/10' }}">

                📊 Laporan

            </a>

        </nav>

        {{-- Logout --}}
        <div class="p-6">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button
                    type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 py-3 rounded-xl font-semibold transition">

                    🚪 Logout

                </button>

            </form>

        </div>

        {{-- Footer --}}
        <div class="text-center text-xs text-slate-400 p-5 border-t border-white/10">

            © {{ date('Y') }} PT. Sejahtera Bersama

        </div>

    </aside>

    {{-- ========================= --}}
    {{-- CONTENT --}}
    {{-- ========================= --}}
    <main class="flex-1 p-8">

        @yield('content')

    </main>

</div>

</body>
</html>