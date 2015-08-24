function drawHistoChart(dataParameter) {

  // translate data parameter into ajax-friendly column name
  var columnName = getColumnName(dataParameter);

  // setup url
  var urlGet = "charts/chartDataLoadAjax.php";
    // global var - sets up start of histoData input array
    histoChartInputData = [[dataParameter]];

  // get histoData from MySQL then calls function
  downloadUrl(urlGet, function(histoData) {
    var xml = histoData.responseXML;
    var journeys = xml.documentElement.getElementsByTagName("journey");

  // cycles through results
  for (var i = 0; i < journeys.length; i++) {
    // appends values to input histoData array
    histoChartInputData.push([parseFloat(journeys[i].getAttribute(columnName))]);

  } // end for


  // parses the input array into a histoData table
  histoData = google.visualization.arrayToDataTable(histoChartInputData);



// Setup Chart Options
var options = {
  title: 'Awesome Historgram',
  hAxis: {title: dataParameter},
  vAxis: {title: 'Count'},
  legend: 'none'
  };

        // var options = {
        //   title: 'Lengths of dinosaurs, in meters',
        //   legend: { position: 'none' }
        // };

        var chart = new google.visualization.Histogram(document.getElementById('histo_div'));
        chart.draw(histoData, options);
      });

}

/*
Helper function to turn plain text column name into
a column name matching the ajax request
*/
function getColumnName(dataParameter){

  var columnName;

  // set new index
switch(dataParameter){
  case "Speed (mph)":
    columnName = "speed";
    break;
  case "Distance (mi)":
    columnName = "distance";
    break;
  case "Duration (mins)":
    columnName = "duration";
    break;
  case "Petrol Saved (L)":
    columnName = "petrol";
    break;
  case "CO2 Saved (kg)":
    columnName = "co2";
    break;
  default:
    columnName = "";
    alert("Sorry, something has gone wrong with the chart redraw");
}

return columnName;


}





// listener for horizontal axis click
$(".hist-select").click(function(){

selectionParameter = this.innerHTML;

/////////////////////////////////////////////////////////
//////CLUNKY WAY OF WAITING FOR COLUMN PARAMTER TO BE DEFINED
/////////////////////////////////////////////////////////
while (selectionParameter!=="undefined"){
  // send data name to setData
  drawHistoChart(selectionParameter);
  break;
  }
});