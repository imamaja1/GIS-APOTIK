@extends('layouts.user')

@section('title', 'GIS Apotik Kabupaten Lombok Utara')

@section('content')

    {{-- ====================================================================== --}}
    {{-- SECTION 1: HERO                                                       --}}
    {{-- ====================================================================== --}}
    <section id="hero" class="relative overflow-hidden bg-cover bg-center bg-no-repeat min-h-[500px] lg:min-h-[600px] flex items-center" style="background-image: url('{{ asset('home.jpg') }}');">
        {{-- Overlay transparan --}}
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative w-full max-w-7xl mx-auto px-4 lg:px-8 py-16 lg:py-24">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h1 class="text-3xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight drop-shadow-lg">
                    SIG Apotik<br>Kabupaten Lombok Utara
                </h1>
                <p class="text-sm lg:text-base text-white/90 mt-4 max-w-xl mx-auto leading-relaxed drop-shadow">
                    Sistem Informasi Geografis penyebaran apotek di Kabupaten Lombok Utara.
                    Temukan lokasi apotek terdekat beserta informasi jam operasional dan kontak.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-8">
                    <a href="{{ route('user.data-apotek') }}"
                        class="w-full sm:w-auto px-8 py-3 bg-white text-green-700 hover:bg-green-50 text-sm font-semibold rounded-lg shadow-lg transition cursor-pointer">
                        Data Apotik
                    </a>
                    <a href="{{ route('user.search-apotek') }}"
                        class="w-full sm:w-auto px-8 py-3 bg-white text-green-700 hover:bg-green-50 text-sm font-semibold rounded-lg shadow-lg transition cursor-pointer">
                        Search Apotik
                    </a>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <div class="bg-black/20 backdrop-blur-sm rounded-xl p-5 lg:p-6 text-center border border-white/20">
                    <div class="flex justify-center mb-3">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <div class="text-3xl lg:text-4xl font-bold text-white drop-shadow">{{ $stats['total_kecamatan'] }}</div>
                    <div class="text-xs text-white/80 font-medium uppercase tracking-wide mt-2">Kecamatan KLU</div>
                </div>
                <div class="bg-black/20 backdrop-blur-sm rounded-xl p-5 lg:p-6 text-center border border-white/20">
                    <div class="flex justify-center mb-3">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <div class="text-3xl lg:text-4xl font-bold text-white drop-shadow">{{ $stats['total_apotek'] }}</div>
                    <div class="text-xs text-white/80 font-medium uppercase tracking-wide mt-2">Total Apotik</div>
                </div>
                <div class="bg-black/20 backdrop-blur-sm rounded-xl p-5 lg:p-6 text-center border border-white/20">
                    <div class="flex justify-center mb-3">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-3xl lg:text-4xl font-bold text-white drop-shadow">{{ $stats['apotek_buka'] }}</div>
                    <div class="text-xs text-white/80 font-medium uppercase tracking-wide mt-2">Apotik Buka</div>
                </div>
                <div class="bg-black/20 backdrop-blur-sm rounded-xl p-5 lg:p-6 text-center border border-white/20">
                    <div class="flex justify-center mb-3">
                        <svg class="w-7 h-7 text-red-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div class="text-3xl lg:text-4xl font-bold text-red-300 drop-shadow">{{ $stats['apotek_tutup'] }}</div>
                    <div class="text-xs text-white/80 font-medium uppercase tracking-wide mt-2">Apotik Tutup</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ====================================================================== --}}
    {{-- SECTION 2: TENTANG                                                    --}}
    {{-- ====================================================================== --}}
    <section id="tentang" class="py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                {{-- Kiri: Teks --}}
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-1.5 h-10 bg-green-600 rounded-full"></div>
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Tentang</h2>
                    </div>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Sistem Informasi Geografis (SIG) Apotik Kabupaten Lombok Utara adalah aplikasi yang menyediakan informasi
                        lokasi penyebaran apotek di wilayah Kabupaten Lombok Utara. Aplikasi ini membantu masyarakat menemukan
                        apotek terdekat beserta informasi jam operasional, alamat, dan kontak yang dapat dihubungi.
                        Dengan integrasi peta interaktif, pengguna dapat dengan mudah melihat sebaran apotek di setiap kecamatan
                        dan merencanakan rute perjalanan menuju apotek yang dituju.
                    </p>
                </div>
                {{-- Kanan: Gambar --}}
                <div class="hidden md:block">
                    <img src="{{ asset('apotik.jpg') }}" alt="GIS Apotik"
                        class="w-full h-auto rounded-xl shadow-md object-cover max-h-80">
                </div>
            </div>
        </div>
    </section>

    {{-- ====================================================================== --}}
    {{-- SECTION 3: PETA APOTEK                                                --}}
    {{-- ====================================================================== --}}
    <section id="peta-apotek" class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-10 bg-green-600 rounded-full"></div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Peta Apotik</h2>
            </div>
            <p class="text-sm text-gray-500 mb-8">Sebaran lokasi apotek di Kabupaten Lombok Utara.</p>
            <div class="rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @include('partials.leaflet-map', ['mapId' => 'dashboard-map', 'height' => '550px'])
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    var map = initBaseMap('dashboard-map');
    var apotekData = @json($apotekMap);

    apotekData.forEach(function (a) {
        var lat = parseFloat(a.latitude);
        var lng = parseFloat(a.longitude);
        if (!lat || !lng) return;

        L.marker([lat, lng], { icon: createMapIcon('green') })
            .bindPopup(
                '<strong class="text-sm">' + a.nama_apotek + '</strong>' +
                (a.kecamatan ? '<br><span class="text-xs text-gray-500">' + a.kecamatan.nama_kecamatan + '</span>' : '') +
                '<br><span class="text-xs">' + (a.alamat_lengkap || '') + '</span>' +
                (a.no_telp ? '<br><span class="text-xs">' + a.no_telp + '</span>' : '')
            )
            .addTo(map);
    });

});
</script>
@endpush
