<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GIS Apotik KLU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-gray-50">

    {{-- Kiri: Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">
            @yield('form')
        </div>
    </div>

    {{-- Kanan: Dekoratif --}}
    <div class="hidden lg:flex lg:w-1/2 flex-col items-center justify-center bg-green-600 p-12">
        <svg class="w-20 h-20 text-green-200 mb-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
        <h2 class="text-3xl font-bold text-white mb-2 text-center">GIS Apotik KLU</h2>
        <p class="text-green-100 text-base text-center">Sistem Informasi Geografis</p>
        <p class="text-green-200 text-sm text-center mt-1">Apotik Kabupaten Lombok Utara</p>
    </div>

</body>
</html>
