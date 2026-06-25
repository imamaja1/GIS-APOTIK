@extends('layouts.user')

@section('title', 'Dashboard — GIS Apotek KLU')

@section('content')

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
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
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
