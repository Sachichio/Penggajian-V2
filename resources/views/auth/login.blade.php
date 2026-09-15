@extends('layouts.guest')

@section('title', 'Login — Sistem Penggajian')

@section('content')

<div class="bg-white rounded-3xl shadow-2xl p-10 sm:p-12">

    {{-- Brand --}}
    <div class="flex items-center gap-4 mb-8">

        <div class="w-14 h-14 rounded-2xl
                    bg-gradient-to-br from-cyan-600 to-blue-700
                    flex items-center justify-center
                    text-white text-2xl shrink-0">

            <i class="fas fa-wallet"></i>

        </div>

        <div>

            <h1 class="font-heading font-bold text-slate-800 text-lg">

                Sistem Penggajian

            </h1>

            <p class="text-slate-400 text-xs mt-1">

                PT. Sejahtera Bersama

            </p>

        </div>

    </div>

    {{-- Judul --}}
    <h2 class="font-heading font-bold text-slate-800 text-2xl mb-2">

        Selamat Datang

    </h2>

    <p class="text-slate-400 text-sm mb-8">

        Masuk untuk mengelola data penggajian karyawan

    </p>

    @if($errors->has('login'))

    <div
        class="mb-6 flex items-start gap-3
            rounded-xl
            border border-red-200
            bg-red-50
            px-4 py-3">

        <i class="fas fa-circle-xmark text-red-500 mt-1"></i>

        <div>

            <p class="font-semibold text-red-700">

                Login Gagal

            </p>

            <p class="text-sm text-red-600">

                {{ $errors->first('login') }}

            </p>

        </div>

    </div>

    @endif

    @if($errors->any() && !$errors->has('login'))

    <div
        class="mb-6 flex items-start gap-3
            rounded-xl
            border border-yellow-200
            bg-yellow-50
            px-4 py-3">

        <i class="fas fa-triangle-exclamation text-yellow-500 mt-1"></i>

        <div>

            <p class="font-semibold text-yellow-700">

                Periksa kembali data Anda

            </p>

            <ul class="text-sm text-yellow-700 list-disc list-inside mt-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    </div>

    @endif

    <form action="{{ route('login.process') }}"
          method="POST">

        @csrf

        {{-- Email --}}
        <div class="mb-5">

            <label
                class="block text-sm font-semibold text-slate-600 mb-2">

                Email

            </label>

            <div class="relative">

                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">

                    <i class="fas fa-envelope"></i>

                </span>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    class="w-full pl-10 pr-4 py-3 rounded-xl
                           border-2 border-slate-200 bg-slate-50
                           focus:outline-none
                           focus:border-cyan-500
                           focus:bg-white">

            </div>

        </div>

        {{-- Password --}}
        <div class="mb-8">

            <label
                class="block text-sm font-semibold text-slate-600 mb-2">

                Password

            </label>

            <div class="relative">

                <span
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">

                    <i class="fas fa-lock"></i>

                </span>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    class="w-full pl-10 pr-12 py-3 rounded-xl
                        border-2 border-slate-200 bg-slate-50
                        focus:outline-none
                        focus:border-cyan-500
                        focus:bg-white">

                <button
                    type="button"
                    id="togglePassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2
                        text-slate-400 hover:text-cyan-600 transition">

                    <i
                        id="eyeIcon"
                        class="fas fa-eye">

                    </i>

                </button>

            </div>

        </div>

        {{-- Button --}}
        <button
            type="submit"
            class="w-full py-3.5 rounded-xl
                   font-semibold text-white
                   bg-gradient-to-r
                   from-cyan-600
                   to-blue-700
                   hover:from-cyan-700
                   hover:to-blue-800
                   transition">

            <i class="fas fa-right-to-bracket mr-2"></i>

            Masuk ke Sistem

        </button>

    </form>

</div>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');

    const toggle = document.getElementById('togglePassword');

    const icon = document.getElementById('eyeIcon');

    toggle.addEventListener('click', function () {

        if (password.type === 'password') {

            password.type = 'text';

            icon.classList.remove('fa-eye');

            icon.classList.add('fa-eye-slash');

        } else {

            password.type = 'password';

            icon.classList.remove('fa-eye-slash');

            icon.classList.add('fa-eye');

        }

    });

});

</script>

@endpush

@endsection