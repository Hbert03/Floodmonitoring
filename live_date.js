
$(document).ready(function(){
fetch('weather_function.php')
.then(response => response.json())
.then(locationData => {
    if (locationData.error) {
        document.getElementById('weather').innerHTML = `<p class="error">${locationData.error}</p>`;
        return;
    }
    const locationName = locationData.location_name;
    const weatherUrl = `https://api.weatherapi.com/v1/forecast.json?key=a2229b0bcd0541aaa3b50730242311&q=${locationName}&days=1&aqi=no&alerts=no&`;
    fetch(weatherUrl)
        .then(response => response.json())
        .then(weatherData => {
            const weatherDiv = document.getElementById('weather');
            if (weatherData.error) {
                weatherDiv.innerHTML = `<p class="error">${weatherData.error.message}</p>`;
            } else {
                const { location, current, forecast } = weatherData;
                const iconUrl = `https:${current.condition.icon}`;
                const temperature = current.temp_c;
                const condition = current.condition.text;
                const humidity = current.humidity;
                const windSpeed = current.wind_kph;
                const forecastText = forecast.forecastday[0].day.condition.text;
                const totalPrecipMm = forecast.forecastday[0].day.totalprecip_mm;

       
                document.getElementById('location-name').textContent = 'Location:'+' '+location.name;
                document.getElementById('date-time').textContent = new Date().toLocaleString();
                document.getElementById('weather-icon').src = iconUrl;
                document.getElementById('temperature').textContent = `${temperature}°C`;
                document.getElementById('condition').textContent = condition;
                document.getElementById('humidity').textContent = `Humidity: ${humidity}%`;
                document.getElementById('wind-speed').textContent = `Wind Speed: ${windSpeed} km/h`;

           
                let floodChanceText = "Flood Chance: --%";
                let floodClass = "text-white";  

                if (parseFloat(totalPrecipMm) < 20) {
                    floodClass = "";  
                    floodChanceText = `Flood Chance: ${totalPrecipMm}%`;
                } else if (parseFloat(totalPrecipMm) >= 20 && parseFloat(totalPrecipMm) < 70) {
                    floodClass = "text-warning";  
                    floodChanceText = `Flood Chance: ${totalPrecipMm}%`;
                } else if (parseFloat(totalPrecipMm) >= 70) {
                    floodClass = "text-danger";  
                    floodChanceText = `Flood Chance: ${totalPrecipMm}%`;
                }

                // Update the flood chance display
                const floodElement = document.getElementById('flood-chance');
                floodElement.className = floodClass; 
                floodElement.textContent = floodChanceText;  

                // Display Hourly Forecast
                const hourlyForecast = forecast.forecastday[0].hour;
                const hourlyContainer = document.getElementById('hourly-forecast');
                hourlyContainer.innerHTML = ''; 

                hourlyForecast.forEach((hourData, index) => {
                    const hourTime = new Date(hourData.time);
                    const hourCondition = hourData.condition.text;
                    const hourTemp = hourData.temp_c;
                    const hourIcon = `https:${hourData.condition.icon}`;
                    const precipitation = hourData.precip_mm;

           
                    const hourBlock = document.createElement('div');
                    hourBlock.classList.add('hour-block');

                    let rainType = 'No rain';
                    if (hourCondition.toLowerCase().includes('patchy rain')) {
                        rainType = 'Patchy Rain';
                    } else if (hourCondition.toLowerCase().includes('rain')) {
                        rainType = 'Rain';
                    }

                    hourBlock.innerHTML = `
                        <div class="hour-time">${hourTime.getHours()}:00</div>
                        <img src="${hourIcon}" alt="icon" class="hour-icon">
                        <div class="hour-temp">${hourTemp}°C</div>
                        <div class="hour-condition">${hourCondition}</div>
                        <div class="hour-rain">${rainType}</div>
                        <div class="hour-precip">Precipitation: ${precipitation}mm</div>
                    `;

                    hourlyContainer.appendChild(hourBlock);
                });

                // Update other weather details
                document.getElementById('weather_forecast_text').textContent = forecastText;
                document.getElementById('weather_forecast_text_location').textContent = `in ${location.name}`;
            }
        })
        .catch(error => {
            // console.error('Error fetching weather data:', error);
            document.getElementById('weather').innerHTML = `<p class="error">Error fetching weather data.</p>`;
        });
})
.catch(error => {
    // console.error('Error fetching location data:', error);
    document.getElementById('weather').innerHTML = `<p class="error">Error fetching location data.</p>`;
});
})

document.addEventListener("DOMContentLoaded", function () {
    updateDateTime(); 
    setInterval(updateDateTime, 1000); 
});

setInterval(updateDateTime, 1000);
updateDateTime();