<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin GIS Apotek KLU')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex overflow-x-hidden">
        <aside
            class="flex w-64 xl:w-72 shrink-0 border-r border-green-100 bg-gradient-to-b from-white to-green-50/50 flex-col h-screen sticky top-0 overflow-y-auto">
            <div class="px-6 pt-8 pb-6 text-center border-b border-green-100">
                <div
                    class="w-40 h-40 mx-auto rounded-full border-2 border-green-200 bg-white shadow-sm flex items-center justify-center">
                    <div class="w-20 h-20 rounded-2xl bg-green-100 text-green-700 flex items-center justify-center">
                        <svg class="w-11 h-11" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5V6.75A2.25 2.25 0 0017.25 4.5H6.75A2.25 2.25 0 004.5 6.75v10.5A2.25 2.25 0 006.75 19.5h10.5a2.25 2.25 0 002.25-2.25V13.5" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9h.008v.008H15V9zM4.5 16.5l4.8-4.8a1.5 1.5 0 012.12 0l2.58 2.58a1.5 1.5 0 002.12 0l3.38-3.38" />
                        </svg>
                    </div>
                </div>
                <h2 class="mt-4 text-3xl font-extrabold text-green-700 tracking-tight">GIS APOTIK</h2>
                <p class="mt-1 text-sm text-green-600/80 font-medium">Panel Admin</p>
            </div>

            <nav class="px-5 py-6 space-y-1.5 text-base leading-tight">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5.5v-6h-5v6H4a1 1 0 01-1-1v-9.5z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.data-apotek') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.data-apotek') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0117.25 21H6.75a2.25 2.25 0 01-2.25-2.25V5.25z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 7.5h7.5M8.25 12h7.5M8.25 16.5h4.5" />
                    </svg>
                    Data Apotik
                </a>
                <a href="{{ route('admin.search-apotek') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.search-apotek') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search Apotik
                </a>

                <div
                    class="pt-3 pb-1 px-3 flex items-center gap-2 text-[11px] uppercase tracking-[0.18em] text-gray-400">
                    <span class="h-px flex-1 bg-green-100"></span>
                    <span>Master Data</span>
                    <span class="h-px flex-1 bg-green-100"></span>
                </div>

                <a href="{{ route('admin.apotek.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.apotek.*') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 21h18M5 21V9l7-4 7 4v12M9 13h6M9 17h6" />
                    </svg>
                    Apotik
                </a>
                <a href="{{ route('admin.kecamatan.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.kecamatan.*') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.6 9h16.8M3.6 15h16.8M12 3a15.3 15.3 0 014.5 9A15.3 15.3 0 0112 21a15.3 15.3 0 01-4.5-9A15.3 15.3 0 0112 3z" />
                    </svg>
                    Kecamatan
                </a>
                <a href="{{ route('admin.peta.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.peta.*') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 6.75L3.75 5.25v12L9 18.75m0-12l6 1.5m-6-1.5v12m6-10.5l5.25-1.5v12L15 20.25m0-12v12" />
                    </svg>
                    Peta Apotik
                </a>
            </nav>
        </aside>

        <div class="flex-1 min-w-0 overflow-x-hidden">
            <header
                class="h-16 border-b border-gray-300 bg-white px-4 md:px-8 xl:px-10 flex items-center justify-between">
                <p class="md:hidden text-sm font-semibold text-green-700">ADMIN GIS APOTIK</p>

                <div class="ml-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg border border-gray-200 hover:border-red-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4 md:p-6 lg:p-8 overflow-x-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- jQuery & Select2 JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
    </script>

    @stack('scripts')
</body>

</html>