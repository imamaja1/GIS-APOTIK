{{--
    Partial: Kontainer peta Leaflet yang dapat digunakan ulang.

    Cara pakai:
        @include('partials.leaflet-map', [
            'mapId'  => 'my-map',      -- wajib, unik per halaman
            'height' => '400px',       -- opsional, default 400px
        ])

    Kemudian inisialisasi peta di @push('scripts') menggunakan initBaseMap(mapId).
--}}
<div
    id="{{ $mapId ?? 'map' }}"
    class="w-full"
    style="height: {{ $height ?? '400px' }};"
></div>
