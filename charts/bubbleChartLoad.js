function drawBubbleChart() {

      // var bubbleData = google.visualization.arrayToDataTable([
      //   ['ID', 'Life Expectancy', 'Fertility Rate', 'Region',     'Population'],
      //   ['CAN',    80.66,              1.67,      'North America',  33739900],
      //   ['DEU',    79.84,              1.36,      'Europe',         81902307],
      //   ['DNK',    78.6,               1.84,      'Europe',         5523095],
      //   ['EGY',    72.73,              2.78,      'Middle East',    79716203],
      //   ['GBR',    80.05,              2,         'Europe',         61801570],
      //   ['IRN',    72.49,              1.7,       'Middle East',    73137148],
      //   ['IRQ',    68.09,              4.77,      'Middle East',    31090763],
      //   ['ISR',    81.55,              2.96,      'Middle East',    7485600],
      //   ['RUS',    68.6,               1.54,      'Europe',         141850000],
      //   ['USA',    78.09,              2.05,      'North America',  307007000]
      // ]);


// setup url
    var urlGet = "charts/chartDataLoadAjax.php";
    // global var - sets up start of data input array
    bubbleChartInputData = [['Journey Ref', 'Distance (mi)', 'Duration (mins)', 'Petrol Equivalent', 'Petrol Saved (L)']];

  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
          var journeys = xml.documentElement.getElementsByTagName("journey");

  // cycles through results
  for (var i = 0; i < journeys.length; i++) {
    // appends values to input data array
    bubbleChartInputData.push(["J" +journeys[i].getAttribute("journey_ref"), parseFloat(journeys[i].getAttribute("distance")), parseFloat(journeys[i].getAttribute("duration")), "Calculation", parseFloat(journeys[i].getAttribute("petrol"))]);

  } // end for

  // parses the input array into a data table
  bubbleChartData = google.visualization.arrayToDataTable(bubbleChartInputData);





      var options = {
        title: 'Petrol Saved (L) per Journey',
        hAxis: {title: 'Distance'},
        vAxis: {title: 'Duration'},
        legend: {position: 'none'},
        bubble: {textStyle: {fontSize: 11}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('bubble_div'));
      chart.draw(bubbleChartData, options);
    });
}