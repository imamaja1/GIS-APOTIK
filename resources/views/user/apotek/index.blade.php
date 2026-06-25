@extends('layouts.user')

@section('title', 'Data Apotek — GIS Apotek KLU')

@section('content')

    <div class="mb-5">
        <h1 class="text-lg font-semibold text-gray-800">Apotek KLU</h1>
        <p class="text-sm text-gray-400 mt-0.5">Total: {{ $apotek->total() }} apotek ditemukan</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        {{-- Filter --}}
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <form method="GET" action="{{ route('user.data-apotek') }}">
                <div class="flex flex-col sm:flex-row gap-3">

                    {{-- Dropdown Kecamatan --}}
                    <div class="sm:w-52">
                        <label class="block text-xs text-gray-500 mb-1">Kecamatan</label>
                        <select name="kecamatan_id" id="filter-kecamatan" class="w-full text-sm">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatanList as $kec)
                                <option value="{{ $kec->id }}" {{ $kecamatanId == $kec->id ? 'selected' : '' }}>
                                    {{ $kec->nama_kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Input Nama Apotek --}}
                    <div class="flex-1">
                        <label class="block text-xs text-gray-500 mb-1">Nama Apotek</label>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Cari nama apotek..."
                            class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white
                                   placeholder:text-gray-400 transition-colors
                                   focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="h-10 px-5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition whitespace-nowrap">
                            Cari
                        </button>
                        @if ($kecamatanId || $search)
                            <a href="{{ route('user.data-apotek') }}"
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
                        <th class="px-4 py-3 font-semibold">Nama Apotek</th>
                        <th class="px-4 py-3 font-semibold w-36">Kecamatan</th>
                        <th class="px-4 py-3 font-semibold w-44 hidden md:table-cell">Alamat</th>
                        <th class="px-4 py-3 font-semibold text-center w-24">Status</th>
                        <th class="px-4 py-3 font-semibold text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($apotek as $index => $a)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $apotek->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-medium text-gray-800">{{ $a->nama_apotek }}</span>
                                {{-- Tampil no. telp di bawah nama (mobile) --}}
                                @if ($a->no_telp)
                                    <span class="block text-xs text-gray-400 mt-0.5">{{ $a->no_telp }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $a->kecamatan->nama_kecamatan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs hidden md:table-cell">
                                <span class="line-clamp-2 max-w-xs">{{ $a->jalan_apotek }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($a->is_open_now)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Buka
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                        Tutup
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button
                                    onclick="bukaModal({{ $a->id }})"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <p class="text-gray-400 text-sm">Tidak ada apotek yang ditemukan.</p>
                                @if ($kecamatanId || $search)
                                    <a href="{{ route('user.data-apotek') }}"
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
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $apotek->links() }}
            </div>
        @endif

    </div>

    {{-- ===== Modal Detail Apotek ===== --}}
    <div id="modal-detail"
         class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 flex-shrink-0">
                <h3 class="font-semibold text-gray-800">Detail Apotek</h3>
                <button onclick="tutupModal()"
                        class="text-gray-400 hover:text-gray-600 transition p-1 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Info Apotek --}}
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Nama Apotek</p>
                            <p id="modal-nama" class="text-gray-800 font-semibold">—</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Kecamatan</p>
                            <p id="modal-kecamatan" class="text-gray-700">—</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Alamat</p>
                            <p id="modal-alamat" class="text-gray-700 text-sm">—</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Telepon</p>
                            <p id="modal-telp" class="text-gray-700">—</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Jam Operasional</p>
                            <div id="modal-jam" class="text-sm text-gray-700 space-y-1">—</div>
                        </div>
                    </div>

                    {{-- Peta Mini --}}
                    <div>
                        @include('partials.leaflet-map', ['mapId' => 'modal-map', 'height' => '280px'])
                    </div>

                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex justify-end px-6 py-4 border-t border-gray-100 flex-shrink-0">
                <button onclick="tutupModal()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm font-medium transition">
                    Close
                </button>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // --- Filter Select2 ---
    $(document).ready(function () {
        $('#filter-kecamatan').select2({
            placeholder: 'Pilih Kecamatan',
            allowClear: true,
            width: '100%',
        });
    });

    // --- Modal ---
    var modalMap    = null;
    var modalMarker = null;

    function bukaModal(apotekId) {
        var modal = document.getElementById('modal-detail');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        fetch('/user/apotek/' + apotekId + '/detail', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(parseJsonResponse)
            .then(function (data) {

                document.getElementById('modal-nama').textContent      = data.nama_apotek;
                document.getElementById('modal-kecamatan').textContent = data.kecamatan;
                document.getElementById('modal-alamat').textContent    = data.alamat_lengkap;
                document.getElementById('modal-telp').textContent      = data.no_telp || '-';

                // Jam operasional
                var jamEl = document.getElementById('modal-jam');
                if (data.jam_operasional && data.jam_operasional.length > 0) {
                    jamEl.innerHTML = data.jam_operasional.map(function (j) {
                        var info = j.status_buka === 'Buka'
                            ? '<span class="text-green-600 font-medium">' + (j.jam_buka || '') + ' — ' + (j.jam_tutup || '') + '</span>'
                            : '<span class="text-red-400">Tutup</span>';
                        return '<div class="flex justify-between border-b border-gray-50 py-0.5">' +
                                   '<span class="w-20 text-gray-500">' + j.hari + '</span>' + info +
                               '</div>';
                    }).join('');
                } else {
                    jamEl.innerHTML = '<span class="text-gray-400 text-xs">Belum ada jadwal.</span>';
                }

                // Inisialisasi peta modal setelah modal terlihat
                setTimeout(function () {
                    var lat = parseFloat(data.latitude);
                    var lng = parseFloat(data.longitude);

                    if (!modalMap) {
                        modalMap = initBaseMap('modal-map', { center: [lat, lng], zoom: 15 });
                    } else {
                        modalMap.invalidateSize();
                        modalMap.setView([lat, lng], 15);
                    }

                    if (modalMarker) modalMarker.remove();
                    modalMarker = L.marker([lat, lng], { icon: createMapIcon('green') })
                        .bindPopup('<strong>' + data.nama_apotek + '</strong>')
                        .addTo(modalMap)
                        .openPopup();
                }, 150);

            })
            .catch(function () {
                alert('Gagal memuat data apotek. Silakan coba lagi.');
            });
    }

    function tutupModal() {
        var modal = document.getElementById('modal-detail');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup modal jika klik backdrop
    document.getElementById('modal-detail').addEventListener('click', function (e) {
        if (e.target === this) tutupModal();
    });
</script>
@endpush
