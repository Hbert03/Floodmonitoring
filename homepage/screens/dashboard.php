<?php 
// session_start();
// if (!isset($_SESSION["isLoggedin"])) {
//   header("location:../../../../login.php");
// }
?>

<!doctype html >
<html lang="en" >

<head>
<title>Smart Water Level Alert</title>
<link rel="icon" type="image/x-icon" href="../assets/river.png">
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/js/DataTables/datatables.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body class="bg-dark">
<style>
  *{
    font-family: "Montserrat";
  }
  .card{
    border: 1px solid #b2c9ce;
    border-radius: 16px;
  }
  .weather_hour_card{
    border-right: 1px solid #fff;
    border-left: 1px solid #fff;
    margin: 0%;
    transition: 400ms;
  }
</style>
<div class="shadow navbar nav bg-white  text-dark px-2 py-1" > 
    <!-- <img src="assets/logo.jpg" alt="Tambulig Logo" width="100px"> -->
    <h3>Aurora MDRRMO Flood Alert and Monitoring System</h3> 
    <li class="nav-item dropdown text-black">
          <a class="nav-link dropdown-toggle show h2" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Stations</a>
          <div class="dropdown-menu" data-bs-popper="static">
            <a class="dropdown-item" id="show_dashboard" href="#">Dashboard</a>
            <a class="dropdown-item" id="show_station_1" href="#">Station 1</a>
            <a class="dropdown-item" id="show_station_2" href="#">Station 2</a>
            <a class="dropdown-item" id="show_station_3" href="#">Station 3</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="btn_show_history">Historical Data</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="btn_logout">Log out</a>
        </li>
    <div class="d-flex align-items-center justify-content-center ">
      <svg xmlns="http://www.w3.org/2000/svg" height="42px" viewBox="0 -960 960 960" width="42px" fill="#1f1f1f"><path d="m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Z"/></svg>
   <p id="clock"></p>
    </div>
    
</div> 

<div class="card bg-dark p-3 shadow m-5" id="body-content">
    <h1 class="text-light  text-center mt-2">Realtime Weather Report</h1>
    <div class=" row bg-dark shadow-none p-2 mt-2 mx-3 mb-3 ">
      <div class="card col bg-dark shadow h-75 align-items-center p-3 m-2 shadow-none">
        <div class="row container-fluid align-items-center justify-content-center">
          <div class="col-7">
            <h1 class="text-light" id="weather_forecast_text">...</h1>
            <h3 class="text-light" id="weather_forecast_text_location">in</h3>
            <h5 class="text-light" id="weather_forecast_hour">...</h5>
          </div>
          <div class="col-3 mx-5 mb-4">
                <div class="row m-auto  bg-dark p-3 shadow-none">
                  <img src="../assets/clouds-and-sun.png" id="rainfall_image" alt="Weather icon"  max-width="100px" max-height="100px">
                </div>
                <div class="row m-auto bg-dark  shadow-none">
                  <h1 class="text-white text-center" id="weather_forecast_rain_chance">...</h1>
                </div>
          </div>
        </div>
        <div class="row container-fluid align-items-center justify-content-center overflow-y-scroll" style="height: 300px;" id="forecast_container">
          
        </div>
      </div>
      <div class="card col bg-dark shadow h-75 align-items-center p-3 m-2 shadow-none">
        <div class="row container-fluid align-items-center justify-content-center">
          <div class="col-7">
            <h1 class="text-light">Chance of flooding</h1>
          </div>
          <div class="col-3 mx-5 ">
                <div class="row m-auto bg-dark p-3 shadow-none">
                  <img src="../assets/clouds-and-sun.png" alt="Weather icon"  max-width="100px" max-height="100px">
                </div>
                <div class="row m-auto bg-dark p-3 shadow-none">
                  <h3 class="text-white text-center" id="flood_chance">...</h3>
                </div>
          </div>
         
        </div>
      </div>
      
    </div>
  </div>



  </body>
  <svg width="0" height="0" version="1.1" class="gradient-mask" xmlns="http://www.w3.org/2000/svg">
  <defs>
      <linearGradient id="gradientGauge">
        <stop class="color-red" offset="0%"/>
        <stop class="color-yellow" offset="17%"/>
        <stop class="color-green" offset="40%"/>
        <stop class="color-yellow" offset="87%"/>
        <stop class="color-red" offset="100%"/>
      </linearGradient>
  </defs>  
</svg> 

<script src="../assets/js/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.js"></script>
<script src='https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js'></script>
<script>
    $(document).ready(()=>{
      $("#show_station_1").click(()=>{
        $("#body-content").load("components/station_1_data.php");
      });
      $("#btn_show_history").click(()=>{
        $("#body-content").load("components/history.php");
      });
      $("#show_dashboard").click(()=>{
        window.location.reload();
      });
      $("#show_station_2").click(()=>{
        $("#body-content").load("components/station_2_data.php");
      });
      $("#show_station_3").click(()=>{
        $("#body-content").load("components/station_3_data.php");
      });
      $("#btn_logout").click(()=>{
        $.post("../../ajax.php",{action:"log_out"},()=>{
          window.location.href ="../../";
        });
      });
      $("#station_content").load("components/station_1_data.php",()=>{

});
    //   $("#station_display_selection").change((e)=>{
    //     let selected_station = e.target.value;
        
    //     if (selected_station == 1) {
    //           $("#station_content").load("components/station_1_data.php",()=>{

    //     });
    //     }
    //     else if (selected_station == 2) {
    //           $("#station_content").load("components/station_2_data.php",()=>{

    //     });
          
    //     }
    //     else if (selected_station == 3) {
          
    //       $("#station_content").load("components/station_3_data.php",()=>{

    //     });
    //   }uyiuy
    // }); 
      $.post("../../ajax.php",{action:"get_default_location"},(location)=>{
        let locationData = JSON.parse(location);
        
      fetch("https://api.weatherapi.com/v1/forecast.json?key=a2229b0bcd0541aaa3b50730242311&q="+locationData.location_name+"&days=1&aqi=no&alerts=no").then((response)=>{
        if (response.ok) {
          return response.json();
        }
      }).then((data)=>{
    
    let current = data.current;
    let currentCondition = current.condition;
    console.table(data);
    let currentHourlyForecast =data.forecast.forecastday[0].hour;
    $("#forecast_container").empty();
    $("#weather_forecast_hour").text(new Date().toLocaleTimeString());
    currentHourlyForecast.forEach((hourlyForecast,index)=>{

        let time =new Date(hourlyForecast.time);

        $("#forecast_container").append($("<div class=\" d-flex align-items-center align-content-center my-2 text-light\"></div>")
        .append("<h3>"+time.toLocaleTimeString()+"</h3>")
        .append("<img src=\""+hourlyForecast.condition.icon+"\">")
        .append("<p>"+hourlyForecast.condition.text+"</p>")
        );
      
    });
    let currentForecast =data.forecast.forecastday[0].day;
    let forecastText =currentForecast.condition.text;
    let forecastImage =currentForecast.condition.icon;
    let forecastChanceOfRain =currentForecast.daily_chance_of_rain;
    console.log(currentForecast);
    $("#rainfall_image").attr("src",forecastImage);
    $("#weather_forecast_rain_chance").text(forecastChanceOfRain + " %");
    if(parseFloat(currentForecast.totalprecip_mm) < 20){
      $("#flood_chance").removeClass("text-white");
      $("#flood_chance").addClass("text-success");

    }
    else if (parseFloat(currentForecast.totalprecip_mm) >= 20 && parseFloat(currentForecast.totalprecip_mm) < 70) {
      $("#flood_chance").removeClass("text-white");
      $("#flood_chance").addClass("text-warning");
    }
    
    else if (parseFloat(currentForecast.totalprecip_mm) >= 70 ) {
      $("#flood_chance").removeClass("text-white");
      $("#flood_chance").addClass("text-danger");
    }
    $("#flood_chance").text(parseFloat(currentForecast.totalprecip_mm) + " %");
    $("#weather_forecast_text").text(forecastText);
    $("#weather_forecast_text_location").text("in "+data.location.name);
  });
      });

setInterval(function() {
  document.getElementById("clock").innerHTML =  new Date().toUTCString();
}, 1000);
    });

</script>
</html>