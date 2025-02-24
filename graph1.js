document.addEventListener("DOMContentLoaded", function () {
    var timeRangeSelect = document.getElementById("timeRange");
    var waterLevelChart1;
    // var chartDescription = document.getElementById("chartDescription");

    function fetchAllStationsData(timeRange, updateFunction) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "graph.php?time_range=" + timeRange, true);
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                var data = JSON.parse(xhr.responseText);
                updateFunction(data);
            }
        };
        xhr.onerror = function () {
            console.error("Request failed to fetch stations data.");
        };
        xhr.send();
    }
    
    function updateChart(chartInstance, ctxId, data) {
        var ctx = document.getElementById(ctxId).getContext("2d");
    
        if (chartInstance instanceof Chart) {
            chartInstance.destroy();
        }
        var chartInstance = new Chart(ctx, {
            type: "line",
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: "Station 1 Water Level",
                        data: data.stations.station1.values,
                        borderColor: "rgba(54, 162, 235, 1)",
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderWidth: 1
                    },
                    {
                        label: "Station 2 Water Level",
                        data: data.stations.station2.values,
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        borderWidth: 1
                    },
                    {
                        label: "Station 3 Water Level",
                        data: data.stations.station3.values,
                        borderColor: "rgb(77, 192, 75)",
                        backgroundColor: "rgba(243, 175, 2, 0.2)",
                        borderWidth: 1
                    },
                    {
                        label: "Flood Warning Level (210cm)",
                        data: new Array(data.labels.length).fill(210),
                        borderColor: "orange",
                        borderDash: [5, 5],
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: "Critical Level (279cm)",
                        data: new Array(data.labels.length).fill(279),
                        borderColor: "red",
                        borderDash: [5, 5],
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{  
                        scaleLabel: {
                            display: true,
                            labelString: "Date/Time" 
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{  
                        scaleLabel: {
                            display: true,
                            labelString: "Water Level (cm)" 
                        },
                        ticks: {
                            beginAtZero: true,
                            max: 300
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: "bottom"
                }
            }
        });
        
    
        return chartInstance;
    }
    
    
    // Initialize chart with default time range
    fetchAllStationsData("hour", (data) => {
        waterLevelChart1 = updateChart(waterLevelChart1, "waterLevelChart1", data);
    });

    // Auto-refresh every 10 seconds
    setInterval(() => {
        var selectedTimeRange = timeRangeSelect.value;
        fetchAllStationsData(selectedTimeRange, (data) => {
            waterLevelChart1 = updateChart(waterLevelChart1, "waterLevelChart1", data);
        });
    }, 10000);

    // Change event listener for time range selection
    timeRangeSelect.addEventListener("change", function () {
        var selectedTimeRange = this.value;
        fetchAllStationsData(selectedTimeRange, (data) => {
            waterLevelChart1 = updateChart(waterLevelChart1, "waterLevelChart1", data);
        });
    });
});
