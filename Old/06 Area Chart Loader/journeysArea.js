/*
Was having issues with the loading of the chart - it took on a default size when loaded
using hte code below. Draw chart is now called when the acoordion is expanded (in the map load file)
*/

// google.setOnLoadCallback(drawChart);

function drawChart() {

  // array to hold data (then will be passed into chart)
  var inputData = [['Point', 'Speed']];

  // append journey number to get request
  var urlGet = "areaLoadAjax.php?journey=1";

// get data from MySQL and calls download URL function then runs callback function
  downloadUrl(urlGet, function(data) {

    var xml = data.responseXML;
    var datapoints = xml.documentElement.getElementsByTagName("datapoint");

    // retrieve attributes for each element
    for (var i = 0; i < datapoints.length; i++) {
          // push new datapoint (as array) to the main array
          inputData.push([datapoints[i].getAttribute("point"),parseFloat(datapoints[i].getAttribute("speed"))]);
          
        }// end for

        var dataArray = google.visualization.arrayToDataTable(inputData);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          legend: {position: 'none'},
          width: '100%'
          };

          var chart = new google.visualization.AreaChart(document.getElementById('journey-area-chart1'));
          chart.draw(dataArray, options);

      } // end download URL function

    );//end download url

}


// jQuery code to refresh chart on window resize
// $(window).resize(function(){
//   drawChart();
// });