function setupAccordion(){
	

// get request
var urlGet = "accordionManagerAjax.php";

downloadUrl(urlGet, function(data) {
	var xml = data.responseXML;
	var journeyArray = xml.documentElement.getElementsByTagName("journeyrecord");
        // retrieve attributes for each element
        


        for (var i = 0; i < journeyArray.length; ++i) {
        	var journeyID = journeyArray[i].getAttribute("journeyID");
        	var date = journeyArray[i].getAttribute("date");
          	var panelNumber = i+1;

        	// show accordion panels
        	document.getElementById("panel"+(panelNumber)).style.display="block";

        	// update panelBody id
        	document.getElementById("panelBody"+(panelNumber)).id = journeyID;
        	// update headings
        	document.getElementById("journeyP"+(panelNumber)).innerHTML = "Journey "+journeyID;
        	document.getElementById("dateP"+(panelNumber)).innerHTML = date;
        	// update href to match new panel id
        	document.getElementById("panelLink"+(panelNumber)).href = "#"+journeyID;
        	// update map canvas
        	//document.getElementById("mapCan"+(panelNumber)).id = "mapCanvas"+journeyID;
           
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
