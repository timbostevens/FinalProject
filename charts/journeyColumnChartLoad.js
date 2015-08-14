
// Load the Visualization API and the controls package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
// google.setOnLoadCallback(drawDashboard);

// setTimeout(drawDashboard,2000);

// Callback that creates and populates a data table,
// instantiates a chart, passes in the data and draws it.
function drawJourneyColumnChart(journeyNumber, panelNumber) {

  // setup url
    var urlGet = "charts/journeyColumnDataLoadAjax.php?journey="+journeyNumber;
    // global var - sets up start of data input array
    columnChartInputData = [['','Min','Journey','Average','Max']];

  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
          var sums = xml.documentElement.getElementsByTagName("sum");

  // cycles through results
  for (var i = 0; i < sums.length; i++) {
    // appends values to input data array
    columnChartInputData.push([(sums[i].getAttribute("parameter")), parseFloat(sums[i].getAttribute("min")), parseFloat(sums[i].getAttribute("val")), parseFloat(sums[i].getAttribute("average")), parseFloat(sums[i].getAttribute("max"))]);

  } // end for

  var journeyColumnOptions = {
    chartArea:{left:30,top:50,width:'100%',height:'75%'},
    hAxis: {textStyle: {fontSize: 10}},
    legend: {position: 'in'},
    fontSize: 12,
    fontName: 'Biryani'
  };


  // parses the input array into a data table
  var chartData = google.visualization.arrayToDataTable(columnChartInputData);
          
    // Create a columnchart
    var columnChart = new google.visualization.ColumnChart(document.getElementById('journey-column-chart'+panelNumber));

        // Draw the chart
        columnChart.draw(chartData, journeyColumnOptions);

            });// end downloadUrl
      } // end function

