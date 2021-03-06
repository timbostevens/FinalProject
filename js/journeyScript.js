// pseudo-constant stating the maximum number of panels to add in one load
var MAX_PANELS_TO_ADD = 5;
// pseudo-constant holding error message
var NO_JOURNEY_FOUND_MESSAGE = "Ooops, it looks like you requested a journey that doesn't exist.\n\nI'm going to load the 5 most recent instead";
// base website address
var WEBSITE_BASE_ADDRESS = "http://tstevens01.students.cs.qub.ac.uk/";
//missing database error message
var DATABASE_ERROR_MESSAGE = "Ooops, we're having a bit of a problem with the database. I can't seem to find any journeys to load";
//missing database error message
var GENERAL_ERROR_MESSAGE = "Ooops, we're having a bit of a problem. Please try loading the page again";

// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});


/*
Dynamically inserts tweet button
*/
function insertTwitter (journeyNumber, panelNumber){

    // get vars
    var date = document.getElementById("dateP"+panelNumber).innerHTML;
    var distance = document.getElementById("distanceP"+panelNumber).innerHTML;

// checks the button doesn't alreadt exist
if($('#tweet-button'+panelNumber).length){
  // do nothing
} else {
  // insert button with appropriaet text in correct place
  $("#facebook-button"+panelNumber).after('<a id="tweet-button'+panelNumber+'" class="twitter-share-button" style="float: right" href="https://twitter.com/intent/tweet?via=QUBDeLorean&amp;url='+WEBSITE_BASE_ADDRESS+'journeys.php?journey%3D'+journeyNumber+'&amp;text=The electric DeLorean Rides Again! '+distance+' on '+date+'&amp;count=none"><img src="img/twitter_blue_58.png" style="width:20px;height:20px;margin-right: 5px"></a>');
  }
}


/*
* Loads map and sets default zoom
* takes journey number and panel number as argument
*/
function load(journeyNumber, panelNumber) {

      // global var - var for marker bounds (used for setting the zoom and centre)
      markerBounds = new google.maps.LatLngBounds();
      // global var - new array holding polyline
      routeArray = [];
      // global var - create array for area chart
      areaChartInputData = [['Point', 'Speed (mph)', 'Battery (%)']];

      // setup map options
      var mapOptions={
        center: new google.maps.LatLng(54.5954, -5.876),
        zoom: 13,
        //mapTypeId: 'roadmap'
      };

      // checks if the map has been previously loaded (ie has HTML)
      // this is a proxy for all dynamic elements within the panel
      var mapPresent = document.getElementById("mapcanvas"+panelNumber).innerHTML;

      // if there is no map, create one plus the charts
      if (!mapPresent) {
        // global var - create new area chart
        areaChart = new google.visualization.AreaChart(document.getElementById("journey-area-chart"+panelNumber));
        // global var - create new map with map options - gets map element id by using "mapcanvas"+panelNumber
        map = new google.maps.Map(document.getElementById("mapcanvas"+panelNumber), mapOptions);
        // global var - creates varible for info window
        infoWindow = new google.maps.InfoWindow;
        // append journey number to get request
        var urlGet = "php/journeyDataLoadAjax.php?journey="+journeyNumber;
        // get data from MySQL and calls download URL function
        downloadUrl(urlGet, function(data) {
          var xml = data.responseXML;
          // if there are no results (might be a database error then fail gracefully)
          if (xml===null){
            alert(DATABASE_ERROR_MESSAGE);
          }
          // gets markers from xml
          var markers = xml.documentElement.getElementsByTagName("marker");
          // load the area chart
          loadAreaChart(markers);
          // load the map
          loadMap(markers);
        } // end download URL function
      );//end download url
    }// end if
  }// end load()




/*
Creates and loads the map
*/  
function loadMap(markers){
    // retrieve attributes for each element
    for (var i = 0; i < markers.length; i++) {
      var journeypoint = markers[i].getAttribute("journey_ref");
      var datapoint = markers[i].getAttribute("point");
      var speed = markers[i].getAttribute("speed");
      var batPer = markers[i].getAttribute("bat_percent");
      var point = new google.maps.LatLng(
        parseFloat(markers[i].getAttribute("lat")),
        parseFloat(markers[i].getAttribute("lng")));
      
      // add point to polyline array
      routeArray.push(point);
      // add marker to marker bounds
      markerBounds.extend(point);
      // create text for info window  
      var html = "Data Point: " + datapoint + "<br/>Speed: " + speed + " mph" + "<br/>Battery Charge: " + batPer + " %";
      //var icon = customIcons[type] || {};
      // create marker
      var marker = new google.maps.Marker({
        map: map,
        icon: {
          url: "img/black-dot.png"
        },
        position: point,
        opacity: 0
      });

      // call function
      bindInfoWindow(marker, map, infoWindow, html);
    }// end for
    // set zoom based on marker bounds
    map.fitBounds(markerBounds);

    // setup polyline options
    var routeLine = new google.maps.Polyline({
      path: routeArray,
      geodesic: true,
      strokeColor: '#FF0000',
      strokeOpacity: 1.0,
      strokeWeight: 2,
      // add icons to start and finish
      icons: [
      {
        icon: {
          path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
          scale: 4,
          strokeWeight: 2,
          fillColor: 'yellow',
          fillOpacity: 1
        },
        // start of line
        offset: '0%'
      }, {
        icon: {
          path: google.maps.SymbolPath.CIRCLE,
          scale: 5,
          strokeWeight: 2,
          fillColor: 'yellow',
          fillOpacity: 1
        },
        // end of line
        offset: '100%'
      }
      ]
    });
    // add line to map
    routeLine.setMap(map);
} // end loadMap


/*
Creates and loads the area chart
*/
function loadAreaChart(datapoints){
    // loop through datapoints
    for (var i = 0; i < datapoints.length; i++) {
      // push new datapoint (as array) to the main array
      areaChartInputData.push(["Data Point: "+datapoints[i].getAttribute("point"),parseFloat(datapoints[i].getAttribute("speed")), parseFloat(datapoints[i].getAttribute("bat_percent"))]);
    }// end for
    // convert data into data table
    dataArray = google.visualization.arrayToDataTable(areaChartInputData);
    // set chart options
    journeyAreaOptions = {
      vAxis: {minValue: 0,  titleTextStyle: {color: '#333'}},
      hAxis: {textPosition: 'none'},
      legend: {position: 'bottom'},
      chartArea:{left:30,top:50,width:'100%',height:'75%'},
      fontSize: 12,
      fontName: 'Biryani',
      interpolateNulls: true,
      lineWidth: 1
    };
      // draw chart
      areaChart.draw(dataArray, journeyAreaOptions);
}



/*
adds event listener to markers to manage clicks and diplay info windows
FROM: Google Maps API
*/
function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}




/*
Function to get column chart data via Ajax
*/
function prepJourneyColumnChart(journeyNumber, panelNumber){
  // setup url
  var urlGet = "php/journeyColumnDataLoadAjax.php?journey="+journeyNumber;
      // get data from MySQL then calls function
      downloadUrl(urlGet, function(data) {
        drawJourneyColumnChart(data.responseXML, panelNumber);
      });
    }



/*
Callback that creates and populates a data table,
instantiates a chart, passes in the data and draws it.
*/
function drawJourneyColumnChart(xml, panelNumber) {
    // global var - sets up start of data input array
    columnChartInputData = [['','Min','Journey','Average','Max']];
          // if there are no results (might be a database error then fail gracefully)
          if (xml===null){
            alert(DATABASE_ERROR_MESSAGE);
          }
          var sums = xml.documentElement.getElementsByTagName("sum");

  // cycles through results
  for (var i = 0; i < sums.length; i++) {
    // appends values to input data array
    columnChartInputData.push([(sums[i].getAttribute("parameter")), parseFloat(sums[i].getAttribute("min")), parseFloat(sums[i].getAttribute("val")), parseFloat(sums[i].getAttribute("average")), parseFloat(sums[i].getAttribute("max"))]);
  } // end for

  journeyColumnOptions = {
    chartArea:{left:30,top:10,width:'100%',height:'85%'},
    hAxis: {textStyle: {fontSize: 10}},
    legend: {position: 'in'},
    fontSize: 12,
    fontName: 'Biryani'
  };

  // parses the input array into a data table
  chartData = google.visualization.arrayToDataTable(columnChartInputData);
  // Create a columnchart
  columnChart = new google.visualization.ColumnChart(document.getElementById('journey-column-chart'+panelNumber));
  // Draw the chart
  columnChart.draw(chartData, journeyColumnOptions);
} // end function



/*
Works out how many panels are required and sends that number to the next function
*/
function setupAccordion(requiredJourney){
  // sets up URL
  var urlGet = "php/journeyCountAjax.php";
    // get data from MySQL and calls download URL function
    downloadUrl(urlGet, function(data) {
      var xml = data.responseXML;

        // if there are no results (might be a database error then fail gracefully)
        if (xml===null){
          alert(DATABASE_ERROR_MESSAGE);
        }

        // get xml element
        var journeyCountArray = xml.documentElement.getElementsByTagName("count");
        // get value from array
        journeyCount = journeyCountArray[0].getAttribute("journey_count"); 
        // if the script has received a required journey number
        if(typeof requiredJourney!=='undefined'){
          // defines url target
          var urlGetTarget = "php/panelCountAjax.php?req="+requiredJourney;
          // runs downloadURL function - passes in url
          downloadUrl(urlGetTarget, function(panelResult) {

            var xml = panelResult.responseXML;

              // if there are no results (might be a database error then fail gracefully)
              if (xml===null){
                alert(DATABASE_ERROR_MESSAGE);
              }
              // gets count from xml
              var resultArray = xml.documentElement.getElementsByTagName("count");
              // check for a blank entry in panels required
              // this happens when a journey is searched for but it doesn't exist in the database
              if (resultArray.length === 0) {
                alert(NO_JOURNEY_FOUND_MESSAGE);
                  // recursive call to run setupAccordion again withouth the journey number
                  setupAccordion();
                } else {
              // retrieve attribute    
              panelsRequired = resultArray[0].getAttribute("panel_count");
              // send parameters to function to manage message
              manageScrollMessage(journeyCount, panelsRequired);
              addNewPanels(panelsRequired);
            }
          } // end download URL function
          );//end download url
} else {
              // var to hold panel number check
              var panelCheck = 1;
              // check for the current highest panel number
              while($('#panel'+panelCheck).length){
                panelCheck++;
              }
              // correction to remove last increment in while loop
              // this is now equivalent to the total number of panels
              panelCheck-=1;
              // send parameters to function to manage message
              manageScrollMessage(journeyCount, panelCheck);
              // send the number of required panels to populateAccordion
              populateAccordion(panelCheck);

             } // end else
        }); // end download url
} // end setupAccordion



/*
Adds the HTML for the number of panesl required
*/
function addNewPanels(panelsRequired){

  // check how many panels exist
  // var to hold panel number
  panelNumber = 1;
  // check for the current highest panel number
  while($('#panel'+panelNumber).length){
    panelNumber++;
  }
  // var to hold current highest value
  highestPanel = panelNumber-1;

  // if a var was passed
  if (typeof panelsRequired!=='undefined') {
      // manages visual status of scroll message
      manageScrollMessage(journeyCount, panelsRequired);
  // check we have enough journeys to fill the panel numbers
  if (journeyCount>=panelsRequired) {
          // calculate how many more to add
          var additionalPanelsRequired = panelsRequired-highestPanel;
          // add them
          for (var loop = 0; loop < additionalPanelsRequired; loop++) {
              // add the new panel after the current highest panel number
              addPanelHTML(highestPanel, panelNumber);
              // incremenet highest panel, panel number and while count
              highestPanel++;
              panelNumber++;
            } // end for

            populateAccordion(highestPanel, panelsRequired);
          } else {
    // show user error message
    alert(GENERAL_ERROR_MESSAGE);
    }

      // if a var wasn't passed as an argument
    } else {
      // manages visual status of scroll message
      manageScrollMessage(journeyCount, panelsRequired);
      // var to manage the maximum number of new panels to add
      var whileCount = 1;
      // while loop - runs if there are more journeys to load
      // and the number of panels added is less than the max stated
      while((journeyCount>highestPanel) && (whileCount<=MAX_PANELS_TO_ADD)){
          // manages visual status of scroll message
          manageScrollMessage(journeyCount, panelsRequired);
          // add the new panel after the current highest panel number
          addPanelHTML(highestPanel, panelNumber);
          // incremenet highest panel, panel number and while count
          highestPanel++;
          panelNumber++;
          whileCount++;
      }// end while
      // populate the panels with content
      populateAccordion(highestPanel);
  } // end else
} // end add new panels




/*
Helper function to add HTML
*/
function addPanelHTML(highestPanel, panelNumber){
  // adds html after highest panel
  $("#panel"+highestPanel).after("<div class='panel panel-default accordion-panel' id='panel"+panelNumber+"'> <div class='panel-heading' id='panel-heading"+panelNumber+"'> <h4 class='panel-title'> <a id='panelLink"+panelNumber+"' data-toggle='collapse' data-parent='#accordion' href='#collapse"+panelNumber+"'> <div class='row'> <div class='col-md-2 hidden-xs hidden-sm panel-title-expand'> <div id='expand-icon"+panelNumber+"' class='fa fa-angle-right fa-2x expand-symbol'></div> </div> <div class='col-md-7 panel-title-text'> <p class='accordion-title' id='journeyP"+panelNumber+"'>Journey x</p> <p id='dateP"+panelNumber+"'>Date x</p> <p id='startP"+panelNumber+"'>Start x</p> <p id='distanceP"+panelNumber+"'>x miles</p> </div> <div class='col-md-3 panel-title-map'> <img src='img/sampleMap02.jpg' id='panel-static-image"+panelNumber+"'/> </div> </div> </a> </h4> </div> <div id='collapse"+panelNumber+"' class='panel-collapse collapse'> <div class='panel-body'> <div class = 'journey-social-holder'> <a id='facebook-button"+panelNumber+"' style='float: right' href='"+WEBSITE_BASE_ADDRESS+"journeys.php' data-image='"+WEBSITE_BASE_ADDRESS+"img/qubev.png' data-title='The Electric DeLorean Rides Again!' data-desc='Some description k jh for this article' class='btnShare'><img src='img/FB-f-Logo__blue_58.png' alt='share' style='width:20px;height:20px;'></a> <p>share this journey</p> </div> <div class = 'googlemap'> <div id='mapcanvas"+panelNumber+"' style='width: 100%; height: 300px;'></div> </div> <div id='journey-area-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> <div style='width: 100%; height:30px;'></div> <div class='row'> <div class='col-md-4 box'> <div style='width: 100%; height:30px;'></div> <p>Start Time: <span id='start-stat"+panelNumber+"'>xxxxxx</span></p> <p>End Time: <span id='end-stat"+panelNumber+"'>xxxxxx</span></p> <p> Distance: <span id='distance-stat"+panelNumber+"'>xxxxxx</span> miles</p> <p>Duration: <span id='duration-stat"+panelNumber+"'>xxxxxx</span> minutes</p> <p>Speed: <span id='speed-stat"+panelNumber+"'>xxxxxx</span> mph</p> <p>Petrol Saved: <span id='petrol-stat"+panelNumber+"'>xxxxxx</span> L</p> <p>CO<sub>2</sub> Saved: <span id='co2-stat"+panelNumber+"'>xxxxxxx</span> kg</p> </div> <div class='col-md-8 box'> <div id='journey-column-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> </div> </div> </div> </div> </div>");    
}



/*
Helper function to manage scroll message
*/
function manageScrollMessage(journeyCount, panelCount){
  // checks if there are more journeys than panels
  if (journeyCount>panelCount) {
    $("#scroll-message").css("display", "block");
  } else {
   $("#scroll-message").css("display", "none");
 }
}



/*
Populates the panesl with the right ammount of data
*/
function populateAccordion(journeysRequired, journeyToHighlight){
  // sets up URL
  var urlGetData = "php/accordionManagerAjax.php?panels="+journeysRequired;
  //runs downloadURL
  downloadUrl(urlGetData, function(dataResult) {
  //adds result to var
  var xml = dataResult.responseXML;

  // if there are no results (might be a database error then fail gracefully)
  if (xml===null){
    alert(DATABASE_ERROR_MESSAGE);
  }
  // adds journey records ro arry
  var journeyArray = xml.documentElement.getElementsByTagName("journeyrecord");

    // retrieve attributes for each element
    for (var i = 0; i < journeyArray.length; ++i) {
        //Creating all the vars for clarity
        var journeyID = journeyArray[i].getAttribute("journeyID");
        var date = journeyArray[i].getAttribute("date");
        var start = journeyArray[i].getAttribute("start");
        var end = journeyArray[i].getAttribute("end");
        var distance = journeyArray[i].getAttribute("distance");
        var duration = journeyArray[i].getAttribute("duration");
        var speed = journeyArray[i].getAttribute("speed");
        var petrol = journeyArray[i].getAttribute("petrol");
        var co2 = journeyArray[i].getAttribute("co2");
        var startLat = journeyArray[i].getAttribute("startLat");
        var startLong = journeyArray[i].getAttribute("startLong");
        var endLat = journeyArray[i].getAttribute("endLat");
        var endLong = journeyArray[i].getAttribute("endLong");
        // adjusts panel number
        var panelNumber = i+1;
    	  // show accordion panels
       document.getElementById("panel"+panelNumber).style.display="block";
      	// update headings
      	document.getElementById("journeyP"+panelNumber).innerHTML = "Journey "+journeyID;
      	document.getElementById("dateP"+panelNumber).innerHTML = date;
        document.getElementById("startP"+panelNumber).innerHTML = "Start: "+start;
        document.getElementById("distanceP"+panelNumber).innerHTML = distance+" miles";
        // facebook setup
        var facebookButton = document.getElementById("facebook-button"+panelNumber);
        facebookButton.setAttribute('data-desc', 'It travelled '+distance+' miles on '+date);
        facebookButton.href= WEBSITE_BASE_ADDRESS+'journeys.php?journey='+journeyID;
        // get static image (scale=2 returns high res version)
        document.getElementById("panel-static-image"+panelNumber).src = "//maps.googleapis.com/maps/api/staticmap?size=150x150&scale=1&maptype=roadmap&markers=color:green%7Clabel:S%7C"+startLat+","+startLong+"&markers=color:red%7Clabel:F%7C"+endLat+","+endLong;
        // update stats witihn panel
        document.getElementById("start-stat"+panelNumber).innerHTML = start;
        document.getElementById("end-stat"+panelNumber).innerHTML = end;
        document.getElementById("distance-stat"+panelNumber).innerHTML = distance;
        document.getElementById("duration-stat"+panelNumber).innerHTML = duration;
        document.getElementById("speed-stat"+panelNumber).innerHTML = speed;
        document.getElementById("petrol-stat"+panelNumber).innerHTML = petrol;
        document.getElementById("co2-stat"+panelNumber).innerHTML = co2;
        
    }// end for

    // if there is a journey to highlight, move there and expand it
    if (typeof journeyToHighlight!=='undefined') {
            // mimic click on correct panel
            // expands and highlights
            document.getElementById("journeyP"+journeyToHighlight).click();
            // zoom to correct panel
            $('html, body').animate({scrollTop: $("#journeyP"+journeyToHighlight).offset().top-100}, 500);
        }
    } // end download URL function
  );//end download url
}// end populateAccordion()




/*
listener to manage rotation of the expand/collapse symbol and panel header colour
*/
$(".panel-group").on('hide.bs.collapse',".panel-collapse", function() {
    // get the id of the div clicked
    var panelNumber = this.id;
    // trim the parent id to leave just the number
    panelNumber = panelNumber.replace('collapse','');
    // rotate symbol
    var expandSymbol = document.getElementById("expand-icon"+panelNumber);
    expandSymbol.style.transform = "rotate(0deg)";
    expandSymbol.style.transition = "transform 0.75s";
        // change background colour of the header (show it's active)
        $("#panel-heading"+panelNumber).css({
          transition: 'background-color 0.75s linear',
          "background-color": "#F5F5F5"
        });
      });




/*
listener to manage rotation of the expand/collapse symbol and panel header colour
*/
$(".panel-group").on('show.bs.collapse',".panel-collapse", function() {
    // get the id of the div clicked
    var panelNumber = this.id;
    // trim the parent id to leave just the number
    panelNumber = panelNumber.replace('collapse','');
    // rotate symbol
    var expandSymbol = document.getElementById("expand-icon"+panelNumber);
    expandSymbol.style.transform = "rotate(90deg)";
    expandSymbol.style.transition = "transform 0.75s";
    // change background colour of the header (show it's active)
    $("#panel-heading"+panelNumber).css({
      transition: 'background-color 0.75s linear',
      "background-color": "#e1ebf5"
    });
  });


/*
listens for an expansion of the panel group (parent)
then gets waht was actually clicked (panel-collpase) and passes it thoguht to the function
*/
$(".panel-group").on('shown.bs.collapse',".panel-collapse", function() {
    // get the id of the div clicked
    var panelNumber = this.id;
    // trim the parent id to leave just the number
    panelNumber = panelNumber.replace('collapse','');
    // get the text from the journey title
    var journeyNumber = document.getElementById("journeyP"+panelNumber).innerHTML;
     // trim off the hourney text to leave the journey number
     journeyNumber = journeyNumber.replace('Journey ','');
     // send the journey number to map loader
     load(journeyNumber, panelNumber);
    // call loading of column chart
    prepJourneyColumnChart(journeyNumber, panelNumber);
    insertTwitter(journeyNumber, panelNumber);
  });


/*
listener to check for scrolling to the bottom of the page then calls addNewPanels()
*/
$(window).scroll(function() {
  if($(window).scrollTop() == $(document).height() - $(window).height()) {
   addNewPanels();
 }
});


/*
listener to resize charts on window resize
*/
$( window ).resize(function() {
  areaChart.draw(dataArray, journeyAreaOptions);
  columnChart.draw(chartData, journeyColumnOptions);
});


 /*
 Script to manage facebook share click
*/
$(document).on('click', '.btnShare',function(){
  elem = $(this);
  postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));
  return false;
});

