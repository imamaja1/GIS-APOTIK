@extends('layouts.admin')

@section('title', 'Master Data Apotek')

@php
$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
@endphp

@section('content')
<div class="space-y-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-base font-semibold text-gray-800">Master Data Apotek</h1>
                <p class="text-xs text-gray-400 mt-0.5">Kelola data apotek dengan CRUD lengkap.</p>
            </div>
        </div>

        <button onclick="bukaModalTambah()"
            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Apotek
        </button>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        {{-- Filter --}}
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <form method="GET" action="{{ route('admin.apotek.index') }}">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <label class="block text-xs text-gray-500 mb-1">Cari Apotek</label>
                        <input type="search" name="search" value="{{ $search }}" placeholder="Ketik nama apotek..."
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="h-10 px-5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition whitespace-nowrap cursor-pointer">
                            Cari
                        </button>
                        @if ($search)
                        <a href="{{ route('admin.apotek.index') }}"
                            class="h-10 px-4 flex items-center border border-gray-300 bg-white hover:bg-gray-50 text-gray-500 hover:text-gray-700 rounded-lg text-sm transition whitespace-nowrap cursor-pointer">
                            Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-green-600 text-white text-left text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 font-semibold w-10">#</th>
                        <th class="px-4 py-3 font-semibold">Nama Apotek</th>
                        <th class="px-4 py-3 font-semibold w-36">Kecamatan</th>
                        <th class="px-4 py-3 font-semibold text-center w-24">Status</th>
                        <th class="px-4 py-3 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($apotek as $i => $a)
                    <tr class="hover:bg-green-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $apotek->firstItem() + $i }}</td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-800">{{ $a->nama_apotek }}</span>
                            @if ($a->no_telp)
                            <span class="block text-xs text-gray-400 mt-0.5">{{ $a->no_telp }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $a->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if ($a->is_open_now ?? false)
                            <span
                                class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                Buka
                            </span>
                            @else
                            <span
                                class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                Tutup
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="bukaModalEdit({{ $a->id }})"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-amber-200 bg-amber-50 text-amber-600 hover:bg-amber-100 transition cursor-pointer"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <button onclick='bukaModalHapus({{ $a->id }}, @json($a->nama_apotek))'
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 transition cursor-pointer"
                                    title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <p class="text-gray-400 text-sm">Belum ada data apotek.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($apotek->hasPages())
        <div class="pagination-white px-6 py-4 border-t border-gray-100 bg-white">
            {{ $apotek->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ===== Modal Tambah/Edit Apotek ===== --}}
<div id="modal-form" class="fixed inset-0 bg-black/50 z-[9999] hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-6xl max-h-[90vh] flex flex-col">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 flex-shrink-0">
            <h3 id="modal-form-title" class="font-semibold text-gray-800">Tambah Apotek</h3>
            <button onclick="tutupModalForm()" class="text-gray-400 hover:text-gray-600 transition p-1 rounded cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto p-6">
            <form id="form-apotek" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" id="form-apotek-id" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- ===== KOLOM KIRI ===== --}}
                    <div class="space-y-4">

                        {{-- Nama Apotek --}}
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Nama Apotek</label>
                            <input type="text" name="nama_apotek" id="input-nama" required
                                class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                        </div>

                        {{-- No. Telp --}}
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">No. Telp</label>
                            <input type="text" name="no_telp" id="input-telp" placeholder="Opsional"
                                class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                        </div>

                        {{-- Jam Operasional --}}
                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                            <h2 class="text-sm font-semibold text-gray-700 mb-3">Jam Operasional</h2>
                            <div class="space-y-2">
                                @foreach ($days as $day)
                                <div class="flex flex-col md:flex-row md:items-center gap-2 rounded-lg bg-white p-2.5 border border-gray-200">
                                    <span class="text-xs font-medium text-gray-700 shrink-0 md:w-[70px]">{{ $day }}</span>
                                    <div class="flex items-center gap-2 flex-1 min-w-0">
                                        <select name="jam_operasional[{{ $day }}][status_buka]" required
                                            class="h-8 rounded-lg border border-gray-300 bg-white px-2 text-xs text-gray-700 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 flex-1 min-w-0">
                                            <option value="Buka">Buka</option>
                                            <option value="Tutup">Tutup</option>
                                        </select>
                                        <input type="time" name="jam_operasional[{{ $day }}][jam_buka]" value=""
                                            class="h-8 rounded-lg border border-gray-300 bg-white px-2 text-xs text-gray-700 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 flex-1 min-w-0">
                                        <input type="time" name="jam_operasional[{{ $day }}][jam_tutup]" value=""
                                            class="h-8 rounded-lg border border-gray-300 bg-white px-2 text-xs text-gray-700 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 flex-1 min-w-0">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- ===== KOLOM KANAN ===== --}}
                    <div class="space-y-4">

                        {{-- Kecamatan --}}
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Kecamatan</label>
                            <select name="kecamatan_id" id="input-kecamatan" required
                                class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($kecamatanList as $kecamatan)
                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jalan Apotek --}}
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Jalan Apotek</label>
                            <input type="text" name="jalan_apotek" id="input-jalan" required
                                class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="input-alamat" rows="2" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600"></textarea>
                        </div>

                        {{-- Peta --}}
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Pilih Lokasi di Peta</label>
                            <p class="text-[11px] text-gray-400 mb-1.5">Klik pada peta atau seret marker untuk mengatur lokasi.</p>
                            <div id="form-map" class="w-full rounded-lg border border-gray-200"
                                style="height: 240px;"></div>
                        </div>

                        {{-- Lat/Lng --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Latitude</label>
                                <input type="text" name="latitude" id="input-lat" required step="any" placeholder="-8.35000000"
                                    class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Longitude</label>
                                <input type="text" name="longitude" id="input-lng" required step="any"
                                    placeholder="116.10000000"
                                    class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Error Box --}}
                <div id="form-errors"
                    class="hidden mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul id="form-errors-list" class="list-disc pl-5 space-y-1"></ul>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-100 flex-shrink-0">
            <button onclick="tutupModalForm()"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                Batal
            </button>
            <button onclick="submitForm()" id="btn-submit"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition cursor-pointer">
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- ===== Modal Hapus ===== --}}
<div id="modal-hapus" class="fixed inset-0 bg-black/50 z-[9999] hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Hapus Apotek?</h3>
            <p class="text-sm text-gray-500">Data <strong id="hapus-nama" class="text-gray-700"></strong> akan dihapus
                permanen.</p>
        </div>
        <div class="flex items-center justify-center gap-3 px-6 pb-6">
            <button type="button" onclick="tutupModalHapus()"
                class="flex-1 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-800 border border-gray-400 rounded-lg text-sm font-medium transition cursor-pointer">
                Batal
            </button>
            <form id="form-hapus" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white border border-red-600 rounded-lg text-sm font-medium transition cursor-pointer">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    @if (session('success'))
        alertSuccess(@json(session('success')));
    @endif

    // ===== Data Kecamatan untuk Select =====
    var kecamatanList = @json($kecamatanList);

    // ===== Variabel Peta =====
    var formMap = null;
    var formMarker = null;
    var defaultCenter = window.KLU_CENTER || [-8.3500, 116.1000];

    // ===== Fungsi Modal Form (Tambah/Edit) =====
    function bukaModalTambah() {
        document.getElementById('modal-form-title').textContent = 'Tambah Apotek';
        document.getElementById('form-apotek').reset();
        document.getElementById('form-method').value = 'POST';
        document.getElementById('form-apotek-id').value = '';
        document.getElementById('form-apotek').action = '{{ route("admin.apotek.store") }}';
        document.getElementById('btn-submit').textContent = 'Simpan';
        document.getElementById('form-errors').classList.add('hidden');

        showModal('modal-form');
        setTimeout(function() { resetFormMap(defaultCenter, 11); }, 100);
    }

    function bukaModalEdit(id) {
        document.getElementById('modal-form-title').textContent = 'Edit Apotek';
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('form-apotek-id').value = id;
        document.getElementById('form-errors').classList.add('hidden');

        // Fetch data apotek
        fetch('/admin/apotek/' + id + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(parseJsonResponse)
        .then(function(data) {
            document.getElementById('input-nama').value = data.nama_apotek || '';
            document.getElementById('input-kecamatan').value = data.kecamatan_id || '';
            document.getElementById('input-jalan').value = data.jalan_apotek || '';
            document.getElementById('input-alamat').value = data.alamat_lengkap || '';
            document.getElementById('input-telp').value = data.no_telp || '';
            document.getElementById('input-lat').value = data.latitude || '';
            document.getElementById('input-lng').value = data.longitude || '';

            // Pre-fill jam operasional
            var days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
            days.forEach(function(hari) {
                var jadwal = (data.jam_operasional || []).find(function(j) { return j.hari === hari; });
                var statusSel = document.querySelector('select[name="jam_operasional[' + hari + '][status_buka]"]');
                var bukaInput = document.querySelector('input[name="jam_operasional[' + hari + '][jam_buka]"]');
                var tutupInput = document.querySelector('input[name="jam_operasional[' + hari + '][jam_tutup]"]');

                if (jadwal) {
                    statusSel.value = jadwal.status_buka || 'Tutup';
                    bukaInput.value = jadwal.jam_buka ? jadwal.jam_buka.substring(0, 5) : '';
                    tutupInput.value = jadwal.jam_tutup ? jadwal.jam_tutup.substring(0, 5) : '';
                } else {
                    statusSel.value = 'Tutup';
                    bukaInput.value = '';
                    tutupInput.value = '';
                }
            });

            document.getElementById('form-apotek').action = '/admin/apotek/' + id;
            document.getElementById('btn-submit').textContent = 'Update';

            var lat = parseFloat(data.latitude) || defaultCenter[0];
            var lng = parseFloat(data.longitude) || defaultCenter[1];

            showModal('modal-form');
            setTimeout(function() { resetFormMap([lat, lng], 15); }, 100);
        })
        .catch(function(err) {
            console.error('Gagal memuat data:', err);
            alert('Gagal memuat data apotek.');
        });
    }

    function tutupModalForm() {
        hideModal('modal-form');
        document.getElementById('form-errors').classList.add('hidden');
    }

    // ===== Fungsi Modal Hapus =====
    function bukaModalHapus(id, nama) {
        confirmDelete(nama, function() {
            var form = document.getElementById('form-hapus');
            form.action = '/admin/apotek/' + id;
            form.submit();
        });
    }

    // ===== Fungsi Modal Generic =====
    function showModal(id) {
        var modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideModal(id) {
        var modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // ===== Fungsi Peta Form =====
    function resetFormMap(center, zoom) {
        if (!formMap) {
            formMap = L.map('form-map', { zoomControl: true }).setView(center, zoom);
            L.tileLayer(window.MAP_TILE_URL, {
                attribution: window.MAP_TILE_ATTRIB,
                maxZoom: 19,
            }).addTo(formMap);

            // Klik peta untuk set lokasi
            formMap.on('click', function(e) {
                setFormMarker(e.latlng.lat, e.latlng.lng);
            });
        } else {
            formMap.setView(center, zoom);
            if (formMarker) {
                formMarker.remove();
                formMarker = null;
            }
        }

        // Set marker di center jika zoom cukup dekat
        if (zoom >= 14) {
            setFormMarker(center[0], center[1]);
        }

        setTimeout(function() { formMap.invalidateSize(); }, 300);
        setTimeout(function() { formMap.invalidateSize(); }, 600);
    }

    function setFormMarker(lat, lng) {
        if (formMarker) {
            formMarker.setLatLng([lat, lng]);
        } else {
            formMarker = L.marker([lat, lng], {
                icon: createMapIcon('green'),
                draggable: true
            }).addTo(formMap);

            // Drag marker untuk update koordinat
            formMarker.on('dragend', function(e) {
                var pos = e.target.getLatLng();
                document.getElementById('input-lat').value = pos.lat.toFixed(8);
                document.getElementById('input-lng').value = pos.lng.toFixed(8);
            });
        }

        document.getElementById('input-lat').value = lat.toFixed(8);
        document.getElementById('input-lng').value = lng.toFixed(8);
    }

    // ===== Update Peta saat input berubah =====
    document.getElementById('input-lat').addEventListener('change', syncMapFromInput);
    document.getElementById('input-lng').addEventListener('change', syncMapFromInput);

    function syncMapFromInput() {
        var lat = parseFloat(document.getElementById('input-lat').value);
        var lng = parseFloat(document.getElementById('input-lng').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            setFormMarker(lat, lng);
            formMap.setView([lat, lng], 15);
        }
    }

    // ===== Submit Form =====
    function submitForm() {
        var form = document.getElementById('form-apotek');

        // Validasi HTML5 (required field)
        if (!form.reportValidity()) {
            return;
        }

        var formData = new FormData(form);
        var url = form.action;
        var method = document.getElementById('form-method').value;

        // Gunakan fetch untuk AJAX
        fetch(url, {
            method: method === 'PUT' ? 'POST' : method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(parseJsonResponse)
        .then(function(data) {
            tutupModalForm();
            window.location.reload();
        })
        .catch(function(errors) {
            var errorEl = document.getElementById('form-errors');
            var errorList = document.getElementById('form-errors-list');
            errorList.innerHTML = '';

            if (errors.errors) {
                Object.values(errors.errors).forEach(function(msgs) {
                    msgs.forEach(function(msg) {
                        var li = document.createElement('li');
                        li.textContent = msg;
                        errorList.appendChild(li);
                    });
                });
            } else if (errors.message) {
                var li = document.createElement('li');
                li.textContent = errors.message;
                errorList.appendChild(li);
            }

            errorEl.classList.remove('hidden');
        });
    }

    function tutupModalHapus() {
        hideModal('modal-hapus');
    }

    // ===== Tutup modal jika klik backdrop =====
    document.getElementById('modal-form').addEventListener('click', function (e) {
        if (e.target === this) tutupModalForm();
    });
    document.getElementById('modal-hapus').addEventListener('click', function (e) {
        if (e.target === this) tutupModalHapus();
    });
</script>
@endpush