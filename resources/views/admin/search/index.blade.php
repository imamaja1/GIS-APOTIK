@extends('layouts.admin')

@section('title', 'Search Apotik Admin')

@section('content')
<div class="space-y-4">

    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <div>
            <h1 class="text-base font-semibold text-gray-800">Search Apotik</h1>
            <p class="text-xs text-gray-400 mt-0.5">Temukan apotek dari titik awal menuju titik tujuan.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Tempat Awal</label>
                <select id="tempat-awal" class="w-full text-sm">
                    <option value="">Pilih titik awal...</option>
                    <option value="gps">Gunakan GPS (Lokasi Saya)</option>
                    @foreach ($jalanList as $jalan)
                    <option value="{{ $jalan->id }}" data-lat="{{ $jalan->latitude_center }}"
                        data-lng="{{ $jalan->longitude_center }}">
                        {{ $jalan->nama_jalan }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Tempat Tujuan</label>
                <select id="tempat-tujuan" class="w-full text-sm">
                    <option value="">Cari nama apotek...</option>
                </select>
            </div>
        </div>

        <div id="info-apotek"
            class="hidden mt-4 p-3 bg-green-50 border border-green-100 rounded-lg text-sm text-green-800"></div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75L3.75 5.25v12L9 18.75m0-12l6 1.5m-6-1.5v12m6-10.5l5.25-1.5v12L15 20.25m0-12v12" />
            </svg>
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Peta Rute</h2>
        </div>
        @include('partials.leaflet-map', ['mapId' => 'admin-search-map', 'height' => '560px'])
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

    var searchMap    = initBaseMap('admin-search-map');
    var markerAwal   = null;
    var markerTujuan = null;
    var routeLine    = null;

    $('#tempat-awal').select2({
        placeholder: 'Pilih titik awal...',
        allowClear: true,
        width: '100%',
        language: { noResults: function () { return 'Tidak ditemukan.'; } },
    });

    $('#tempat-awal').on('change', function () {
        var val = $(this).val();
        var selected = $(this).find(':selected');

        if (markerAwal) { markerAwal.remove(); markerAwal = null; }
        gambarGaris();

        if (val === 'gps') {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        var lat = pos.coords.latitude;
                        var lng = pos.coords.longitude;
                        markerAwal = L.marker([lat, lng], { icon: createMapIcon('blue') })
                            .bindPopup('<strong>Lokasi Saya</strong>').addTo(searchMap).openPopup();
                        searchMap.setView([lat, lng], 14);
                        gambarGaris();
                    },
                    function () {
                        alert('Tidak dapat mengakses GPS. Pastikan izin lokasi diaktifkan.');
                        $('#tempat-awal').val(null).trigger('change');
                    }
                );
            } else {
                alert('Browser Anda tidak mendukung GPS.');
                $('#tempat-awal').val(null).trigger('change');
            }
        } else if (val) {
            var lat = parseFloat(selected.data('lat'));
            var lng = parseFloat(selected.data('lng'));
            if (lat && lng) {
                markerAwal = L.marker([lat, lng], { icon: createMapIcon('blue') })
                    .bindPopup('<strong>' + selected.text() + '</strong>').addTo(searchMap);
                searchMap.setView([lat, lng], 14);
                gambarGaris();
            }
        }
    });

    $('#tempat-tujuan').select2({
        placeholder: 'Cari nama apotek...',
        allowClear: true,
        minimumInputLength: 2,
        width: '100%',
        ajax: {
            url: '{{ route("admin.apotek.search-json") }}',
            dataType: 'json',
            delay: 300,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            data: function (params) { return { q: params.term }; },
            processResults: function (data) { return { results: data.results }; },
            cache: true,
        },
        language: {
            inputTooShort: function () { return 'Ketik minimal 2 karakter...'; },
            searching: function () { return 'Mencari...'; },
            noResults: function () { return 'Apotik tidak ditemukan.'; },
        },
    });

    $('#tempat-tujuan').on('select2:select', function (e) {
        var data = e.params.data;
        var lat  = parseFloat(data.lat);
        var lng  = parseFloat(data.lng);

        if (markerTujuan) { markerTujuan.remove(); markerTujuan = null; }

        if (lat && lng) {
            markerTujuan = L.marker([lat, lng], { icon: createMapIcon('green') })
                .bindPopup('<strong>' + data.text + '</strong>')
                .addTo(searchMap).openPopup();
            searchMap.setView([lat, lng], 15);
            gambarGaris();
        }

        var infoEl = document.getElementById('info-apotek');
        infoEl.innerHTML = '<strong>' + data.text + '</strong>';
        infoEl.classList.remove('hidden');
    });

    $('#tempat-tujuan').on('select2:clear', function () {
        if (markerTujuan) { markerTujuan.remove(); markerTujuan = null; }
        gambarGaris();
        document.getElementById('info-apotek').classList.add('hidden');
    });

    function gambarGaris() {
        if (routeLine) { routeLine.remove(); routeLine = null; }

        if (markerAwal && markerTujuan) {
            var a = markerAwal.getLatLng();
            var t = markerTujuan.getLatLng();

            routeLine = L.polyline([a, t], {
                color: '#16a34a',
                weight: 3,
                dashArray: '8, 12',
                opacity: 0.8,
            }).addTo(searchMap);

            searchMap.fitBounds(routeLine.getBounds(), { padding: [50, 50] });
        }
    }

});
</script>
@endpush