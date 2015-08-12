
$(".x-select").click(function(){

var xSelected = this.innerHTML;

alert(divClicked);

});



/*
Loads Default Scatter Chart
*/


function loadScatterChart() {

// retrieve variables from session storage
panelNumber = sessionStorage.getItem('panelNumber');
journeyNumber = sessionStorage.getItem('journeyNumber');

  // setup url
  var urlGet = "scatterDataLoadAjax.php";
  // global var - sets up start of data input array
  scatterChartInputData = [['Speed (mph)', 'Distance (mi)']];

// get data from MySQL then calls function
downloadUrl(urlGet, function(data) {
        var xml = data.responseXML;
        var journeys = xml.documentElement.getElementsByTagName("journey");

// cycles through results
for (var i = 0; i < journeys.length; i++) {
  // appends values to input data array
  scatterChartInputData.push([parseFloat(journeys[i].getAttribute("speed")), parseFloat(journeys[i].getAttribute("distance"))]);

} // end for

// parses the input array into a data table
var chartData = google.visualization.arrayToDataTable(scatterChartInputData);
        // sets the chart options
        var options = {
          hAxis: {title: 'Speed (mph)', minValue: 0, maxValue: 15},
          vAxis: {title: 'Distance (mi)', minValue: 0, maxValue: 15},
          legend: 'none'
        };
        // creates the chart
        var chart = new google.visualization.ScatterChart(document.getElementById('journey-scatter-chart'+panelNumber));
        // draws the chart
        chart.draw(chartData, options);


});// end downloadUrl


}// end function
