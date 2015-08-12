function loadScatterChart() {

  var urlGet = "scatterDataLoadAjax.php";

  scatterChartInputData = [['Speed (mph)', 'Distance (mi)']];

  // console.log()


// get data from MySQL and calls download URL function
downloadUrl(urlGet, function(data) {
        var xml = data.responseXML;
        var journeys = xml.documentElement.getElementsByTagName("journey");


for (var i = 0; i < journeys.length; i++) {

scatterChartInputData.push([parseFloat(journeys[i].getAttribute("speed")), parseFloat(journeys[i].getAttribute("distance"))]);

} // end for

	// var chartData = google.visualization.arrayToDataTable([
 //          ['Age', 'Weight'],
 //          [ 8,      12],
 //          [ 4,      5.5],
 //          [ 11,     14],
 //          [ 4,      5],
 //          [ 3,      3.5],
 //          [ 6.5,    7]
 //        ]);

var chartData = google.visualization.arrayToDataTable(scatterChartInputData);

        var options = {
          title: 'Age vs. Weight comparison',
          hAxis: {title: 'Age', minValue: 0, maxValue: 15},
          vAxis: {title: 'Weight', minValue: 0, maxValue: 15},
          legend: 'none'
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('journey-scatter-chart1'));

        chart.draw(chartData, options);


});// end downloadUrl


}// end function
