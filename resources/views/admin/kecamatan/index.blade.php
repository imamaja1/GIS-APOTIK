@extends('layouts.admin')

@section('title', 'Kecamatan Admin')

@section('content')
<div class="space-y-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3a15.3 15.3 0 014.5 9A15.3 15.3 0 0112 21a15.3 15.3 0 01-4.5-9A15.3 15.3 0 0112 3z" />
                </svg>
            </div>
            <div>
                <h1 class="text-base font-semibold text-gray-800">Kecamatan</h1>
                <p class="text-xs text-gray-400 mt-0.5">Daftar kecamatan di Kabupaten Lombok Utara.</p>
            </div>
        </div>

        <button onclick="bukaModalTambah()"
            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kecamatan
        </button>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        @if (session('success'))
        <div class="mx-6 mt-4 p-3 rounded-lg border border-green-200 bg-green-50 text-green-700 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="mx-6 mt-4 p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
            {{ session('error') }}
        </div>
        @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-green-600 text-white text-left text-xs uppercase tracking-wide">
                    <th class="px-4 py-3 font-semibold w-10">#</th>
                    <th class="px-4 py-3 font-semibold">Nama Kecamatan</th>
                    <th class="px-4 py-3 font-semibold text-center w-32">Jumlah Apotek</th>
                    <th class="px-4 py-3 font-semibold text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($kecamatan as $i => $k)
                <tr class="hover:bg-green-50 transition">
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $kecamatan->firstItem() + $i }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $k->nama_kecamatan }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            {{ $k->apotek_count }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <button onclick="bukaModalEdit({{ $k->id }})"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-amber-200 bg-amber-50 text-amber-600 hover:bg-amber-100 transition"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                </svg>
                            </button>
                            <button onclick="bukaModalHapus({{ $k->id }}, '{{ $k->nama_kecamatan }}', {{ $k->apotek_count }})"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 transition"
                                title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-12 text-center">
                        <p class="text-gray-400 text-sm">Belum ada data kecamatan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($kecamatan->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $kecamatan->links() }}
    </div>
    @endif
    </div>

</div>

{{-- ===== Modal Tambah/Edit Kecamatan ===== --}}
<div id="modal-form" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">

        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 id="modal-form-title" class="font-semibold text-gray-800">Tambah Kecamatan</h3>
            <button onclick="tutupModalForm()"
                class="text-gray-400 hover:text-gray-600 transition p-1 rounded">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <form id="form-kecamatan" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div>
                    <label class="block text-xs text-gray-500 mb-1">Nama Kecamatan</label>
                    <input type="text" name="nama_kecamatan" id="input-nama" required
                        placeholder="Contoh: Tanjung"
                        class="w-full h-10 px-3 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder:text-gray-400 transition-colors focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>

                <div id="form-errors" class="hidden rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul id="form-errors-list" class="list-disc pl-5 space-y-1"></ul>
                </div>
            </form>
        </div>

        <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-100">
            <button onclick="tutupModalForm()"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                Batal
            </button>
            <button onclick="submitForm()" id="btn-submit"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- ===== Modal Hapus ===== --}}
<div id="modal-hapus" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Hapus Kecamatan?</h3>
            <p class="text-sm text-gray-500">Data <strong id="hapus-nama" class="text-gray-700"></strong> akan dihapus permanen.</p>
            <p id="hapus-warning" class="hidden text-sm text-red-500 mt-2"></p>
        </div>
        <div class="flex items-center justify-center gap-3 px-6 pb-6">
            <button onclick="tutupModalHapus()"
                class="flex-1 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-800 border border-gray-400 rounded-lg text-sm font-medium transition">
                Batal
            </button>
            <form id="form-hapus" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" id="btn-hapus"
                    class="w-full px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-800 border border-gray-400 rounded-lg text-sm font-medium transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ===== Fungsi Modal Form (Tambah/Edit) =====
    function bukaModalTambah() {
        document.getElementById('modal-form-title').textContent = 'Tambah Kecamatan';
        document.getElementById('form-kecamatan').reset();
        document.getElementById('form-method').value = 'POST';
        document.getElementById('form-kecamatan').action = '{{ route("admin.kecamatan.store") }}';
        document.getElementById('btn-submit').textContent = 'Simpan';
        document.getElementById('form-errors').classList.add('hidden');
        showModal('modal-form');
    }

    function bukaModalEdit(id) {
        document.getElementById('modal-form-title').textContent = 'Edit Kecamatan';
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('form-errors').classList.add('hidden');

        fetch('/admin/kecamatan/' + id + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(parseJsonResponse)
        .then(function(data) {
            document.getElementById('input-nama').value = data.nama_kecamatan || '';
            document.getElementById('form-kecamatan').action = '/admin/kecamatan/' + id;
            document.getElementById('btn-submit').textContent = 'Update';
            showModal('modal-form');
        })
        .catch(function(err) {
            console.error('Gagal memuat data:', err);
            alert('Gagal memuat data kecamatan.');
        });
    }

    function tutupModalForm() {
        hideModal('modal-form');
        document.getElementById('form-errors').classList.add('hidden');
    }

    // ===== Fungsi Modal Hapus =====
    function bukaModalHapus(id, nama, apotekCount) {
        document.getElementById('hapus-nama').textContent = nama;
        document.getElementById('form-hapus').action = '/admin/kecamatan/' + id;

        var warningEl = document.getElementById('hapus-warning');
        var btnHapus = document.getElementById('btn-hapus');

        if (apotekCount > 0) {
            warningEl.textContent = 'Kecamatan ini memiliki ' + apotekCount + ' apotek dan tidak dapat dihapus.';
            warningEl.classList.remove('hidden');
            btnHapus.disabled = true;
            btnHapus.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            warningEl.classList.add('hidden');
            btnHapus.disabled = false;
            btnHapus.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        showModal('modal-hapus');
    }

    function tutupModalHapus() {
        hideModal('modal-hapus');
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

    // ===== Submit Form =====
    function submitForm() {
        var form = document.getElementById('form-kecamatan');
        var formData = new FormData(form);
        var url = form.action;
        var method = document.getElementById('form-method').value;

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

    // ===== Tutup modal jika klik backdrop =====
    document.getElementById('modal-form').addEventListener('click', function (e) {
        if (e.target === this) tutupModalForm();
    });
    document.getElementById('modal-hapus').addEventListener('click', function (e) {
        if (e.target === this) tutupModalHapus();
    });
</script>
@endpush
