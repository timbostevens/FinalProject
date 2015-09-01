function setupAccordion(){
	
// var to hold panel number check
var panelCheck = 1;
// check for the current highest panel number
while($('#panel'+panelCheck).length){
    panelCheck++;
}
// correction to remove last increment in while loop
// this is now equivalent to the ttla number of panels
panelCheck-=1;

//////////////////////////////////////////////
// get request - the panelCheck attribute tells the query how many journeys to limit the request to
// SHOULD I SOMEHOW ASK IT TO RETURN ONLY 5 MORE RESULTS?
/////////////////////////////////////////////


var urlGet = "accordionManagerAjax.php?panels="+panelCheck;

downloadUrl(urlGet, function(dataResult) {
	var xml = dataResult.responseXML;
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
            var petrol = journeyArray[i].getAttribute("petrol");
            var co2 = journeyArray[i].getAttribute("co2");
            var startLat = journeyArray[i].getAttribute("startLat");
            var startLong = journeyArray[i].getAttribute("startLong");
            var endLat = journeyArray[i].getAttribute("endLat");
            var endLong = journeyArray[i].getAttribute("endLong");



          	var panelNumber = i+1;
        	// show accordion panels
        	document.getElementById("panel"+panelNumber).style.display="block";

        	// update headings
        	document.getElementById("journeyP"+panelNumber).innerHTML = "Journey "+journeyID;
        	document.getElementById("dateP"+panelNumber).innerHTML = date;
            document.getElementById("startP"+panelNumber).innerHTML = "Start: "+start;
            document.getElementById("distanceP"+panelNumber).innerHTML = distance+" miles";
            // create twitter message string
            var twitterMessage = "The Electric DeLorean Rides Again! "+distance+" miles on "+date;
            // get twitter button
            var tweetButton = document.getElementById("tweet-button"+panelNumber);
            // change text in the message

            //////////////////////////////
            // NEED TO WORK ON THE TEXT REPLACEMENT STRING - CAN'T EXPLAIN IT AT PRESENT
            /////////////////////////////

            tweetButton.src = tweetButton.src.replace(/&text=[^&]+/, "&text=" + encodeURIComponent(twitterMessage));

            // facebook button updated with custom text
            var facebookButton = document.getElementById("facebook-button"+panelNumber);
            facebookButton.setAttribute('data-desc', 'It travelled '+distance+' miles on '+date);

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
      } // end download URL function
    );//end download url
  }// end setupAccordion()

