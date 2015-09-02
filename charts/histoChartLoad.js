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
  histoDataTable = google.visualization.arrayToDataTable(histoChartInputData);



// Setup histoChart Options
options = {
  title: 'Awesome Historgram',
  hAxis: {title: dataParameter},
  vAxis: {title: 'Journey Count'},
  legend: 'none'
  };

        // var options = {
        //   title: 'Lengths of dinosaurs, in meters',
        //   legend: { position: 'none' }
        // };

        histoChart = new google.visualization.Histogram(document.getElementById('histo_div'));
        histoChart.draw(histoDataTable, options);
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
    alert("Sorry, something has gone wrong with the histoChart redraw");
}

return columnName;


}

// Listener to resize histoChart on window resize
$( window ).resize(function() {
  histoChart.draw(histoDataTable, options);
});


// listener for horizontal axis click
$(".hist-select").click(function(){

histSelectionParameter = this.innerHTML;

/////////////////////////////////////////////////////////
//////CLUNKY WAY OF WAITING FOR COLUMN PARAMTER TO BE DEFINED
/////////////////////////////////////////////////////////
while (histSelectionParameter!=="undefined"){
  // snd data name to setData
  drawHistoChart(histSelectionParameter);
  break;  }
});