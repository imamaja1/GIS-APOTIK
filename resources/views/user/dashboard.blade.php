@extends('layouts.user')

@section('title', 'Dashboard — GIS Apotek KLU')

@section('content')

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
        </div>
        <div>
            <h1 class="text-base font-semibold text-gray-800">Dashboard</h1>
            <p class="text-xs text-gray-400 mt-0.5">Ringkasan data apotek di Kabupaten Lombok Utara.</p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['total_kecamatan'] }}</div>
            <div class="text-xs text-gray-400 font-medium uppercase tracking-wide mt-1">Kecamatan KLU</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['total_apotek'] }}</div>
            <div class="text-xs text-gray-400 font-medium uppercase tracking-wide mt-1">Total Apotek</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['apotek_buka'] }}</div>
            <div class="text-xs text-gray-400 font-medium uppercase tracking-wide mt-1">Apotek Buka</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center">
            <div class="text-3xl font-bold text-red-500">{{ $stats['apotek_tutup'] }}</div>
            <div class="text-xs text-gray-400 font-medium uppercase tracking-wide mt-1">Apotek Tutup</div>
        </div>

    </div>

    {{-- Peta --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Peta KLU dan Apotek</h2>
        </div>
        @include('partials.leaflet-map', ['mapId' => 'dashboard-map', 'height' => '500px'])
    </div>

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
