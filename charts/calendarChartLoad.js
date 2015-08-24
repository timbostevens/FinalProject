google.load("visualization", "1.1", {packages:["calendar"]});


function drawCalendarChart() {


// setup url
    var urlGet = "charts/calendarDataLoadAjax.php";
    // global var - sets up start of data input array
    // bubbleChartInputData = [['Journey Date', 'Distance (mi)', 'Duration (mins)', 'Petrol Saved (L)', 'CO2 Saved (kg)']];


    calendarDataTable = new google.visualization.DataTable();
       calendarDataTable.addColumn({ type: 'date', id: 'Date' });
       calendarDataTable.addColumn({ type: 'number', id: 'Distance (mi)' });


  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
          var days = xml.documentElement.getElementsByTagName("day");

  // cycles through results
  for (var i = 0; i < days.length; i++) {
    // appends values to input data array
    calendarDataTable.addRow([new Date(2015,12,3), 1234]);

    console.log(calendarDataTable);

  } // end for

var calChart = new google.visualization.Calendar(document.getElementById('calendar_chart_div'));

       var calOptions = {
         title: "Red Sox Attendance",
         height: 350,
       };

       calChart.draw(calendarDataTable, calOptions);
   });
}