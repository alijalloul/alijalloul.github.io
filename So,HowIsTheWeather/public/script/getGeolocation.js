let userCountry, userVillage, userLatLon, userTemperature, userWeatherDesc, userAltitude;

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(async (position) => {
        userLatLon = {};
        
        const userLat = position.coords.latitude;
        const userLon = position.coords.longitude;

        userLatLon = { userLat, userLon };

        const weatherURL = `https://api.open-meteo.com/v1/forecast?latitude=${userLat}&longitude=${userLon}&current_weather=true`;
        const weatherResponse = await fetch(weatherURL);
        const weatherJSON = await weatherResponse.json();

        const countryURL = `https://nominatim.openstreetmap.org/reverse?lat=${userLat}&lon=${userLon}&format=json`;
        const countryResponse = await fetch(countryURL);
        const countryJSON = await countryResponse.json();
        
        console.log(weatherJSON);

        document.getElementById("userLat").textContent = userLat.toFixed(2);
        document.getElementById("userLon").textContent = userLon.toFixed(2);

        userCountry = countryJSON.address.country;
        userAltitude = weatherJSON.elevation;

        if(countryJSON.address.city){
            userVillage = countryJSON.address.city
        }else if(countryJSON.address.village){
            userVillage = countryJSON.address.village;
        }else{
            userVillage = countryJSON.address.town;
        }

        userTemperature = weatherJSON.current_weather.temperature;

        switch (weatherJSON.current_weather.weathercode){
            case 0:
                userWeatherDesc = "Clear sky";
                break;
            case 1:
                userWeatherDesc = "Mainly clear";
                break;
            case 2:
                userWeatherDesc = "partly cloudy";
                break;
            case 3:
                userWeatherDesc = "overcast";
                break;
            case 45:
                userWeatherDesc = "Fog";
                break;
            case 48:
                userWeatherDesc = "depositing rime fog";
                break;
            case 51:
                userWeatherDesc = "Light Drizzle";
                break;
            case 53:
                userWeatherDesc = "Moderate Drizzle";
                break;
            case 55:
                userWeatherDesc = "Dense Drizzle";
                break;
            case 56:
                userWeatherDesc = "Light Freezing Drizzle";
                break;
            case 57:
                userWeatherDesc = "Dense Freezing Drizzle";
                break;
            case 61:
                userWeatherDesc = "Slight Rain";
                break;
            case 63:
                userWeatherDesc = "Moderate Rain";
                break;
            case 65:
                userWeatherDesc = "Heavy Rain";
                break;
            case 66:
                userWeatherDesc = "Light Freezing Rain";
                break;
            case 67:
                userWeatherDesc = "Heavy Freezing Rain";
                break;
            case 71:
                userWeatherDesc = "Sligh Snow Fall";
                break;
            case 73:
                userWeatherDesc = "Moderate Snow Fall";
                break;
            case 75:
                userWeatherDesc = "Heavy Snow Fall";
                break;
            case 77:
                userWeatherDesc = "Snow Grains";
                break;
            case 80:
                userWeatherDesc = "Slight Rain Showers";
                break;
            case 81:
                userWeatherDesc = "Moderate Rain Showers";
                break;
            case 82:
                userWeatherDesc = "Heavy Rain Showers";
                break;
            case 85:
                userWeatherDesc = "Slight Snow Showers";
                break;
            case 86:
                userWeatherDesc = "Heavy Rain Showers";
                break;
            case 95:
                userWeatherDesc = "Slight Thunderstorm";
                break;
            case 100:
                userWeatherDesc = "Moderate Thunderstorm";
                break;
            case 96:
                userWeatherDesc = "Thunderstor with slight Hail";
                break;
            case 99:
                userWeatherDesc = "Thunderstorm with Heavy Hail";
                break;
        }

        userCountry ? userCountry : userCountry = "N/A";
        userVillage ? userVillage : userVillage = "N/A";
        userLatLon ? userLatLon : userLatLon = {lat: 0, lon: 0};
        userTemperature ? userTemperature : userTemperature = 0;
        userWeatherDesc ? userWeatherDesc : userWeatherDesc =  0;
        userAltitude ? userAltitude : userAltitude = 0;

        fetch("/userLoc", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                },
            body: JSON.stringify({userCountry, userVillage, userLatLon, userTemperature, userWeatherDesc,userAltitude}),
        }).then(response => {
            response.json().then(data => {
                console.log(data);
            });
        });
    });
}else{
    alert("Geolocation is not available");
}