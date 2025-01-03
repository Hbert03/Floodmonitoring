function fetchStationData(stationId, updateFunction) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'graph_function.php?station=' + stationId, true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            var data = JSON.parse(xhr.responseText);
            updateFunction(data);  
        }
    };
    xhr.onerror = function () {
        console.error('Request failed for station ' + stationId + ' data.');
    };
    xhr.send();
}

function updateChart(chartInstance, ctxId, data, label) {
    var ctx = document.getElementById(ctxId).getContext('2d');

    if (chartInstance instanceof Chart) {
        // Update existing chart
        chartInstance.data.labels = data.labels;
        chartInstance.data.datasets[0].data = data.values;
        chartInstance.update();
    } else {
        // Create a new chart
        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: label,
                    data: data.values,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {  // Updated for Chart.js v3+
                        ticks: {
                            beginAtZero: true
                        }
                    }
                }
            }
        });
    }
    return chartInstance;
}

// Variables to hold chart instances
var station1Chart, station2Chart, station3Chart;

// Fetch and update functions for each station
function updateStation1(data) {
    station1Chart = updateChart(station1Chart, 'station1', data, 'Water Level - Station 1');
}

function updateStation2(data) {
    station2Chart = updateChart(station2Chart, 'station2', data, 'Water Level - Station 2');
}

function updateStation3(data) {
    station3Chart = updateChart(station3Chart, 'station3', data, 'Water Level - Station 3');
}

// Initial data fetch and interval setup
fetchStationData(1, updateStation1);
fetchStationData(2, updateStation2);
fetchStationData(3, updateStation3);

setInterval(() => fetchStationData(1, updateStation1), 10000);
setInterval(() => fetchStationData(2, updateStation2), 10000);
setInterval(() => fetchStationData(3, updateStation3), 10000);
