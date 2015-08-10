function setupAccordion(){
	

// get request
var urlGet = "accordionManagerAjax.php";

downloadUrl(urlGet, function(data) {
	var xml = data.responseXML;
	var journeyArray = xml.documentElement.getElementsByTagName("journeyrecord");
        // retrieve attributes for each element
        


        for (var i = 0; i < journeyArray.length; ++i) {
        	
            /////////////////////////////////////////////////////////////
            //Probably don't have to create all the vars - good for clarity though
            /////////////////////////////////////////////////////////////

            var journeyID = journeyArray[i].getAttribute("journeyID");
        	var date = journeyArray[i].getAttribute("date");
            var start = journeyArray[i].getAttribute("start");
            var end = journeyArray[i].getAttribute("end");
            var distance = journeyArray[i].getAttribute("distance");
            var duration = journeyArray[i].getAttribute("duration");
            var speed = journeyArray[i].getAttribute("speed");
            
            ///////////////////////
            /////Not in place yet
            ///////////////////////

            //var energy = journeyArray[i].getAttribute("energy");
            //var co2 = journeyArray[i].getAttribute("co2");

          	var panelNumber = i+1;
        	// show accordion panels
        	document.getElementById("panel"+panelNumber).style.display="block";

        	// update headings
        	document.getElementById("journeyP"+panelNumber).innerHTML = "Journey "+journeyID;
        	document.getElementById("dateP"+panelNumber).innerHTML = date;
            document.getElementById("startP"+panelNumber).innerHTML = "Start: "+start;
        	// get static image (scale=2 returns high res version)
            document.getElementById("panel-static-image"+panelNumber).src = "//maps.googleapis.com/maps/api/staticmap?center=54.599653,-5.923886&zoom=13&size=200x200&scale=2&maptype=terrain";
            // update stats witihn panel
            document.getElementById("start-stat"+panelNumber).innerHTML = start;
            document.getElementById("end-stat"+panelNumber).innerHTML = end;
            document.getElementById("distance-stat"+panelNumber).innerHTML = distance;
            document.getElementById("duration-stat"+panelNumber).innerHTML = duration;
            document.getElementById("speed-stat"+panelNumber).innerHTML = speed;
            
            ///////////////////////
            /////Not in place yet
            ///////////////////////


            //document.getElementById("energy-stat"+panelNumber).innerHTML = energy;
            //document.getElementById("co2-stat"+panelNumber).innerHTML = co2;


            //console.log(energy, co2);

        }// end for
      } // end download URL function
    );//end download url
  }// end setupAccordion()

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
