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
                        const label = m.name ?? m.title ?? 'Runner';
                        const marker = L.marker([m.lat, m.lng]).bindPopup(`<b>${label}</b>`);
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
    >
        <div style="position: fixed; top: 20px; right: 20px; z-index: 1000; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 240px;">
            <div style="font-weight: 600; margin-bottom: 6px;">Runner Radius Filter</div>
            <div style="font-size: 13px; color: #4b5563; margin-bottom: 6px;">Radius: <span x-text="radiusMiles"></span> miles</div>
            <input type="range" min="1" max="50" x-model="radiusMiles" style="width: 100%;" />
            <a href="{{ $postErrandUrl }}" style="display:block;margin-top:10px;color:#2563eb;text-decoration:underline;">Post New Errand</a>
        </div>

        <div x-ref="mapContainer" style="height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: 1;"></div>
    </div>
</x-filament-widgets::widget>
