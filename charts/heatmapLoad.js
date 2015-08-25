
// setup url
var urlGet = "charts/heatDataLoadAjax.php";

// get data from MySQL then calls function
downloadUrl(urlGet, function(data) {
  var xml = data.responseXML;
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

});





