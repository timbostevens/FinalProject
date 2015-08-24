
// Load the Visualization API and the controls package.
google.load('visualization', '1.0', {'packages':['controls']});

// Set a callback to run when the Google Visualization API is loaded.
// google.setOnLoadCallback(drawDashboard);

// setTimeout(drawDashboard,2000);

// Callback that creates and populates a data table,
// instantiates a dashboard, a range slider and a pie chart,
// passes in the data and draws it.
function drawDashboard() {

  // setup url
    var urlGet = "charts/chartDataLoadAjax.php";
    // global var - sets up start of data input array
    scatterChartInputData = [['Speed (mph)', 'Distance (mi)', 'Duration (mins)', 'Petrol Saved (L)', 'CO2 Saved (kg)']];

  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
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
            title: 'My ScatterChart',
            legend: 'none'
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

            });// end downloadUrl
      } // end function

/*
Sets horizontal values based on dropdown
*/
function setHoriz(newIndex, newColumnName){

// get current vert axis index
var vertColumnIndex =  scatterChart.getView().columns[1];
// create new settings object
var newSettings = {columns:[newIndex, vertColumnIndex]};
// send indexes to filter manager
showFilters(newIndex, vertColumnIndex);
// send settings to chart
scatterChart.setView(newSettings);
// change axis label
scatterChart.setOption('hAxis.title',newColumnName);
// refresh chart
scatterChart.draw();

}

/*
Sets vertical values based on dropdown
*/
function setVert(newIndex, newColumnName){

// get current horiz axis index
var horizColumnIndex =  scatterChart.getView().columns[0];
// create new settings object
var newSettings = {columns:[horizColumnIndex, newIndex]};
// send indexes to filter manager
showFilters(horizColumnIndex, newIndex);
// send settings to chart
scatterChart.setView(newSettings);
// change axis label
scatterChart.setOption('vAxis.title',newColumnName);
// refresh chart
scatterChart.draw();

}

/*
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
    alert("Sorry, something has gone wrong with the chart redraw");
}

return columnDiv;

}


/*
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
    alert("Ind: Sorry, something has gone wrong with the chart redraw "+columnIndex);
}

return columnIndex;

}

// /*
//     * Gets XML data
//     */
//     function downloadUrl(url, callback) {

//       console.log(url);

//       var request = window.ActiveXObject ?
//       new ActiveXObject('Microsoft.XMLHTTP') :
//       new XMLHttpRequest;

//       request.onreadystatechange = function() {
//         // ready state == 4 means complete
//         if (request.readyState == 4) {
//           request.onreadystatechange = doNothing;
//           callback(request, request.status);
//         }
//       };
// // Ajax request (GET request tyoe, url, true = asynchronous)
// request.open('GET', url, true);
//       // sends the Ajax request
//       request.send(null);
//     }

//     function doNothing() {}


// listener for horizontal axis click
$(".scat-horiz-select").click(function(){

columnParameter = this.innerHTML;

/////////////////////////////////////////////////////////
//////CLUNKY WAY OF WAITING FOR COLUMN PARAMTER TO BE DEFINED
/////////////////////////////////////////////////////////
while (columnParameter!=="undefined"){
  // send index and name to setHoriz
  setHoriz(getColumnIndex(columnParameter), columnParameter);
  break;
  }
});


// listener for vertical axis click
$(".scat-vert-select").click(function(){

columnParameter = this.innerHTML;

/////////////////////////////////////////////////////////
//////CLUNKY WAY OF WAITING FOR COLUMN PARAMTER TO BE DEFINED
/////////////////////////////////////////////////////////
while (columnParameter!=="undefined"){
    // send index and name to setVert
  setVert(getColumnIndex(columnParameter), columnParameter);
  break;
  }
});

//////resizes chart on window resize
////Not sure if this is working correctly
///////////////////////////////////
$( window ).resize(function() {
  dashboard.draw(scatterChartData);
});
