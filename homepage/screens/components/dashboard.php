<div class="card bg-white p-3 shadow m-5">
    <h1 class="text-dark text-center">Station 1</h1>
    <div class="row p-2 w-100">
      <div class="card col mx-4 bg-white shadow text-dark ">
        <h3 class="text-center mt-4">Data - Station 1</h3>
        <canvas id="myChartStation1"></canvas>
      </div>
      <div class="card col mx-4 bg-white shadow d-flex justify-content-center text-dark ">
        <h3 class="text-center my-4">Current Water Level</h3>
        <div class="gauge-container my-4">
        <div class="station_1_gauge"></div>
      </div>
      </div>
      <div class="card col mx-4 bg-white shadow d-flex justify-content-center text-dark ">
        <h3 class="text-center my-4">Rainfall:</h3>
        <div class="gauge-container my-4">
          <div class="station_1_gauge"></div>
        </div>
      </div>
    </div>
    </div>


    
    <script src="../script.js"></script>
    <script>
      $(document).ready(()=>{
        const canvas = document.getElementById('myChartStation1');
        canvas.height = "200";
        canvas.width = "200";

        const labels = [
        ];

const data = {
  labels: labels,
  datasets: [{
    label: 'Water level',
    backgroundColor: '#222629',
    borderColor: '#48525a',
    //cubicInterpolationMode: 'monotone',
    tension: 0.25
  },
  {
    label: 'Rainfall',
    backgroundColor: '#5a102f',
    borderColor: '#5a102f',
    //cubicInterpolationMode: 'monotone',
    tension: 0.25
  },
  
]
};

const config = {
  type: 'line',
  data: data,
  options: {}
};

const myChartStation1 = new Chart(
  canvas,
  config
);

// function to update the chart 
function addWaterLevelData(chart, label, data) {
  chart.data.labels.push(label);
  const waterLevelDataSet = chart.data.datasets[0];
  waterLevelDataSet.data.push(data);
  chart.update();
}
function addRainfallData(chart, label, data) {
  chart.data.labels.push(label);
  const rainfalllDataSet = chart.data.datasets[1];
  rainfalllDataSet.data.push(data);
  chart.update();
}


addWaterLevelData(myChartStation1, 0.0, 0);
addRainfallData(myChartStation1, 0.0, 0);

    //We call this function to get the initial data
$.post("../../ajax.php",{action:"get_water_level_log",station:1},(data)=>{
        var water_level_log_data =JSON.parse(data);
        myChartStation1.data.labels = [];
        myChartStation1.data.datasets[0].data = [];
        myChartStation1.data.datasets[1].data = [];
        water_level_log_data.forEach(water_level_data => {
            const date = new Date(water_level_data.date_acquired);
            const formatDate = date.toLocaleString();
            const newLabel = formatDate;
            const newData = water_level_data.distance_cm;
            const rainfallData = water_level_data.raindrop;
            addWaterLevelData(myChartStation1, newLabel, newData);
            addRainfallData(myChartStation1, newLabel, rainfallData);
        });
    });

    //We call this function to refresh data from the water level log every 2 seconds
    setInterval(function() {
        $.post("../../ajax.php",{action:"get_water_level_log",station:1},(data)=>{
            var water_level_log_data =JSON.parse(data);
            myChartStation1.data.labels = [];
            myChartStation1.data.datasets[0].data = [];
            myChartStation1.data.datasets[1].data = [];
            water_level_log_data.forEach(water_level_data => {
                const date = new Date(water_level_data.date_acquired);
                const formatDate = date.toLocaleString();
                const newLabel = formatDate;
                const newData = water_level_data.distance_cm;
                const rainfallData = water_level_data.raindrop;
                addWaterLevelData(myChartStation1, newLabel, newData);
                addRainfallData(myChartStation1, newLabel, rainfallData);
            });
        });
    }, 2000);
      });
    </script>