let map, marker, newMarker;
let newMarkerLatLon;
let firstTime = 1;

map = L.map('map', { dragging: !L.Browser.mobile, tap: !L.Browser.mobile}).setView([51.5, -0.09],10);
map.attributionControl.setPrefix('');
marker = L.marker([51.5, -0.09]).addTo(map);


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);



map.on("click", function(e){
    if(firstTime){
        newMarker = new L.Marker([e.latlng.lat, e.latlng.lng]).addTo(map);
        
        firstTime = 0;
    }else{
        newMarker.setLatLng(new L.LatLng(e.latlng.lat, e.latlng.lng));
    }
    newMarkerLatLon = {lat: e.latlng.lat, lon: e.latlng.lng};
});

map.invalidateSize();

let checkuserLatLon = setInterval(() => {
    if(userLatLon){
        map.panTo(new L.LatLng(userLatLon.userLat, userLatLon.userLon));
        marker.setLatLng(new L.LatLng(userLatLon.userLat, userLatLon.userLon))

        clearInterval(checkuserLatLon);
    }
}, 1000);