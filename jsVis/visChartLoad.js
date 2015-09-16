//missing database error message
var DATABASE_ERROR_MESSAGE = "Ooops, we're having a bit of a problem with the database. I can't seem to find the data I require";
// value for default histogram option
var DEFAULT_HISTO = 'Speed (mph)';

// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart','calendar','controls']});


google.setOnLoadCallback(drawAllCharts);

/*
Draw All Charts
*/
function drawAllCharts(){
  prepDashboard();
  prepHistoChart(DEFAULT_HISTO);
  prepBubbleChart();
  prepHeatMap();
}

function prepDashboard(){

  // setup url
    var urlGet = "jsVis/chartDataLoadAjax.php";

  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          drawDashboard(data.responseXML);
        });
}



/*
Scatter Chart
Callback that creates and populates a data table,
instantiates a dashboard, a range slider and a pie chart,
passes in the data and draws it
*/
function drawDashboard(xml) {

      console.log(xml);

          // if there are no results (might be a database error then fail gracefully)
          if (xml===null){
            alert(DATABASE_ERROR_MESSAGE);
          }

          // global var - sets up start of data input array
          scatterChartInputData = [['Speed (mph)', 'Distance (mi)', 'Duration (mins)', 'Petrol Saved (L)', 'CO2 Saved (kg)']];

          var journeys = xml.documentElement.getElementsByTagName("journey");

  // cycles through results
  for (var i = 0; i < journeys.length; i++) {
    // appends values to input data array
    scatterChartInputData.push([parseFloat(journeys[i].getAttribute("speed")), parseFloat(journeys[i].getAttribute("distance")), parseFloat(journeys[i].getAttribute("duration")), parseFloat(journeys[i].getAttribute("petrol")), parseFloat(journeys[i].getAttribute("co2"))]);

  } // end for

  // parses the input array into a data table
  scatterChartData = google.visualization.arrayToDataTable(scatterChartInputData);
          
// Create a dashboard.
dashboard = new google.visualization.Dashboard(
  document.getElementById('dashboard_div'));


// Create chart, passing some options
        scatterChart = new google.visualization.ChartWrapper({
          chartType: 'ScatterChart',
          containerId: 'chart_div',
          view: {'columns':['Speed (mph)','Distance (mi)']},
          options: {
            hAxis: {title: 'Speed (mph)', minValue: 0, maxValue: 15},
            vAxis: {title: 'Distance (mi)', minValue: 0, maxValue: 15},
            chartArea:{left:100,top:60,width:'75%',height:'65%'},
            // title: 'My ScatterChart',
            legend: 'none',
            colors: ['#808080']
          }
        });

        speedRange = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'speed_filter_div',
          'options': {'filterColumnLabel': 'Speed (mph)'}
        });
        
        distanceRange = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'distance_filter_div',
          'options': {'filterColumnLabel': 'Distance (mi)'}
        });

        durationRange = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'duration_filter_div',
          'options': {'filterColumnLabel': 'Duration (mins)'}
        });

        petrolRange = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'petrol_filter_div',
          'options': {'filterColumnLabel': 'Petrol Saved (L)'}
        });


        co2Range = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'co2_filter_div',
          'options': {'filterColumnLabel': 'CO2 Saved (kg)'}
        });

        // Establish dependencies, declaring that filters drive the scatterChart,
        // so that the chart will only display entries that are let through
        // given the chosen slider range.
        dashboard.bind([speedRange, distanceRange, durationRange, petrolRange, co2Range], scatterChart);
        // Draw the dashboard.
        dashboard.draw(scatterChartData);

            
      } // end function

/*
Scatter Chart
Sets horizontal values based on dropdown
*/
function setHoriz(newIndex, newColumnName){

// get current vert axis index
var vertColumnIndex =  scatterChart.getView().columns[1];
// create new settings object
var newSettings = {columns:[newIndex, vertColumnIndex]};
// send indexes to filter manager
///////////////////////////////////////
///Currently hiding filters
/////////////////////////////////////
//showFilters(newIndex, vertColumnIndex);
// send settings to chart
scatterChart.setView(newSettings);
// change axis label
scatterChart.setOption('hAxis.title',newColumnName);
// refresh chart
scatterChart.draw();

}

/*
Scatter Chart
Sets vertical values based on dropdown
*/
function setVert(newIndex, newColumnName){

// get current horiz axis index
var horizColumnIndex =  scatterChart.getView().columns[0];
// create new settings object
var newSettings = {columns:[horizColumnIndex, newIndex]};
// send indexes to filter manager
///////////////////////////////////////
///Currently hiding filters
/////////////////////////////////////
//showFilters(horizColumnIndex, newIndex);
// send settings to chart
scatterChart.setView(newSettings);
// change axis label
scatterChart.setOption('vAxis.title',newColumnName);
// refresh chart
scatterChart.draw();

}

/*
Scatter Chart
Manager the visibility of the sliders based on what is in the chart
*/
function showFilters(horizIndex, vertIndex){
  // hide all divs
  $("#speed_filter_div").hide();
  $("#distance_filter_div").hide();
  $("#duration_filter_div").hide();
  $("#petrol_filter_div").hide();
  $("#co2_filter_div").hide();

  var horizDiv = getColumnDiv(horizIndex);
  var vertDiv = getColumnDiv(vertIndex);
  // show appropriate divs
  $("#"+horizDiv).show();  
  $("#"+vertDiv).show();

}


/*
Scatter Chart
Helper function to turn column name into a div name
Returns string
*/
function getColumnDiv(columnIndex){

var columnDiv;

// set new index
switch(columnIndex){
  case 0:
    columnDiv = "speed_filter_div";
    break;
  case 1:
    columnDiv = "distance_filter_div";
    break;
  case 2:
    columnDiv = "duration_filter_div";
    break;
  case 3:
    columnDiv = "petrol_filter_div";
    break;
  case 4:
    columnDiv = "co2_filter_div";
    break;
  default:
    columnDiv = "";
    alert("Sorry, something has gone wrong with the column chart redraw");
}

return columnDiv;

}


/*
Scatter Chart
Helper function to turn column name into an index
Returns int
*/
function getColumnIndex(columnName){

var columnIndex;

// set new index
switch(columnName){
  case 'Speed (mph)':
    columnIndex = 0;
    break;
  case 'Distance (mi)':
    columnIndex = 1;
    break;
  case 'Duration (mins)':
    columnIndex = 2;
    break;
  case 'Petrol Saved (L)':
    columnIndex = 3;
    break;
  case 'CO2 Saved (kg)':
    columnIndex = 4;
    break;
  default:
    columnIndex = 0;
    alert("Sorry, something has gone wrong with the column chart redraw");
}

return columnIndex;

}


/*
Preps histro chart
sends on xml results
*/
function prepHistoChart(dataParameter) {

  // setup url
  var urlGet = "jsVis/chartDataLoadAjax.php";

  // get histoData from MySQL then calls function
  downloadUrl(urlGet, function(histoData) {
    drawHistoChart(dataParameter, histoData.responseXML);

      });

}

/*
Drawns histro chart
Takes the data choice and xml data
*/
function drawHistoChart(dataParameter, xml){

 var journeys = xml.documentElement.getElementsByTagName("journey");

  // translate data parameter into ajax-friendly column name
  var columnName = getColumnName(dataParameter);

    // global var - sets up start of histoData input array
    histoChartInputData = [[dataParameter]];


  // cycles through results
  for (var i = 0; i < journeys.length; i++) {
    // appends values to input histoData array
    histoChartInputData.push([parseFloat(journeys[i].getAttribute(columnName))]);
  } // end for

  // parses the input array into a histoData table
  histoDataTable = google.visualization.arrayToDataTable(histoChartInputData);

// Setup histoChart Options
options = {
  // title: 'Awesome Historgram',
  hAxis: {title: dataParameter},
  vAxis: {title: 'Journey Count'},
  legend: 'none',
  chartArea:{left:100,top:60,width:'75%',height:'65%'},
  colors: ['#808080']
  };

        // var options = {
        //   title: 'Lengths of dinosaurs, in meters',
        //   legend: { position: 'none' }
        // };

        histoChart = new google.visualization.Histogram(document.getElementById('histo_div'));
        histoChart.draw(histoDataTable, options);

}



/*
Histo Chart
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
    alert("Sorry, something has gone wrong with the histo chart redraw");
}

return columnName;


}
/*
Sets up the bubble chart data
*/
function prepBubbleChart() {

  // setup url
  var urlGet = "jsVis/bubbleDataLoadAjax.php";

  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
  console.log(data);
  drawBubbleChart(data.responseXML);          
  });
}


/*
Takes xml and draws bubble chart
*/
function drawBubbleChart(xml){

// global var - sets up start of data input array
bubbleChartInputData = [['Journey Date', 'Distance (mi)', 'Duration (mins)', 'Petrol Saved (L)', 'CO2 Saved (kg)']];

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
}



/*
Heatmap
Sets up heatmap
*/
function prepHeatMap(){
// setup url
var urlGet = "jsVis/heatDataLoadAjax.php";

// get data from MySQL then calls function
downloadUrl(urlGet, function(data) {
  drawHeatMap(data.responseXML);
}); // end download url
}// end heatmap load


/*
Takes xml and drawns heatmap
*/
function drawHeatMap(xml){

var markers = xml.documentElement.getElementsByTagName("marker");
    // empty array for heatmap data
    var heatmapData = [];

        // var for marker bounds (used for setting the zoom and centre)
        var markerBounds = new google.maps.LatLngBounds();
    // var for default location
    var belfast = new google.maps.LatLng(54.607868, -5.926437);

        // cycles through results
        for (var i = 0; i < markers.length; i++) {

          var point = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")), parseFloat(markers[i].getAttribute("lng")));

          heatmapData.push(point);
          markerBounds.extend(point);

        } // end for

    // create new map object
    var map = new google.maps.Map(document.getElementById('heatmap-canvas'), {
      // default zoom and loaction values in case of data load failure
      center: belfast,
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.SATELLITE
    });

    // set zoom based on marker bounds
    map.fitBounds(markerBounds);
    // create new heatmap object
    var heatmap = new google.maps.visualization.HeatmapLayer({
      data: heatmapData
    });

    // joins the map and heatmap
    heatmap.setMap(map);

}




/*
Bubble Chart
Listener to resize on window resize
*/
$( window ).resize(function() {
  bubbleChart.draw(bubbleChartData, options);
});

/*
Histo Chart
Listener to resize histoChart on window resize
*/
$( window ).resize(function() {
  histoChart.draw(histoDataTable, options);
});


/*
Hist Chart
listener for horizontal axis click
*/
$(".hist-select").click(function(){

histSelectionParameter = this.innerHTML;

while (histSelectionParameter!=="undefined"){
  // snd data name to setData
  prepHistoChart(histSelectionParameter);
  break;  }
});



/*
Scatter Chart
listener for horizontal axis click
*/
$(".scat-horiz-select").click(function(){

columnParameter = this.innerHTML;

while (columnParameter!=="undefined"){
  // send index and name to setHoriz
  setHoriz(getColumnIndex(columnParameter), columnParameter);
  break;
  }
});


/*l
Scatter Chart
istener for vertical axis click
*/
$(".scat-vert-select").click(function(){
columnParameter = this.innerHTML;

while (columnParameter!=="undefined"){
    // send index and name to setVert
  setVert(getColumnIndex(columnParameter), columnParameter);
  break;
  }
});

/*
Scatter Chart
resizes chart on window resize
*/
$( window ).resize(function() {
  dashboard.draw(scatterChartData);
});
