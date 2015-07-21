/*
    * Loads map and sets default zoom
    * takes journey number as argument
    */
    function load(journeyNumber) {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(54.5954, -5.876),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
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
        }
      });
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