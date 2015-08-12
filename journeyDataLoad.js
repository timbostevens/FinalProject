// When a panel is expanded, this waits for it to load then calls load(this.id)
  $(".panel-collapse").on('shown.bs.collapse', function() {
    // get the id of the div clicked
    var divClicked = document.getElementById(this.id);
    // get the parent id
    var panelNumber = divClicked.parentNode.id;
    // trim the parent id to leave just the number
    panelNumber = panelNumber.replace('panel','');
    // get the text from the journey title
     var journeyNumber = document.getElementById("journeyP"+panelNumber).innerHTML;
     // trim off the hourney text to leave the journey number
     journeyNumber = journeyNumber.replace('Journey ','');
     // send the journey number to map loader
    load(journeyNumber, panelNumber);
    // call loading of scatter chart
    loadScatterChart();
});

/*
    * Loads map and sets default zoom
    * takes journey number and panel number as argument
    */
    function load(journeyNumber, panelNumber) {
      
      // console.log(journeyNumber, panelNumber);

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

      /////////////////////////////////////////////
      // IMPLEMENT A CHECK FOR the map already having contents
      ////////////////////////////////////////////
      // global var - create new area chart
      chart = new google.visualization.AreaChart(document.getElementById("journey-area-chart"+panelNumber));
      // global var - create new map with map options - gets map element id by using "mapcanvas"+panelNumber
      map = new google.maps.Map(document.getElementById("mapcanvas"+panelNumber), mapOptions);
      // global var - creates varible for info window
      infoWindow = new google.maps.InfoWindow;

      // append journey number to get request
      var urlGet = "journeyDataLoadAjax.php?journey="+journeyNumber;

      // get data from MySQL and calls download URL function
      downloadUrl(urlGet, function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        // load the area chart
        loadAreaChart(markers);
        // load the map
        loadMap(markers);
        


      } // end download URL function
    );//end download url
  }// end load()

    
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
          var html = "Journey Ref: "+journeypoint+"<br/>Data Point: " + datapoint + "<br/>Speed: " + speed + " mph" + "<br/>Battery Charge: " + batPer + " %";
          //var icon = customIcons[type] || {};
          
          // create marker
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            opacity: 0
          });

          // call function
          bindInfoWindow(marker, map, infoWindow, html);

           // on the last pass do this
           // CAN I MOVE THIS DOWN AND NOT IN AN IF?
           if(i==(markers.length-1)){
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

          }// end last pass if
        }// end for
    } // end loadMap


    function loadAreaChart(datapoints){

        for (var i = 0; i < datapoints.length; i++) {
          // push new datapoint (as array) to the main array
          areaChartInputData.push([datapoints[i].getAttribute("point"),parseFloat(datapoints[i].getAttribute("speed")), parseFloat(datapoints[i].getAttribute("bat_percent"))]);
        }// end for
        
        // convert data into data table
        var dataArray = google.visualization.arrayToDataTable(areaChartInputData);
        // set chart options
        var options = {
          vAxis: {minValue: 0,  titleTextStyle: {color: '#333'}},
          hAxis: {textPosition: 'bottom'},
          legend: {position: 'bottom'},
          chartArea:{left:30,top:50,width:'100%',height:'75%'},
          fontSize: 12,
          fontName: 'Biryani',
          interpolateNulls: true,
          lineWidth: 1
          };
          // draw chart
          chart.draw(dataArray, options);
    }


    /*
    * adds event listener to markers to manage clicks and diplay info windows
    */
    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    /*
    * Gets XML data
    */
    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

      request.onreadystatechange = function() {
        // ready state == 4 means complete
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
// Ajax request (GET request tyoe, url, true = asynchronous)
request.open('GET', url, true);
      // sends the Ajax request
      request.send(null);
    }

    function doNothing() {}





