@extends('layouts.auth')

@section('title', 'Login — GIS Apotek KLU')

@section('form')
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5V6.75A2.25 2.25 0 0017.25 4.5H6.75A2.25 2.25 0 004.5 6.75v10.5A2.25 2.25 0 006.75 19.5h10.5a2.25 2.25 0 002.25-2.25V13.5" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 9h.008v.008H15V9zM4.5 16.5l4.8-4.8a1.5 1.5 0 012.12 0l2.58 2.58a1.5 1.5 0 002.12 0l3.38-3.38" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Login</h1>
                <p class="text-gray-500 text-sm">SIG Penyebaran Apotek KLU</p>
            </div>
        </div>
    </div>

    {{-- Error umum --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1.5 cursor-pointer" for="email">
                Email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                autocomplete="email"
                class="w-full px-4 py-2.5 border rounded-lg text-sm transition
                       focus:outline-none focus:ring-1
                       {{ $errors->has('email') ? 'border-red-400 focus:border-red-400 focus:ring-red-300' : 'border-gray-300 focus:border-green-500 focus:ring-green-400' }}"
            >
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1.5 cursor-pointer" for="password">
                Password
            </label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                class="w-full px-4 py-2.5 border rounded-lg text-sm transition
                       focus:outline-none focus:ring-1
                       {{ $errors->has('password') ? 'border-red-400 focus:border-red-400 focus:ring-red-300' : 'border-gray-300 focus:border-green-500 focus:ring-green-400' }}"
            >
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('register') }}"
               class="text-sm text-green-600 hover:text-green-700 hover:underline">
                Registrasi
            </a>
            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-8 py-2.5 rounded-lg text-sm font-medium transition cursor-pointer">
                Submit
            </button>
        </div>
    </form>
@endsection
