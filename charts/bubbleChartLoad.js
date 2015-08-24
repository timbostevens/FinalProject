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


      var options = {
        title: 'Savings per Journey - Size: CO2 (kg), Colour: Petrol (L)',
        hAxis: {title: 'Distance'},
        vAxis: {title: 'Duration'},
        legend: {position: 'none'},
        bubble: {textStyle: {fontSize: 11}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('bubble_div'));
      chart.draw(bubbleChartData, options);
    });
}