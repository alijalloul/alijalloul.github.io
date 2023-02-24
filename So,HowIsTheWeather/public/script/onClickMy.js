myWeather.addEventListener('click', () => {
    country.innerText = userCountry;
    village.innerText = userVillage;
    lat.innerText = userLatLon.userLat.toFixed(2);
    lon.innerText = userLatLon.userLon.toFixed(2);
    weatherDesc.innerText = userWeatherDesc;
    temp.innerText = userTemperature;
    altitude.innerText = userAltitude;

    weatherInfo.style.display = "flex";
    weatherInfo.style.flex = "1 1 0";
    weatherInfo.style.color = "black";

    setTimeout(() =>{
        map.invalidateSize();
        map.panTo(new L.LatLng(userLatLon.userLat, userLatLon.userLon));
    },300);
});
