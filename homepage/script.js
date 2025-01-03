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
          color: '#222629' },

        geometry: {
          startAngle: 180,
          endAngle: 360 },

        scale: {
          startValue: 0,
          endValue: this._higherValue,
          customTicks: [0, 10,20,30,40,50,60,70,80,90,100],
          tick: {
            length: 8 },

          label: {
            font: {
              color: '#222629',
              size: 9,
              family: '"Open Sans", sans-serif' } } },



        title: {
          verticalAlignment: 'bottom',
          text: this._title,
          font: {
            family: '"Open Sans", sans-serif',
            color: '#222629',
            size: 10 },

          subtitle: {
            text: this._subtitle,
            font: {
              family: '"Open Sans", sans-serif',
              color: '#222629',
              weight: 700,
              size: 28 } } },



        onInitialized: function () {
          let currentGauge = $(element);
          let circle = currentGauge.find('.dxg-spindle-hole').clone();
          let border = currentGauge.find('.dxg-spindle-border').clone();

          currentGauge.find('.dxg-title text').first().attr('y', 48);
          currentGauge.find('.dxg-title text').last().attr('y', 28);
          currentGauge.find('.dxg-value-indicator').append(border, circle);
        } };


    }

    init() {
      $(this._element).dxCircularGauge(this._buildConfig());
    }}


  $(document).ready(function () {
    $.post("../../ajax.php",{action:"get_turbidity_and_raindrop",station:1},(data)=>{
      var responseData = JSON.parse(data);
      let rainfallData = responseData.raindrop;
      let water_level_data = responseData.distance_cm;
      $('.station_1_gauge').each(function (index, item) {
          let raindropPercent = parseFloat(parseFloat(rainfallData) * 100);
          let 
  
          params = {
            initialValue: parseFloat(water_level_data),
            higherValue: 100,
            title: ` mm/24h`,
            subtitle: `${parseFloat(water_level_data)} cm` };
          if (index ==1 ) {
            params = {
              initialValue:raindropPercent,
              higherValue: 100,
              title: `Rainfall`,
              subtitle: `${raindropPercent} %` };
          }
  
  
        let gauge = new GaugeChart(item, params);
        gauge.init();
      });
      });
      $.post("../../ajax.php",{action:"get_turbidity_and_raindrop",station:3},(data)=>{
        var responseData = JSON.parse(data);
        let rainfallData = responseData.raindrop;
        let turbdity = responseData.turbdity;
        let raindropPercent =parseFloat(rainfallData);
        if ( isNaN(raindropPercent)) {
          raindropPercent = 0;
        }
        $('.station_3_gauge').each(function (index, item) {
            let params = {
            initialValue:raindropPercent,
            higherValue: 100,
            title: `Rainfall`,
            subtitle:raindropPercent+ " %" };
    
            if (index ==1 ) {
              params = {
            initialValue: parseFloat(turbdity) * 100,
            higherValue: 100,
            title: ` mm/24h`,
            subtitle: parseFloat(turbdity) * 100};
            }
    
    
          let gauge = new GaugeChart(item, params);
          gauge.init();
        });
        });
      
    $.post("../../ajax.php",{action:"get_turbidity_and_raindrop",station:2},(data)=>{
      var responseData = JSON.parse(data);
      let rainfallData = responseData.raindrop;
      let water_level_data = responseData.distance_cm;
      let station_2_turbidity_gauge =  $('#station_2_turbidity_gauge');
      let station_2_water_level_gauge =  $('#station_2_water_level_gauge');

        params = {
          initialValue: (parseFloat(rainfallData) * 100),
          higherValue: 100,
          title: `  `,
          subtitle: (parseFloat(rainfallData) * 100) +" %" };
        let turbdityGauge = new GaugeChart(station_2_turbidity_gauge, params);
        turbdityGauge.init();

        params = {
          initialValue: (parseFloat(water_level_data) ),
          higherValue: 100,
          title: ` `,
          subtitle: (parseFloat(water_level_data)) +" cm" };
        let waterLevelGauge = new GaugeChart(station_2_water_level_gauge, params);
        waterLevelGauge.init();
    });
    });


});