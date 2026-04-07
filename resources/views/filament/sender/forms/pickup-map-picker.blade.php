<div class="space-y-2">
    <div class="text-sm font-medium text-gray-900">Pickup Map Picker</div>
    <p class="text-xs text-gray-500">Click the map to auto-fill pickup address, latitude, and longitude.</p>
    <div id="sender-pickup-map-picker" class="rounded-xl border border-gray-200" style="height: 400px; width: 100%;"></div>
</div>

@once
    <script>
        const initPickupMapPicker = () => {
            if (! window.L) {
                return;
            }

            const mapElement = document.getElementById('sender-pickup-map-picker');
            if (! mapElement || mapElement.dataset.initialized === '1') {
                return;
            }

            mapElement.dataset.initialized = '1';

            const defaultLat = 6.5244;
            const defaultLng = 3.3792;
            const map = L.map('sender-pickup-map-picker').setView([defaultLat, defaultLng], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(map);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        map.setView([position.coords.latitude, position.coords.longitude], 13);
                        setTimeout(() => map.invalidateSize(), 150);
                    },
                    () => {
                        map.setView([defaultLat, defaultLng], 11);
                        setTimeout(() => map.invalidateSize(), 150);
                    }
                );
            } else {
                map.setView([defaultLat, defaultLng], 11);
                setTimeout(() => map.invalidateSize(), 150);
            }

            let marker = null;

            map.on('click', (event) => {
                const lat = Number(event.latlng.lat.toFixed(7));
                const lng = Number(event.latlng.lng.toFixed(7));

                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }

                const wireRoot = mapElement.closest('[wire\\:id]');
                const componentId = wireRoot ? wireRoot.getAttribute('wire:id') : null;
                const component = componentId ? window.Livewire.find(componentId) : null;

                if (! component) {
                    return;
                }

                component.set('data.pickup_lat', lat);
                component.set('data.pickup_lng', lng);
                component.set('data.pickup_address', `Selected point (${lat}, ${lng})`);
            });
        };

        document.addEventListener('DOMContentLoaded', initPickupMapPicker);
        document.addEventListener('livewire:navigated', initPickupMapPicker);
        document.addEventListener('livewire:update', initPickupMapPicker);
    </script>
@endonce
