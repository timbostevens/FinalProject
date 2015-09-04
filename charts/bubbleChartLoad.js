/*
Sets up and draws bubble chart
*/
function drawBubbleChart() {


// setup url
    var urlGet = "charts/bubbleDataLoadAjax.php";
    // global var - sets up start of data input array
    bubbleChartInputData = [['Journey Date', 'Distance (mi)', 'Duration (mins)', 'Petrol Saved (L)', 'CO2 Saved (kg)']];

  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
          var journeys = xml.documentElement.getElementsByTagName("journey");

  // cycles through results
  for (var i = 0; i < journeys.length; i++) {
    // appends values to input data array
    bubbleChartInputData.push([journeys[i].getAttribute("journey_date"), parseFloat(journeys[i].getAttribute("distance")), parseFloat(journeys[i].getAttribute("duration")), parseFloat(journeys[i].getAttribute("petrol")), parseFloat(journeys[i].getAttribute("co2"))]);

  } // end for

  // parses the input array into a data table
  bubbleChartData = google.visualization.arrayToDataTable(bubbleChartInputData);

      // setup chart options
      options = {
        title: 'Savings per Journey - Size: CO2 (kg), Colour: Petrol (L)',
        hAxis: {title: 'Distance'},
        vAxis: {title: 'Duration'},
        legend: {position: 'none'},
        colors: ['#808080'],
        chartArea:{left:100,top:100,width:'85%',height:'65%'},
        bubble: {textStyle: {fontSize: 11}}
      };
      // create chart and link to html id
      bubbleChart = new google.visualization.BubbleChart(document.getElementById('bubble_div'));
      // draw bubbleChart
      bubbleChart.draw(bubbleChartData, options);
    });
}

// Listener to resize bubbleChart on window resize
$( window ).resize(function() {
  bubbleChart.draw(bubbleChartData, options);
});
