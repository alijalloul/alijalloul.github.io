let searchForm = document.getElementById("searchForm");

searchForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    
    let query = document.getElementById("search_box").value;

    weatherInfo.style.color = "transparent" 
    
    let locationCountry, locationVillage, locationLatLon, locationTemperature, locationWeatherDesc, locationAltitude;

    const countryURL = `https://nominatim.openstreetmap.org/search?q=${query}&format=json`;
    const countryResponse = await fetch(countryURL);
    const countryJSON = await countryResponse.json();

    locationCountry = countryJSON[0].display_name.toString().replace('"','').split(", ").pop();
    locationVillage = countryJSON[0].display_name.toString().replace('"','').split(", ")[0];
    locationLatLon = {lat: countryJSON[0].lat, lon: countryJSON[0].lon};

    map.panTo(new L.LatLng(locationLatLon.lat, locationLatLon.lon));
    marker.setLatLng(new L.LatLng(locationLatLon.lat, locationLatLon.lon));

    console.log("countryJSON[0]", countryJSON[0],locationLatLon.lat);

    const weatherURL = `https://api.open-meteo.com/v1/forecast?latitude=${locationLatLon.lat}&longitude=${locationLatLon.lon}&current_weather=true`;
    const weatherResponse = await fetch(weatherURL);
    const weatherJSON = await weatherResponse.json(); 

    locationAltitude = weatherJSON.elevation;
    locationTemperature = weatherJSON.current_weather.temperature;

    switch (weatherJSON.current_weather.weathercode){
        case 0:
            locationWeatherDesc = "Clear sky";
            break;
        case 1:
            locationWeatherDesc = "Mainly clear";
            break;
        case 2:
            locationWeatherDesc = "partly cloudy";
            break;
        case 3:
            locationWeatherDesc = "overcast";
            break;
        case 45:
            locationWeatherDesc = "Fog";
            break;
        case 48:
            locationWeatherDesc = "depositing rime fog";
            break;
        case 51:
            locationWeatherDesc = "Light Drizzle";
            break;
        case 53:
            locationWeatherDesc = "Moderate Drizzle";
            break;
        case 55:
            locationWeatherDesc = "Dense Drizzle";
            break;
        case 56:
            locationWeatherDesc = "Light Freezing Drizzle";
            break;
        case 57:
            locationWeatherDesc = "Dense Freezing Drizzle";
            break;
        case 61:
            locationWeatherDesc = "Slight Rain";
            break;
        case 63:
            locationWeatherDesc = "Moderate Rain";
            break;
        case 65:
            locationWeatherDesc = "Heavy Rain";
            break;
        case 66:
            locationWeatherDesc = "Light Freezing Rain";
            break;
        case 67:
            locationWeatherDesc = "Heavy Freezing Rain";
            break;
        case 71:
            locationWeatherDesc = "Sligh Snow Fall";
            break;
        case 73:
            locationWeatherDesc = "Moderate Snow Fall";
            break;
        case 75:
            locationWeatherDesc = "Heavy Snow Fall";
            break;
        case 77:
            locationWeatherDesc = "Snow Grains";
            break;
        case 80:
            locationWeatherDesc = "Slight Rain Showers";
            break;
        case 81:
            locationWeatherDesc = "Moderate Rain Showers";
            break;
        case 82:
            locationWeatherDesc = "Heavy Rain Showers";
            break;
        case 85:
            locationWeatherDesc = "Slight Snow Showers";
            break;
        case 86:
            locationWeatherDesc = "Heavy Rain Showers";
            break;
        case 95:
            locationWeatherDesc = "Slight Thunderstorm";
            break;
        case 100:
            locationWeatherDesc = "Moderate Thunderstorm";
            break;
        case 96:
            locationWeatherDesc = "Thunderstor with slight Hail";
            break;
        case 99:
            locationWeatherDesc = "Thunderstorm with Heavy Hail";
            break;
    }

    locationCountry ? locationCountry : locationCountry = "N/A";
    locationVillage ? locationVillage : locationVillage = "N/A";
    locationLatLon ? locationLatLon : locationLatLon = {lat: 0, lon: 0};
    locationTemperature ? locationTemperature : locationTemperature = 0;
    locationWeatherDesc ? locationWeatherDesc : locationWeatherDesc =  0;
    locationAltitude ? locationAltitude : locationAltitude = 0;

    country.innerText = locationCountry;
    village.innerText = locationVillage;
    lat.innerText = parseFloat(locationLatLon.lat).toFixed(2);
    lon.innerText = parseFloat(locationLatLon.lon).toFixed(2);
    weatherDesc.innerText = locationWeatherDesc;
    temp.innerText = locationTemperature;
    altitude.innerText = locationAltitude;

    

    fetch("/manualMarker", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            },
        body: JSON.stringify({locationCountry, locationVillage, locationLatLon, locationTemperature, locationWeatherDesc, locationAltitude}),
    }).then(response => {
        response.json().then(data => {
            console.log(data);
        });

        weatherInfo.style.display = "flex";
        weatherInfo.style.flex = "1 1 0";
        weatherInfo.style.color = "black";
    });
});