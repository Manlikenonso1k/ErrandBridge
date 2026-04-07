<x-filament-widgets::widget>
    <div
        wire:ignore
        x-data="{
            map: null,
            userLat: null,
            userLng: null,
            userMarker: null,
            radiusMiles: @js($radiusMiles ?? 10),
            radiusCircle: null,
            markerPool: [],
            markers: @js($markers ?? []),
            init() {
                let timer = setInterval(() => {
                    if (window.L) {
                        clearInterval(timer);
                        this.setupMap();
                        this.$watch('radiusMiles', value => {
                            this.updateRadius();
                            $wire.set('radiusMiles', Number(value));
                        });
                    }
                }, 200);
            },
            setupMap() {
                this.map = L.map(this.$refs.mapContainer).setView([6.5244, 3.3792], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this.map);

                this.markerPool = this.markers
                    .filter(m => m.lat && m.lng)
                    .map(m => {
                        const marker = L.marker([m.lat, m.lng]).bindPopup(`<b>${m.title}</b><br><a href='${m.url}' style='color:blue;text-decoration:underline;'>View</a>`);
                        marker.addTo(this.map);
                        return marker;
                    });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        this.userLat = position.coords.latitude;
                        this.userLng = position.coords.longitude;
                        this.map.setView([this.userLat, this.userLng], 15);
                        this.userMarker = L.marker([this.userLat, this.userLng]).addTo(this.map).bindPopup('You are here').openPopup();
                        $wire.call('updateLocation', this.userLat, this.userLng);
                        this.updateRadius();
                    }, () => {
                        this.userLat = 6.5244;
                        this.userLng = 3.3792;
                        this.updateRadius();
                    });
                } else {
                    this.userLat = 6.5244;
                    this.userLng = 3.3792;
                    this.updateRadius();
                }
            },
            updateRadius() {
                if (!this.map || this.userLat === null || this.userLng === null) {
                    return;
                }

                let meters = Number(this.radiusMiles) * 1609.34;
                let userLatLng = L.latLng(this.userLat, this.userLng);

                if (this.radiusCircle) {
                    this.radiusCircle.setLatLng(userLatLng);
                    this.radiusCircle.setRadius(meters);
                } else {
                    this.radiusCircle = L.circle(userLatLng, {
                        radius: meters,
                        color: '#3b82f6',
                        fillColor: '#3b82f6',
                        fillOpacity: 0.1,
                    }).addTo(this.map);
                }

                this.markerPool.forEach((marker) => {
                    let distance = this.map.distance(userLatLng, marker.getLatLng());
                    if (distance > meters) {
                        if (this.map.hasLayer(marker)) {
                            this.map.removeLayer(marker);
                        }
                    } else if (!this.map.hasLayer(marker)) {
                        marker.addTo(this.map);
                    }
                });
            },
        }"
        x-init="init()"
        class="relative rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900"
    >
        <div class="mb-3 flex items-center justify-between gap-3">
            <div>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Errand Radius Filter</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Radius: <span x-text="radiusMiles"></span> miles</div>
            </div>
            <div class="w-48">
                <input type="range" min="1" max="50" x-model="radiusMiles" class="w-full" />
            </div>
        </div>

        <div
            x-ref="mapContainer"
            class="w-full rounded-lg border border-gray-200 dark:border-gray-700"
            style="height: 520px;"
        ></div>
    </div>
</x-filament-widgets::widget>
