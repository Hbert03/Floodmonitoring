
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will be logged out!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("logoutForm").submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    async function fetchVolumeData() {
        const response = await fetch('get_volume.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=get_last_data'
        });

        const data = await response.json();
        const { stations, total_volume } = data;


        Object.keys(stations).forEach(station => {
            const stationData = stations[station];
            const stationElement = document.getElementById(station.toLowerCase());
            if (stationElement) {
                stationElement.innerText = `${station.toUpperCase()}: Volume = ${stationData.volume_cm3.toFixed(2)} cm³ (Water Level: ${stationData.water_level} cm)`;
            }
        });


        const totalVolumeDiv = document.getElementById('total-volume');
        if (totalVolumeDiv) {
            totalVolumeDiv.innerText = `Total Volume: ${total_volume.toFixed(2)} cm³`;
        } else {
            console.error('The total volume div could not be found!');
        }
    }


    fetchVolumeData();

    setInterval(fetchVolumeData, 5000);
});

$(document).ready(function () {
    
            $("button.save").on("click", function(event){
                event.preventDefault();
                var requiredFilled = true;
                $("#addForm input, #addForm select").each(function() {
                  if ($(this).prop("required") && !$(this).val()) {
                        requiredFilled = false;
                        $(this).addClass("is-invalid");
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });
          
                if (requiredFilled) {
                    $.ajax({
                        url: "function.php",
                        type: "POST",
                        data: $("#addForm").serialize() + "&save=true",
                        success: function(response) {
                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to parse JSON response: " + e,
                                    icon: "error"
                                });
                                return;
                            }
          
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Student Successfully Saved!",
                                    showConfirmButton: true
                                })
                            } else {
                                toastr.error("Verify your Entry: " + response.error);
                            }
                        }
                    });
                } else {
                    toastr.error("Please fill out all required fields.");
                }
            });
   })




$(document).ready(function () {
    $('#sortBy').select({
        placeholder: "Select sort option",
        allowClear: true,
    });

    var table = $('#history').DataTable({
        dom: 'lBfrtip',
        buttons: ['copy', 'excel'],
        serverSide: true,
        lengthChange: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "fetch.php",
            type: "POST",
            data: function (d) {
                d.history = true;
                d.sortby = $('#sortBy').val();
            },
            error: function (xhr, error, thrown) {
                console.log("Ajax Failed: " + thrown);
            }
        },
        columns: [
            {
                "data": "grouped_date",
                "title": "Date",
                "render": function (data, type, row) {
                    if (type === "display" || type === "filter") {
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        return new Date(data).toLocaleDateString('en-US', options);
                    }
                    return data;
                }
            },
            { "data": "average_water_level", "title": "Average Water Level" },
        ],
    });


    $('#sortBy').on('change', function () {
        table.ajax.reload();
    });
});


document.addEventListener('DOMContentLoaded', function () {
    var currentLocation = location.href;
    var menuItem = document.querySelectorAll('#sidebarNav .nav-link');
    var menuLength = menuItem.length;
    for (var i = 0; i < menuLength; i++) {
      if (menuItem[i].href === currentLocation) {
        menuItem[i].classList.add('active');
        if (menuItem[i].closest('.nav-treeview')) {
          menuItem[i].closest('.nav-treeview').parentNode.querySelector('.nav-link').classList.add('active');
        }
      }
    }
  });

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
            console.error('Error fetching weather data:', error);
            document.getElementById('weather').innerHTML = `<p class="error">Error fetching weather data.</p>`;
        });
})
.catch(error => {
    console.error('Error fetching location data:', error);
    document.getElementById('weather').innerHTML = `<p class="error">Error fetching location data.</p>`;
});
})

function updateDateTime() {
    const now = new Date();
    document.getElementById('date-time').textContent = now.toLocaleString();
}

setInterval(updateDateTime, 1000);
updateDateTime();
