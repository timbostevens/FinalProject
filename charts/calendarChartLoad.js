/*
Sets up and draws calendar chart
*/
function drawCalendarChart() {


// setup url
    var urlGet = "charts/calendarDataLoadAjax.php";

// create data table with two columns for data
   calendarDataTable = new google.visualization.DataTable();
     calendarDataTable.addColumn({ type: 'date', id: 'Date' });
    calendarDataTable.addColumn({ type: 'number', id: 'Distance (mi)' });


  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
          var days = xml.documentElement.getElementsByTagName("calDay");

        // cycles through results
       for (var i = 0; i < days.length; i++) {
          // create temporary vars to hold values
          var myDate = new Date(days[i].getAttribute("year") +" "+ days[i].getAttribute("month") +" "+ days[i].getAttribute("day"));
          var myDist = parseFloat(days[i].getAttribute("distance_mi"));
          // appends values to data table
          calendarDataTable.addRow([myDate, myDist]);

        } // end for
      // create chart and link to html id
      var calChart = new google.visualization.Calendar(document.getElementById('calendar_chart_div'));
      // setup chart options
      var calOptions = {
           title: "Distance Driven (mi)",
           height: 350,
           };
      // draw chart
      calChart.draw(calendarDataTable, calOptions);
   });

}