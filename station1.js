$(function () {
    class GaugeChart {
        constructor(element, params) {
            this._element = element;
            this._initialValue = params.initialValue;
            this._higherValue = params.higherValue;
            this._title = params.title;
            this._subtitle = params.subtitle;
        }

        _buildConfig() {
            let element = this._element;

            return {
                value: this._initialValue,
                valueIndicator: {
                    color: '#222629' 
                },
                geometry: {
                    startAngle: 180,
                    endAngle: 360 
                },
                scale: {
                    startValue: 0,
                    endValue: this._higherValue,
                    customTicks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                    tick: {
                        length: 8 // Length of the ticks
                    },
                    label: {
                        font: {
                            color: '#222629',
                            size: 9,
                            family: '"Open Sans", sans-serif'
                        }
                    }
                },
                title: {
                    verticalAlignment: 'bottom',
                    text: this._title,
                    font: {
                        family: '"Open Sans", sans-serif',
                        color: '#222629',
                        size: 10
                    },
                    subtitle: {
                        text: this._subtitle,
                        font: {
                            family: '"Open Sans", sans-serif',
                            color: '#222629',
                            weight: 700,
                            size: 28
                        }
                    }
                },
                onInitialized: function () {
                    let currentGauge = $(element);
                    let circle = currentGauge.find('.dxg-spindle-hole').clone();
                    let border = currentGauge.find('.dxg-spindle-border').clone();

                    currentGauge.find('.dxg-title text').first().attr('y', 48);
                    currentGauge.find('.dxg-title text').last().attr('y', 28);
                    currentGauge.find('.dxg-value-indicator').append(border, circle);
                }
            };
        }

        init() {
            $(this._element).dxCircularGauge(this._buildConfig());
        }
    }

    // Function to initialize a gauge for a specific station
    function initializeGauge(selector, params) {
        $(selector).each(function (index, item) {
            let gauge = new GaugeChart(item, params);
            gauge.init();
        });
    }
    function updateGauge(selector, newValue, newSubtitle) {
        $(selector).each(function () {
            let gauge = $(this).data('gaugeInstance');
            if (gauge) {
                gauge.update(newValue, newSubtitle);
            }
        });
    }
 
        $.post("ajax.php", { action: "get_turbidity_and_raindrop", station: 1 }, (data) => {
            let responseData = JSON.parse(data);
            let waterLevelData = responseData.distance_cm;
            let turbidityData = responseData.turbidity;

            if (waterLevelData && turbidityData) {
                updateGauge('.station_1_waterlevel', parseFloat(waterLevelData), `${parseFloat(waterLevelData)} cm`);
                updateGauge('.station_1_turbidity', parseFloat(turbidityData) * 100, `${parseFloat(turbidityData) * 100} %`);
            }
        });
 
    
   initializeGauge('.station_1_waterlevel', {
        initialValue: 0,
        higherValue: 100,
        title: `Station 1 Water Level`,
        subtitle: `Initializing...`
    });

    initializeGauge('.station_1_turbidity', {
        initialValue: 0,
        higherValue: 100,
        title: `Station 1 Turbidity`,
        subtitle: `Initializing...`
    });
    
   
    
function updatestation1(){
    $.post("ajax.php", { action: "get_turbidity_and_raindrop", station: 1 }, (data) => {
        let responseData = JSON.parse(data);
        let waterLevelData = responseData.distance_cm;
        let turbidityData = responseData.turbidity;
    
        // Initialize gauges with fetched data
        initializeGauge('.station_1_waterlevel', {
            initialValue: parseFloat(waterLevelData) / 304 * 100,
            higherValue: 100,
            title: ` Station 1 - Water Level <b> Critical: (279 cm above) Warning: (210 cm above) </b>`,
           subtitle: parseFloat(waterLevelData) + 'cm'
        });
    
        initializeGauge('.station_1_turbidity', {
            initialValue: parseFloat(turbidityData) /37 * 100,
            higherValue: 100,
            title: `Station 1 - Turbidity <b>Normal: 20%</b>`,
        subtitle: `${Math.round((parseFloat(waterLevelData) / 500 ) * 100)} %`
        });
    });
}
updatestation1();
setInterval(updatestation1, 5000);
  

  // Function to initialize a gauge for a specific station
  function initializeGauge2(selector, params) {
    $(selector).each(function (index, item) {
        let gauge = new GaugeChart(item, params);
        gauge.init();
    });
}
function updateGauge2(selector, newValue, newSubtitle) {
    $(selector).each(function () {
        let gauge = $(this).data('gaugeInstance');
        if (gauge) {
            gauge.update(newValue, newSubtitle);
        }
    });
}

    $.post("ajax.php", { action: "get_turbidity_and_raindrop", station: 2 }, (data) => {
        let responseData = JSON.parse(data);
        let waterLevelData = responseData.distance_cm;
        let rainfallData = responseData.turbidity;

        if (waterLevelData && rainfallData) {
            updateGauge2('.station_2_waterlevel', parseFloat(waterLevelData), `${parseFloat(waterLevelData)} cm`);
            updateGauge2('.station_2_raindrop', parseFloat(rainfallData) * 100, `${parseFloat(rainfallData) * 100} %`);
        }
    });


initializeGauge2('.station_2_waterlevel', {
    initialValue: 0,
    higherValue: 100,
    title: `Station 2 Water Level`,
    subtitle: `Initializing...`
});

initializeGauge2('.station_2_raindrop', {
    initialValue: 0,
    higherValue: 100,
    title: `Station 2 Turbidity`,
    subtitle: `Initializing...`
});

function updateStation2(){
    $.post("ajax.php", { action: "get_turbidity_and_raindrop", station: 2 }, (data) => {
        let responseData = JSON.parse(data);
        let rainfallData = responseData.raindrop;
        let waterLevelData = responseData.distance_cm;

        // Initialize turbidity gauge
        initializeGauge('.station_2_waterlevel', {
            initialValue: Math.round((parseFloat(waterLevelData) / 304) * 100), 
            higherValue: 100,
            title: `Station 2 - Water Level <b> Critical: (279 cm above) Warning: (210 cm above) </b>`,
            subtitle: parseFloat(waterLevelData) + 'cm'
        });

        // Initialize water level gauge
        initializeGauge('.station_2_raindrop', {
            initialValue: parseFloat(rainfallData) * 100,
            higherValue: 100,
            title: `Station 2- Rain Drop`,
             subtitle: `${parseFloat(rainfallData) * 100} %`
        });
    });
}

  updateStation2();
  setInterval(updateStation2, 5000);



  //Station 3
  
  // Function to initialize a gauge for a specific station
  function initializeGauge3(selector, params) {
    $(selector).each(function (index, item) {
        let gauge = new GaugeChart(item, params);
        gauge.init();
    });
}
function updateGauge3(selector, newValue, newSubtitle) {
    $(selector).each(function () {
        let gauge = $(this).data('gaugeInstance');
        if (gauge) {
            gauge.update(newValue, newSubtitle);
        }
    });
}

    $.post("ajax.php", { action: "get_turbidity_and_raindrop", station: 3 }, (data) => {
        let responseData = JSON.parse(data);
        let waterLevelData = responseData.distance_cm;
        let rainfallData = responseData.turbidity;

        if (waterLevelData && rainfallData) {
            updateGauge3('.station_3_waterlevel', parseFloat(waterLevelData), `${parseFloat(waterLevelData)} cm`);
            updateGauge3('.station_3_raindrop', parseFloat(rainfallData) * 100, `${parseFloat(rainfallData) * 100} %`);
        }
    });


initializeGauge3('.station_3_waterlevel', {
    initialValue: 0,
    higherValue: 100,
    title: `Station 3 Water Level`,
    subtitle: `Initializing...`
});

initializeGauge3('.station_3_raindrop', {
    initialValue: 0,
    higherValue: 100,
    title: `Station 3 Turbidity`,
    subtitle: `Initializing...`
});

function updateStation3(){
    $.post("ajax.php", { action: "get_turbidity_and_raindrop", station: 3 }, (data) => {
        let responseData = JSON.parse(data);
        let rainfallData = responseData.raindrop;
        let waterLevelData = responseData.distance_cm;

        // Initialize turbidity gauge
        initializeGauge('.station_3_waterlevel', {
            initialValue: parseFloat(waterLevelData) / 304 * 100,
            higherValue: 100,
            title: `Station 3 - Water Level <b> Critical: (279 cm above) Warning: (210 cm above) </b>`,
           subtitle: parseFloat(waterLevelData) + 'cm'
        });

        // Initialize water level gauge
        initializeGauge('.station_3_raindrop', {
            initialValue: parseFloat(rainfallData) * 100,
            higherValue: 100,
            title: `Station 3 - Rain Drop`,
             subtitle: `${parseFloat(rainfallData) * 100} %`
        });
    });
}

  updateStation3();
  setInterval(updateStation3, 5000);

});
