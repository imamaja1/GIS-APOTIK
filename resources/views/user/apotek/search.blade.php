@extends('layouts.user')

@section('title', 'Search Apotik — GIS Apotik KLU')

@section('content')

<div class="max-w-7xl mx-auto px-4 lg:px-8 py-6">
    <div class="mb-5">
        <h1 class="text-lg font-semibold text-gray-800">Search Apotik</h1>
        <p class="text-sm text-gray-400 mt-0.5">Temukan apotek dari titik awal menuju tujuan.</p>
    </div>

    {{-- Form Pencarian --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Tempat Awal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Awal</label>
                <select id="tempat-awal" class="w-full text-sm">
                    <option value="">Pilih titik awal...</option>
                    <option value="gps">Gunakan GPS (Lokasi Saya)</option>
                    @foreach ($jalanList as $jalan)
                        <option
                            value="{{ $jalan->id }}"
                            data-lat="{{ $jalan->latitude_center }}"
                            data-lng="{{ $jalan->longitude_center }}">
                            {{ $jalan->nama_jalan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tempat Tujuan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Tujuan</label>
                <select id="tempat-tujuan" class="w-full text-sm">
                    <option value="">Cari nama apotek...</option>
                </select>
            </div>

        </div>

        {{-- Info Apotik Terpilih --}}
        <div id="info-apotek" class="hidden mt-4 p-3 bg-green-50 border border-green-100 rounded-lg text-sm text-green-800">
            <div id="info-apotek-text"></div>
            <div id="route-info" class="hidden text-xs text-gray-600 mt-1.5">
                <span id="route-distance"></span>
                <span id="route-duration" class="ml-3"></span>
            </div>
            <a id="btn-gmaps" href="#" target="_blank"
               class="hidden inline-flex items-center gap-1.5 mt-2 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition cursor-pointer w-fit">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                Buka Rute di Google Maps
            </a>
        </div>
    </div>

    {{-- Peta --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        @include('partials.leaflet-map', ['mapId' => 'search-map', 'height' => '480px'])
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    var searchMap    = initBaseMap('search-map');
    var markerAwal   = null;
    var markerTujuan = null;
    var routeLine    = null;
    var originLat    = null;
    var originLng    = null;
    var destLat      = null;
    var destLng      = null;
    var routeAbort   = null;

    // ================================================
    // Select2: Tempat Awal (data statis dari server)
    // ================================================
    $('#tempat-awal').select2({
        placeholder: 'Pilih titik awal...',
        allowClear: true,
        width: '100%',
        language: { noResults: function () { return 'Tidak ditemukan.'; } },
    });

    $('#tempat-awal').on('change', function () {
        var val      = $(this).val();
        var selected = $(this).find(':selected');

        if (markerAwal) { markerAwal.remove(); markerAwal = null; }
        originLat = null;
        originLng = null;
        gambarGaris();
        updateGmapsButton();

        if (val === 'gps') {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        var lat = pos.coords.latitude;
                        var lng = pos.coords.longitude;
                        originLat = lat;
                        originLng = lng;
                        markerAwal = L.marker([lat, lng], { icon: createMapIcon('blue') })
                            .bindPopup('<strong>Lokasi Saya</strong>').addTo(searchMap).openPopup();
                        searchMap.setView([lat, lng], 14);
                        gambarGaris();
                        updateGmapsButton();
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
                originLat = lat;
                originLng = lng;
                markerAwal = L.marker([lat, lng], { icon: createMapIcon('blue') })
                    .bindPopup('<strong>' + selected.text() + '</strong>').addTo(searchMap);
                searchMap.setView([lat, lng], 14);
                gambarGaris();
                updateGmapsButton();
            }
        }
    });

    // ================================================
    // Select2: Tempat Tujuan (AJAX search apotek)
    // ================================================
    $('#tempat-tujuan').select2({
        placeholder: 'Cari nama apotek...',
        allowClear: true,
        minimumInputLength: 2,
        width: '100%',
        ajax: {
            url: '{{ route("user.apotek.search-json") }}',
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
            searching:     function () { return 'Mencari...'; },
            noResults:     function () { return 'Apotik tidak ditemukan.'; },
        },
    });

    $('#tempat-tujuan').on('select2:select', function (e) {
        var data = e.params.data;
        var lat  = parseFloat(data.lat);
        var lng  = parseFloat(data.lng);

        if (markerTujuan) { markerTujuan.remove(); markerTujuan = null; }
        destLat = null;
        destLng = null;

        if (lat && lng) {
            destLat = lat;
            destLng = lng;
            markerTujuan = L.marker([lat, lng], { icon: createMapIcon('green') })
                .bindPopup('<strong>' + data.text + '</strong>')
                .addTo(searchMap).openPopup();
            searchMap.setView([lat, lng], 15);
            gambarGaris();
        }

        var infoEl = document.getElementById('info-apotek');
        document.getElementById('info-apotek-text').innerHTML = '<strong>' + data.text + '</strong>';
        infoEl.classList.remove('hidden');
        updateGmapsButton();
    });

    $('#tempat-tujuan').on('select2:clear', function () {
        if (markerTujuan) { markerTujuan.remove(); markerTujuan = null; }
        destLat = null;
        destLng = null;
        gambarGaris();
        document.getElementById('info-apotek').classList.add('hidden');
        updateGmapsButton();
    });

    // ================================================
    // Tombol Buka Rute di Google Maps
    // ================================================
    function updateGmapsButton() {
        var btn = document.getElementById('btn-gmaps');
        if (originLat !== null && originLng !== null && destLat !== null && destLng !== null) {
            btn.href = 'https://www.google.com/maps/dir/?api=1&origin=' + originLat + ',' + originLng + '&destination=' + destLat + ',' + destLng;
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    }

    // ================================================
    // Gambar rute via OSRM (fallback garis lurus)
    // ================================================
    function gambarGaris() {
        if (routeLine) { routeLine.remove(); routeLine = null; }
        if (routeAbort) { routeAbort.abort(); routeAbort = null; }

        var routeInfo = document.getElementById('route-info');
        routeInfo.classList.add('hidden');

        if (!markerAwal || !markerTujuan) return;

        if (originLat === null || originLng === null || destLat === null || destLng === null) {
            gambarGarisLurus();
            return;
        }

        routeInfo.classList.remove('hidden');
        document.getElementById('route-distance').textContent = 'Mencari rute...';
        document.getElementById('route-duration').textContent = '';

        routeAbort = new AbortController();
        var url = 'https://router.project-osrm.org/route/v1/driving/'
            + originLng + ',' + originLat + ';'
            + destLng + ',' + destLat
            + '?geometries=geojson&overview=full';

        var timeoutId = setTimeout(function () { routeAbort.abort(); }, 10000);

        fetch(url, { signal: routeAbort.signal })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                clearTimeout(timeoutId);
                if (data.code !== 'Ok' || !data.routes || !data.routes[0]) {
                    throw new Error('Rute tidak ditemukan');
                }
                var route = data.routes[0];
                var coords = route.geometry.coordinates.map(function (c) { return [c[1], c[0]]; });

                routeLine = L.polyline(coords, {
                    color: '#16a34a',
                    weight: 4,
                    opacity: 0.85
                }).addTo(searchMap);

                searchMap.fitBounds(routeLine.getBounds(), { padding: [50, 50] });

                var km = (route.distance / 1000).toFixed(1);
                var menit = Math.round(route.duration / 60);
                document.getElementById('route-distance').textContent = 'Jarak: ' + km + ' km';
                document.getElementById('route-duration').textContent = 'Estimasi: ' + menit + ' menit';
            })
            .catch(function (err) {
                clearTimeout(timeoutId);
                if (err.name === 'AbortError') {
                    document.getElementById('route-distance').textContent = 'Waktu habis.';
                } else {
                    document.getElementById('route-distance').textContent = 'Rute offline.';
                }
                document.getElementById('route-duration').textContent = '';
                gambarGarisLurus();
            });
    }

    function gambarGarisLurus() {
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

});
</script>
@endpush
