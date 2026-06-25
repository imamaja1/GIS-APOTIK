@extends('layouts.admin')

@section('title', 'Peta Apotek Admin')

@section('content')
<div class="space-y-4">

    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75L3.75 5.25v12L9 18.75m0-12l6 1.5m-6-1.5v12m6-10.5l5.25-1.5v12L15 20.25m0-12v12" />
            </svg>
        </div>
        <div>
            <h1 class="text-base font-semibold text-gray-800">Peta Apotik</h1>
            <p class="text-xs text-gray-400 mt-0.5">Sebaran lokasi apotek di Kabupaten Lombok Utara.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
            </svg>
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Sebaran Lokasi</h2>
        </div>
        @include('partials.leaflet-map', ['mapId' => 'admin-map-apotek', 'height' => '560px'])
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dataMapApotek = @json($apotekMap);
        const mapApotek = initBaseMap('admin-map-apotek', {
            center: window.KLU_CENTER,
            zoom: 11,
        });

        dataMapApotek.forEach(function (a) {
            if (!a.latitude || !a.longitude) return;

            L.marker([a.latitude, a.longitude], { icon: createMapIcon('green') })
                .addTo(mapApotek)
                .bindPopup(
                    '<div class="text-sm leading-5">' +
                        '<b>' + (a.nama_apotek || '-') + '</b>' +
                        (a.kecamatan ? '<br><span class="text-xs text-gray-500">' + a.kecamatan.nama_kecamatan + '</span>' : '') +
                    '</div>'
                );
        });
</script>
@endpush