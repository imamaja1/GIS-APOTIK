@extends('layouts.admin')

@section('title', 'Data Apotik (Read Only)')

@section('content')
<div class="space-y-4">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
            </svg>
        </div>
        <div>
            <h1 class="text-base font-semibold text-gray-800">Data Apotik</h1>
            <p class="text-xs text-gray-400 mt-0.5">Halaman ini hanya untuk melihat data (read-only).</p>
        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        {{-- Filter --}}
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <form method="GET" action="{{ route('admin.data-apotek') }}">
                <div class="flex flex-col sm:flex-row gap-3">

                    {{-- Dropdown Kecamatan --}}
                    <div class="sm:w-52">
                        <label class="block text-xs text-gray-500 mb-1">Kecamatan</label>
                        <select name="kecamatan_id" id="filter-kecamatan"
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatanList as $kec)
                            <option value="{{ $kec->id }}" {{ $kecamatanId==$kec->id ? 'selected' : '' }}>
                                {{ $kec->nama_kecamatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Input Nama Apotek --}}
                    <div class="flex-1">
                        <label class="block text-xs text-gray-500 mb-1">Nama Apotek</label>
                        <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama apotek..."
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="h-10 px-5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition whitespace-nowrap">
                            Cari
                        </button>
                        @if ($kecamatanId || $search)
                        <a href="{{ route('admin.data-apotek') }}"
                            class="h-10 px-4 flex items-center border border-gray-300 bg-white hover:bg-gray-50 text-gray-500 hover:text-gray-700 rounded-lg text-sm transition whitespace-nowrap">
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
                        <th class="px-4 py-3 font-semibold">Nama Apotik</th>
                        <th class="px-4 py-3 font-semibold w-36">Kecamatan</th>
                        <th class="px-4 py-3 font-semibold text-center w-24">Status</th>
                        <th class="px-4 py-3 font-semibold text-center w-20">Aksi</th>
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
                            @if ($a->is_open_now)
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
                            <button onclick="bukaModalDetail({{ $a->id }})"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
                                title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <p class="text-gray-400 text-sm">Tidak ada data apotek.</p>
                            @if ($kecamatanId || $search)
                            <a href="{{ route('admin.data-apotek') }}"
                                class="text-green-600 hover:underline text-xs mt-1 inline-block">
                                Hapus filter
                            </a>
                            @endif
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

{{-- ===== Modal Detail Apotek ===== --}}
<div id="modal-detail" class="fixed inset-0 bg-black/50 z-[1100] hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Detail Apotek</h3>
            <button onclick="tutupModalDetail()" class="text-gray-400 hover:text-gray-600 transition p-1 rounded">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex-1 overflow-y-auto p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Kiri: Info --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-500 mb-0.5">Nama Apotek</label>
                        <p id="detail-nama" class="text-sm font-medium text-gray-800">-</p>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-0.5">Kecamatan</label>
                        <p id="detail-kecamatan" class="text-sm text-gray-700">-</p>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-0.5">Alamat</label>
                        <p id="detail-alamat" class="text-sm text-gray-700">-</p>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-0.5">Jam Buka</label>
                        <div id="detail-jam" class="text-sm text-gray-700 space-y-1"></div>
                    </div>
                </div>

                {{-- Kanan: Peta --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Peta Apotek</label>
                    <div id="detail-map" class="w-full rounded-lg border border-gray-200 bg-gray-100"
                        style="height: 224px; min-height: 224px;"></div>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="flex justify-end px-5 py-3 border-t border-gray-100">
            <button onclick="tutupModalDetail()"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                Tutup
            </button>
        </div>

    </div>
</div>

@push('scripts')
<script>
    var detailMap = null;
    var detailMarker = null;

    function bukaModalDetail(id) {
        fetch('/admin/data-apotek/' + id + '/detail', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(parseJsonResponse)
        .then(function(data) {
            document.getElementById('detail-nama').textContent = data.nama_apotek || '-';
            document.getElementById('detail-kecamatan').textContent = data.kecamatan?.nama_kecamatan || '-';
            document.getElementById('detail-alamat').textContent = data.alamat_lengkap || '-';

            var jamEl = document.getElementById('detail-jam');
            jamEl.innerHTML = '';
            if (data.jam_operasional && data.jam_operasional.length > 0) {
                data.jam_operasional.forEach(function(j) {
                    var statusClass = j.status_buka ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                    var statusText = j.status_buka ? 'Buka' : 'Tutup';
                    var jamText = j.status_buka ? (j.jam_buka + ' - ' + j.jam_tutup) : 'Tutup';
                    jamEl.innerHTML += '<div class="flex items-center gap-2">' +
                        '<span class="text-xs text-gray-500 w-12">' + j.hari + '</span>' +
                        '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ' + statusClass + '">' + statusText + '</span>' +
                        (j.status_buka ? '<span class="text-xs text-gray-600">' + jamText + '</span>' : '') +
                        '</div>';
                });
            } else {
                jamEl.innerHTML = '<span class="text-xs text-gray-400">-</span>';
            }

            showModal('modal-detail');

            setTimeout(function() {
                var lat = parseFloat(data.latitude);
                var lng = parseFloat(data.longitude);
                if (!isFinite(lat) || !isFinite(lng)) {
                    lat = -8.35;
                    lng = 116.15;
                }

                var mapContainer = document.getElementById('detail-map');
                if (detailMap) {
                    detailMap.remove();
                    detailMap = null;
                    detailMarker = null;
                    if (mapContainer) {
                        mapContainer.innerHTML = '';
                    }
                }

                detailMap = initBaseMap('detail-map', { center: [lat, lng], zoom: 15 });

                if (detailMarker) {
                    detailMarker.remove();
                }

                detailMarker = L.marker([lat, lng], {
                    icon: createMapIcon('green')
                }).addTo(detailMap)
                  .bindPopup(
                    '<div class="text-sm leading-5">' +
                        '<b>' + (data.nama_apotek || '-') + '</b>' +
                        (data.kecamatan ? '<br><span class="text-xs text-gray-500">' + data.kecamatan.nama_kecamatan + '</span>' : '') +
                    '</div>'
                  ).openPopup();

                detailMap.whenReady(function () {
                    detailMap.invalidateSize(true);
                });

                detailMap.invalidateSize(true);
                window.requestAnimationFrame(function() {
                    detailMap.invalidateSize(true);
                });
                setTimeout(function() {
                    detailMap.invalidateSize(true);
                }, 500);
            }, 300);
        })
        .catch(function(err) {
            console.error('Gagal memuat detail:', err);
            alert('Gagal memuat data apotek.');
        });
    }

    function tutupModalDetail() {
        hideModal('modal-detail');
    }

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

    document.getElementById('modal-detail').addEventListener('click', function (e) {
        if (e.target === this) tutupModalDetail();
    });
</script>
@endpush
@endsection