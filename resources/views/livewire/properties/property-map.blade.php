<div>
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
    <div id="propertyMap" class="w-full h-64 bg-gray-100 z-0"></div>
    
    <div class="p-4">
        <h4 class="font-semibold text-gray-900 mb-2">Location</h4>
        <p class="text-sm text-gray-600 mb-3">{{ $property->address ?? '' }}, {{ $property->city ?? '' }}</p>
        
        @if(isset($nearbyPlaces) && count($nearbyPlaces) > 0)
        <div class="space-y-2">
            <h5 class="text-xs font-medium text-gray-500 uppercase">What's nearby</h5>
            @foreach($nearbyPlaces as $place)
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-700">{{ $place['name'] }}</span>
                <span class="text-gray-500">{{ $place['distance'] }}</span>
            </div>
            @endforeach
        </div>
        @endif
        
        @if(isset($safetyScore))
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Safety Score:</span>
                <span class="px-2 py-1 rounded text-xs font-medium {{ $safetyScore >= 8 ? 'bg-green-100 text-green-700' : ($safetyScore >= 5 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                    {{ $safetyScore }}/10
                </span>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for Leaflet to be available
        function initMap() {
            if (typeof L === 'undefined') {
                setTimeout(initMap, 100);
                return;
            }
            
            var mapContainer = document.getElementById('propertyMap');
            if (!mapContainer) return;
            
            var lat = {{ $property->latitude ?? 13.4545 }};
            var lng = {{ $property->longitude ?? -15.5978 }};
            var title = {!! json_encode($property->title ?? 'Property') !!};
            var address = {!! json_encode($property->address ?? '') !!};
            
            // Create map
            var map = L.map('propertyMap', {
                zoomControl: true,
                scrollWheelZoom: true
            }).setView([lat, lng], 15);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Custom marker icon
            var icon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background:#FF385C;width:36px;height:36px;border-radius:50%;border:4px solid white;box-shadow:0 3px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;font-size:14px;">🏠</div>',
                iconSize: [36, 36],
                iconAnchor: [18, 36],
                popupAnchor: [0, -36]
            });
            
            // Add marker with popup
            var marker = L.marker([lat, lng], { icon: icon }).addTo(map);
            marker.bindPopup('<div style="min-width:150px"><strong>' + title + '</strong><br><small>' + address + '</small></div>').openPopup();
        }
        
        // Initialize map after a small delay to ensure DOM is ready
        setTimeout(initMap, 200);
    });
</script>

<style>
    #propertyMap {
        min-height: 256px;
    }
    #propertyMap .leaflet-container {
        height: 100%;
        width: 100%;
        border-radius: 0;
    }
    .custom-marker {
        background: transparent !important;
        border: none !important;
    }
</style>
</div>
