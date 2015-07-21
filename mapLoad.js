/*
    * Loads map and sets default zoom
    * takes journey number as argument
    */
    function load(journeyNumber) {
        // vars for finding centre and zoom
        var minLat;
        var maxLat;
        var minLong;
        var maxLong;
      // arrays for lats and longs
      var latArray = [];
      var longArray = [];




      // setup map options
      var mapOptions={
        center: new google.maps.LatLng(54.5954, -5.876),
        zoom: 13,
        //mapTypeId: 'roadmap'
      };

      // create new map with map options
      var map = new google.maps.Map(document.getElementById("map"), mapOptions);
      // creates varible for info window
      var infoWindow = new google.maps.InfoWindow;



      // append journey number to get request
      var urlGet = "phpsqlajax_genxml3.php?journey="+journeyNumber;


      // get data from MySQL and calls download URL function
      downloadUrl(urlGet, function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        // retrieve attributes for each element
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var speed = markers[i].getAttribute("speed");
          var batCur = markers[i].getAttribute("b_current");
          var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
          // add lat and long to arrays
          latArray.push(parseFloat(markers[i].getAttribute("lat")));
          longArray.push(parseFloat(markers[i].getAttribute("lng")));
          
          // create text for info window  
          var html = "Data Point: " + name + "<br/>Speed: " + speed + " km/h" + "<br/>Battery Current: " + batCur + " A";
          //var icon = customIcons[type] || {};
          // create marker
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            //icon: icon.icon
          });
          // call function
          bindInfoWindow(marker, map, infoWindow, html);

           // on the last pass do this stuff
           if(i==(markers.length-1)){
            // calculate centre lat and longs
            var centLat = Math.min.apply(null, latArray) + ((Math.max.apply(null, latArray)-Math.min.apply(null, latArray))/2);
            var centLong = Math.min.apply(null, longArray) + ((Math.max.apply(null, longArray)-Math.min.apply(null, longArray))/2);
              // create updated map options
            var updatedMapOptions = {
                center: new google.maps.LatLng(centLat,centLong),
                // center: new google.maps.LatLng(57.5, -4),
                zoom: 17,
              };// end updated map options

            map.setOptions(updatedMapOptions);
          }// end if

        }// end for

      } // end download URL function

    );//end download url
  }// end load()

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