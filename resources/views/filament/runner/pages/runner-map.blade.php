<x-filament-panels::page>
    <div
        class="fixed inset-0 z-10"
        x-data="{
            map: null,
            markers: @js($markers ?? []),
            markerPool: [],
            mobileMenuOpen: false,
            init() {
                this.hideFilamentSidebar();

                const timer = setInterval(() => {
                    if (window.L) {
                        clearInterval(timer);
                        this.setupMap();
                    }
                }, 120);

                this.$watch('mobileMenuOpen', () => {
                    setTimeout(() => this.invalidateMap(), 250);
                });
            },
            hideFilamentSidebar() {
                document.querySelectorAll('.fi-sidebar, .fi-sidebar-nav, .fi-main-ctn > .fi-sidebar').forEach((el) => {
                    el.classList.add('hidden');
                });
                document.querySelectorAll('.fi-topbar').forEach((el) => {
                    el.classList.add('bg-transparent', 'shadow-none', 'border-none');
                });
            },
            setupMap() {
                this.map = L.map(this.$refs.mapContainer, { zoomControl: true }).setView([6.5244, 3.3792], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this.map);

                this.markerPool = this.markers
                    .filter(m => m.lat && m.lng)
                    .map(m => {
                        const marker = L.marker([m.lat, m.lng]).bindPopup(`<b>${m.title}</b><br/>Budget: ${m.budget} USDT<br/><a href='${m.url}' style='text-decoration:underline'>Open</a>`);
                        marker.addTo(this.map);
                        return marker;
                    });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        this.map.setView([lat, lng], 15);
                        L.circleMarker([lat, lng], { radius: 7, color: '#22c55e', fillOpacity: 0.9 }).addTo(this.map).bindPopup('You are here');
                        $wire.call('updateLocation', lat, lng);
                    });
                }

                this.invalidateMap();
            },
            invalidateMap() {
                if (this.map) {
                    this.map.invalidateSize();
                }
            },
        }"
        x-init="init()"
    >
        <div x-ref="mapContainer" class="absolute inset-0 h-screen w-screen"></div>

        <div
            x-show="mobileMenuOpen"
            x-transition.opacity
            class="absolute inset-0 z-30 bg-black/25 backdrop-blur-sm md:hidden"
            @click="mobileMenuOpen = false"
        ></div>

        <button
            type="button"
            class="absolute left-4 top-4 z-40 inline-flex h-11 w-11 items-center justify-center rounded-xl border border-white/30 bg-white/70 text-slate-800 backdrop-blur-md md:hidden"
            @click="mobileMenuOpen = true"
            aria-label="Open navigation"
        >
            <span class="block h-0.5 w-5 rounded bg-slate-800"></span>
            <span class="sr-only">Menu</span>
        </button>

        <aside
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
            class="absolute left-0 top-0 z-40 h-full w-72 border-r border-white/20 bg-slate-900/80 p-6 text-white backdrop-blur-xl md:hidden"
        >
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Runner Menu</h2>
                <button type="button" class="rounded-md px-2 py-1 text-white/80" @click="mobileMenuOpen = false">Close</button>
            </div>

            <nav class="space-y-3">
                <a href="{{ $links['map'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-white/10"><span>🗺️</span><span>Map</span></a>
                <a href="{{ $links['available'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-white/10"><span>📋</span><span>Available</span></a>
                <a href="{{ $links['myErrands'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-white/10"><span>📁</span><span>My Errands</span></a>
                <a href="{{ $links['reviews'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-white/10"><span>⭐</span><span>Reviews</span></a>
            </nav>
        </aside>

        <nav class="pointer-events-auto absolute bottom-6 left-1/2 z-40 hidden -translate-x-1/2 items-center gap-2 rounded-full border border-white/20 bg-white/70 px-3 py-2 backdrop-blur-md md:flex">
            <a href="{{ $links['map'] }}" class="flex min-w-16 flex-col items-center rounded-full px-3 py-2 text-slate-800 hover:bg-white/70">
                <span class="text-xl leading-none">🗺️</span>
                <span class="text-[11px] font-medium">Map</span>
            </a>
            <a href="{{ $links['available'] }}" class="flex min-w-16 flex-col items-center rounded-full px-3 py-2 text-slate-800 hover:bg-white/70">
                <span class="text-xl leading-none">📋</span>
                <span class="text-[11px] font-medium">Available</span>
            </a>
            <a href="{{ $links['myErrands'] }}" class="flex min-w-16 flex-col items-center rounded-full px-3 py-2 text-slate-800 hover:bg-white/70">
                <span class="text-xl leading-none">📁</span>
                <span class="text-[11px] font-medium">My Errands</span>
            </a>
            <a href="{{ $links['reviews'] }}" class="flex min-w-16 flex-col items-center rounded-full px-3 py-2 text-slate-800 hover:bg-white/70">
                <span class="text-xl leading-none">⭐</span>
                <span class="text-[11px] font-medium">Reviews</span>
            </a>
        </nav>
    </div>
</x-filament-panels::page>
