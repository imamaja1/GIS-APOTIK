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

    var searchMap   = initBaseMap('search-map');
    var markerAwal  = null;
    var markerTujuan = null;
    var routeLine   = null;

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

        if (lat && lng) {
            markerTujuan = L.marker([lat, lng], { icon: createMapIcon('green') })
                .bindPopup('<strong>' + data.text + '</strong>')
                .addTo(searchMap).openPopup();
            searchMap.setView([lat, lng], 15);
            gambarGaris();
        }

        // Tampilkan info apotek
        var infoEl = document.getElementById('info-apotek');
        infoEl.innerHTML = '<strong>' + data.text + '</strong>';
        infoEl.classList.remove('hidden');
    });

    $('#tempat-tujuan').on('select2:clear', function () {
        if (markerTujuan) { markerTujuan.remove(); markerTujuan = null; }
        gambarGaris();
        document.getElementById('info-apotek').classList.add('hidden');
    });

    // ================================================
    // Gambar garis dari titik awal ke tujuan
    // ================================================
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
