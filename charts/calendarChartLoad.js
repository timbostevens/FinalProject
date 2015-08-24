      // google.setOnLoadCallback(drawCalendarChart);


function drawCalendarChart() {


// setup url
    var urlGet = "charts/calendarDataLoadAjax.php";
    // global var - sets up start of data input array
    // bubbleChartInputData = [['Journey Date', 'Distance (mi)', 'Duration (mins)', 'Petrol Saved (L)', 'CO2 Saved (kg)']];


    // calendarChartInputData = [['Date', 'Distance (mi)']];

// console.log(calendarChartInputData);

   calendarDataTable = new google.visualization.DataTable();
     calendarDataTable.addColumn({ type: 'date', id: 'Date' });
    calendarDataTable.addColumn({ type: 'number', id: 'Distance (mi)' });


  // get data from MySQL then calls function
  downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
          var days = xml.documentElement.getElementsByTagName("calDay");

  // cycles through results
 for (var i = 0; i < days.length; i++) {
    

  // calendarChartInputData.push([new Date(days[i].getAttribute("year"), days[i].getAttribute("month"),days[i].getAttribute("day")),days[i].getAttribute("_mi")]);

// console.log(calendarChartInputData);

   var myDate = new Date(days[i].getAttribute("year") +" "+ days[i].getAttribute("month") +" "+ days[i].getAttribute("day"));
   var myDist = parseFloat(days[i].getAttribute("distance_mi"));
    // appends values to input data array
   calendarDataTable.addRow([myDate, myDist]);

 } // end for

var calChart = new google.visualization.Calendar(document.getElementById('calendar_chart_div'));

       var calOptions = {
         title: "Red Sox Attendance",
         height: 350,
       };

      calChart.draw(calendarDataTable, calOptions);
   });


// var calDataTable = new google.visualization.DataTable();
//        calDataTable.addColumn({ type: 'date', id: 'Date' });
//        calDataTable.addColumn({ type: 'number', id: 'Won/Loss' });
//        calDataTable.addRows([
//           [ new Date(2012, 3, 13), 37032 ],
//           [ new Date(2012, 3, 14), 38024 ],
//           [ new Date(2012, 3, 15), 38024 ],
//           [ new Date(2012, 3, 16), 38108 ],
//           [ new Date(2012, 3, 17), 38229 ],
//           // Many rows omitted for brevity.
//           [ new Date(2013, 9, 4), 38177 ],
//           [ new Date(2013, 9, 5), 38705 ],
//           [ new Date(2013, 9, 12), 38210 ],
//           [ new Date(2013, 9, 13), 38029 ],
//           [ new Date(2013, 9, 19), 38823 ],
//           [ new Date(2013, 9, 23), 38345 ],
//           [ new Date(2013, 9, 24), 38436 ],
//           [ new Date(2013, 9, 30), 38447 ]
//         ]);

//        var calChart = new google.visualization.Calendar(document.getElementById('calendar_chart_div'));

//        var options = {
//          title: "Red Sox Attendance",
//          height: 350,
//        };

//        calChart.draw(calDataTable, options);



}