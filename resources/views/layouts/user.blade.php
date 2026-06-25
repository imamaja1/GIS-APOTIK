<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GIS Apotek KLU')</title>

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-green-600 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">

                {{-- Kiri: Brand + Nav links --}}
                <div class="flex items-center gap-1">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 shrink-0 mr-3">
                        <svg class="w-5 h-5 text-green-200" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        <span class="text-white font-bold text-base tracking-wide">GIS APOTIK</span>
                    </a>

                    {{-- Desktop nav links (lg ke atas) --}}
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

                {{-- Kanan: Logout --}}
                <div class="hidden lg:flex items-center">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-green-100 hover:text-white hover:bg-green-700 rounded-md transition border border-green-500">
                            Log Out
                        </button>
                    </form>
                </div>

                {{-- Hamburger button (mobile only) --}}
                <button id="nav-hamburger" type="button" aria-label="Toggle menu"
                    class="lg:hidden flex items-center justify-center w-9 h-9 rounded-md text-white hover:bg-green-700 transition">
                    {{-- Icon: 3 garis --}}
                    <svg id="icon-menu" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    {{-- Icon: X saat menu terbuka --}}
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile menu (tersembunyi secara default) --}}
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

                <div class="pt-2 border-t border-green-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-green-100 hover:text-white hover:bg-green-700 transition text-left">
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--
    ============================================================
    KONFIGURASI PETA GLOBAL — edit di sini untuk ganti provider
    ============================================================
    --}}
    <script>
        /** Koordinat pusat KLU dan zoom default */
        window.KLU_CENTER = [-8.3500, 116.1000];
        window.KLU_ZOOM   = 11;

        /** Provider tile OSM — ganti URL di sini untuk ganti provider */
        window.MAP_TILE_URL    = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        window.MAP_TILE_ATTRIB = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        /**
         * Inisialisasi Leaflet map dengan default KLU.
         * @param {string} mapId   - id elemen DOM
         * @param {object} options - { center: [lat,lng], zoom: number }
         * @returns {L.Map}
         */
        function initBaseMap(mapId, options) {
            options = options || {};
            var center = options.center || window.KLU_CENTER;
            var zoom   = options.zoom   || window.KLU_ZOOM;

            var map = L.map(mapId, { zoomControl: true }).setView(center, zoom);
            L.tileLayer(window.MAP_TILE_URL, {
                attribution: window.MAP_TILE_ATTRIB,
                maxZoom: 19,
            }).addTo(map);

            return map;
        }

        /**
         * Buat ikon marker berwarna (divIcon lingkaran).
         * @param {string} color - 'green' | 'blue' | 'red'
         * @returns {L.DivIcon}
         */
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

        /** Setup CSRF untuk jQuery AJAX */
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        function parseJsonResponse(res) {
            var ct = res.headers.get('content-type') || '';
            if (ct.indexOf('application/json') !== -1) {
                return res.json();
            }
            if (res.status === 419) {
                throw { message: 'Session habis. Silakan login ulang.' };
            }
            if (res.status >= 300 && res.status < 400) {
                throw { message: 'Redirect. Silakan refresh halaman.' };
            }
            throw { message: 'Server mengembalikan respons yang tidak valid. Silakan coba lagi.' };
        }
    </script>

    {{-- Toggle hamburger (vanilla JS, tidak butuh jQuery) --}}
    <script>
        (function () {
            var btn     = document.getElementById('nav-hamburger');
            var menu    = document.getElementById('nav-mobile');
            var iconMenu  = document.getElementById('icon-menu');
            var iconClose = document.getElementById('icon-close');

            btn.addEventListener('click', function () {
                var isOpen = !menu.classList.contains('hidden');
                menu.classList.toggle('hidden', isOpen);
                iconMenu.classList.toggle('hidden', !isOpen);
                iconClose.classList.toggle('hidden', isOpen);
            });

            // Tutup menu jika layar diperbesar ke desktop
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