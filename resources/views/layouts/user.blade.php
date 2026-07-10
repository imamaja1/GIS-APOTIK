<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GIS Apotek KLU')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-green-600 shadow sticky top-0 z-[1050]">
        {{-- Mobile: full-width with padding --}}
        <div class="lg:max-w-7xl lg:mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-14">

                {{-- Kiri: Brand + Desktop nav links --}}
                <div class="flex items-center gap-1">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 shrink-0 mr-3">
                        <svg class="w-5 h-5 text-green-200" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        <span class="text-white font-bold text-base tracking-wide">GIS APOTEK</span>
                    </a>

                    {{-- Desktop nav links --}}
                    <div class="hidden lg:flex items-center gap-1">
                        <a href="{{ route('user.data-apotek') }}"
                            class="px-4 py-2 text-sm font-medium text-white rounded-md transition
                                  {{ request()->routeIs('user.data-apotek') ? 'bg-green-800' : 'hover:bg-green-700' }}">
                            Data Apotek
                        </a>
                        <a href="{{ route('user.search-apotek') }}"
                            class="px-4 py-2 text-sm font-medium text-white rounded-md transition
                                  {{ request()->routeIs('user.search-apotek') ? 'bg-green-800' : 'hover:bg-green-700' }}">
                            Search Apotek
                        </a>
                    </div>
                </div>

                {{-- Kanan: kosong --}}
                <div class="hidden lg:flex items-center gap-1">
                </div>

                {{-- Hamburger button (mobile) --}}
                <button id="nav-hamburger" type="button" aria-label="Toggle menu"
                    class="lg:hidden flex items-center justify-center w-9 h-9 rounded-md text-white hover:bg-green-700 transition cursor-pointer">
                    <svg id="icon-menu" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="nav-mobile" class="hidden lg:hidden border-t border-green-700">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-white transition
                          {{ request()->routeIs('user.dashboard') ? 'bg-green-800' : 'hover:bg-green-700' }}">
                    <svg class="w-4 h-4 opacity-70" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('user.data-apotek') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-white transition
                          {{ request()->routeIs('user.data-apotek') ? 'bg-green-800' : 'hover:bg-green-700' }}">
                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Data Apotek
                </a>
                <a href="{{ route('user.search-apotek') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-white transition
                          {{ request()->routeIs('user.search-apotek') ? 'bg-green-800' : 'hover:bg-green-700' }}">
                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search Apotek
                </a>

            </div>
        </div>
    </nav>

    {{-- ===== CONTENT ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-green-800 text-white mt-12">
        <div class="lg:max-w-7xl lg:mx-auto px-4 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        <span class="font-bold text-base tracking-wide">GIS APOTEK KLU</span>
                    </div>
                    <p class="text-sm text-green-200 leading-relaxed">
                        Sistem Informasi Geografis penyebaran apotek di Kabupaten Lombok Utara.
                    </p>
                </div>
                {{-- Kontak --}}
                <div>
                    <h3 class="text-sm font-semibold text-white mb-3">Kontak</h3>
                    <div class="space-y-2 text-sm text-green-200">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span>Jl. Prof. M. Yamin, Tanjung, Kabupaten Lombok Utara, NTB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <span>info@lombokutarakab.go.id</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            <span>(0370) 621234</span>
                        </div>
                    </div>
                </div>
                {{-- Tautan --}}
                <div>
                    <h3 class="text-sm font-semibold text-white mb-3">Tautan</h3>
                    <div class="space-y-2 text-sm">
                        <a href="{{ route('home') }}" class="block text-green-200 hover:text-white transition">Beranda</a>
                        <a href="{{ route('user.data-apotek') }}" class="block text-green-200 hover:text-white transition">Data Apotek</a>
                        <a href="{{ route('user.search-apotek') }}" class="block text-green-200 hover:text-white transition">Search Apotek</a>
                    </div>
                </div>
            </div>
            {{-- Copyright --}}
            <div class="border-t border-green-700 mt-8 pt-6 text-center text-xs text-green-300">
                &copy; {{ date('Y') }} GIS Apotek Kabupaten Lombok Utara. Hak cipta dilindungi.
            </div>
        </div>
    </footer>

    {{-- ===== SCRIPTS ===== --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        window.KLU_CENTER = [-8.3500, 116.1000];
        window.KLU_ZOOM = 11;
        window.MAP_TILE_URL = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        window.MAP_TILE_ATTRIB = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        function initBaseMap(mapId, options) {
            options = options || {};
            var center = options.center || window.KLU_CENTER;
            var zoom = options.zoom || window.KLU_ZOOM;
            var map = L.map(mapId, { zoomControl: true }).setView(center, zoom);
            L.tileLayer(window.MAP_TILE_URL, {
                attribution: window.MAP_TILE_ATTRIB,
                maxZoom: 19,
            }).addTo(map);
            return map;
        }

        function createMapIcon(color) {
            var colors = { green: '#16a34a', blue: '#2563eb', red: '#dc2626' };
            var c = colors[color] || colors.green;
            return L.divIcon({
                className: '',
                html: '<div style="width:16px;height:16px;background:' + c + ';border:3px solid #fff;border-radius:50%;box-shadow:0 2px 5px rgba(0,0,0,.35);"></div>',
                iconSize: [16, 16],
                iconAnchor: [8, 8],
                popupAnchor: [0, -12],
            });
        }

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        function parseJsonResponse(res) {
            var ct = res.headers.get('content-type') || '';
            if (ct.indexOf('application/json') !== -1) {
                if (res.ok) {
                    return res.json();
                }
                return res.json().then(function(data) { throw data; });
            }
            if (res.status === 419) {
                throw { message: 'Session habis. Silakan login ulang.' };
            }
            if (res.status >= 300 && res.status < 400) {
                throw { message: 'Redirect. Silakan refresh halaman.' };
            }
            throw { message: 'Server mengembalikan respons yang tidak valid. Silakan coba lagi.' };
        }

        // ===== SweetAlert2 Helpers =====
        function alertSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: message,
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true
            });
        }

        function alertError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: message
            });
        }

        function confirmDelete(nama, callback) {
            Swal.fire({
                title: 'Hapus Data?',
                html: 'Data <strong>' + nama + '</strong> akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }
    </script>

    <script>
        (function () {
            var btn = document.getElementById('nav-hamburger');
            var menu = document.getElementById('nav-mobile');
            var iconMenu = document.getElementById('icon-menu');
            var iconClose = document.getElementById('icon-close');
            if (!btn) return;

            btn.addEventListener('click', function () {
                var isOpen = !menu.classList.contains('hidden');
                menu.classList.toggle('hidden', isOpen);
                iconMenu.classList.toggle('hidden', !isOpen);
                iconClose.classList.toggle('hidden', isOpen);
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    menu.classList.add('hidden');
                    iconMenu.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
