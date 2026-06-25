@extends('layouts.admin')

@section('title', 'Edit Apotik')

@section('content')
@php
$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
$jamOperasional = $apotek->jamOperasional->keyBy('hari');
@endphp

<div class="max-w-6xl mx-auto space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-700">Edit Apotik</h1>
                <p class="text-sm text-gray-500">Perbarui data apotek dan jadwal operasional harian.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.apotek.update', $apotek) }}"
            class="grid gap-6 xl:grid-cols-[1.4fr_1fr]">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Apotik</label>
                        <input type="text" name="nama_apotek" value="{{ old('nama_apotek', $apotek->nama_apotek) }}"
                            required
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <select name="kecamatan_id" required
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatanList as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $apotek->kecamatan_id) ==
                                $kecamatan->id ? 'selected' : '' }}>
                                {{ $kecamatan->nama_kecamatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jalan Apotik</label>
                    <input type="text" name="jalan_apotek" value="{{ old('jalan_apotek', $apotek->jalan_apotek) }}"
                        required
                        class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">{{ old('alamat_lengkap', $apotek->alamat_lengkap) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telp</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $apotek->no_telp) }}"
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                        <input type="text" id="input-lat" name="latitude"
                            value="{{ old('latitude', $apotek->latitude) }}" required
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                        <input type="text" id="input-lng" name="longitude"
                            value="{{ old('longitude', $apotek->longitude) }}" required
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                    </div>
                </div>

                @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div class="space-y-4">
                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                    <h2 class="text-sm font-semibold text-gray-700 mb-4">Jam Operasional</h2>
                    <div class="space-y-2">
                        @foreach ($days as $day)
                        @php
                        $jadwal = old('jam_operasional.'.$day) ?? (
                        isset($jamOperasional[$day]) ? [
                        'status_buka' => $jamOperasional[$day]->status_buka,
                        'jam_buka' => $jamOperasional[$day]->jam_buka,
                        'jam_tutup' => $jamOperasional[$day]->jam_tutup,
                        ] : ['status_buka' => 'Buka', 'jam_buka' => '', 'jam_tutup' => '']
                        );
                        @endphp
                        <div
                            class="grid grid-cols-[90px_1fr_120px_120px] gap-3 items-center rounded-xl bg-white p-3 border border-gray-200">
                            <span class="text-sm font-medium text-gray-700">{{ $day }}</span>
                            <select name="jam_operasional[{{ $day }}][status_buka]"
                                class="h-10 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                                <option value="Buka" {{ $jadwal['status_buka']==='Buka' ? 'selected' : '' }}>Buka
                                </option>
                                <option value="Tutup" {{ $jadwal['status_buka']==='Tutup' ? 'selected' : '' }}>Tutup
                                </option>
                            </select>
                            <input type="time" name="jam_operasional[{{ $day }}][jam_buka]"
                                value="{{ $jadwal['jam_buka'] }}"
                                class="h-10 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                            <input type="time" name="jam_operasional[{{ $day }}][jam_tutup]"
                                value="{{ $jadwal['jam_tutup'] }}"
                                class="h-10 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-4">
                    <h2 class="text-sm font-semibold text-gray-700 mb-4">Peta Lokasi</h2>
                    <div id="form-map" class="h-72 rounded-2xl border border-gray-200 overflow-hidden"></div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <a href="{{ route('admin.apotek.index') }}"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-600 text-center hover:bg-gray-50">Batal</a>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!document.getElementById('form-map')) return;

        var map = L.map('form-map', { zoomControl: true }).setView([ -8.3500, 116.1000 ], 11);
        L.tileLayer(window.MAP_TILE_URL, {
            attribution: window.MAP_TILE_ATTRIB,
            maxZoom: 19,
        }).addTo(map);

        var marker = null;
        var latInput = document.getElementById('input-lat');
        var lngInput = document.getElementById('input-lng');

        function setMarker(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: true, icon: createMapIcon('green') }).addTo(map);
                marker.on('dragend', function (e) {
                    var pos = e.target.getLatLng();
                    latInput.value = pos.lat.toFixed(8);
                    lngInput.value = pos.lng.toFixed(8);
                });
            }
            map.setView([lat, lng], 14);
        }

        function syncFromInputs() {
            var lat = parseFloat(latInput.value);
            var lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                setMarker(lat, lng);
            }
        }

        map.on('click', function (e) {
            latInput.value = e.latlng.lat.toFixed(8);
            lngInput.value = e.latlng.lng.toFixed(8);
            setMarker(e.latlng.lat, e.latlng.lng);
        });

        latInput.addEventListener('change', syncFromInputs);
        lngInput.addEventListener('change', syncFromInputs);

        if (latInput.value && lngInput.value) {
            syncFromInputs();
        }
    });
</script>
@endpush