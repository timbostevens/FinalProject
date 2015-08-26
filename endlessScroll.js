// pseodo-constant stating the maximum number of panels to add in one load
var MAX_PANELS_TO_ADD = 5;

function addNewPanels(){

	// var to hold panel number
	panelNumber = 1;
	// check for the current highest panel number
	while($('#panel'+panelNumber).length){
		panelNumber++;
	}
	// var to hold current highest value
	highestPanel = panelNumber-1;

	// Ajax call string
	var urlGet = "journeyCountAjax.php";
	// get data from MySQL and calls download URL function
	downloadUrl(urlGet, function(data) {
		var xml = data.responseXML;
		// get xml element
		var journeyCountArray = xml.documentElement.getElementsByTagName("count");
		// get value from array
		var journeyCount = journeyCountArray[0].getAttribute("journey_count");  

		// var to manage the maximum number of new panels to add
		var whileCount = 1;
		// while loop - runs if there are more journeys to load
		// and the number of panels added is less than the max stated
		while((journeyCount>highestPanel) && (whileCount<=MAX_PANELS_TO_ADD)){
			// add the new panel after the current highest panel number
			$("#panel"+highestPanel).after("<div class='panel panel-default accordion-panel' id='panel"+panelNumber+"'> <div class='panel-heading'> <h4 class='panel-title'> <a id='panelLink"+panelNumber+"' data-toggle='collapse' data-parent='#accordion' href='#collapse"+panelNumber+"'> <div class='row'> <div class='col-md-8'> <p class='accordion-title' id='journeyP"+panelNumber+"'>Journey x</p> <p id='dateP"+panelNumber+"'>Date x</p> <p id='startP"+panelNumber+"'>Start x</p> <p id='distanceP"+panelNumber+"'>x miles</p> <iframe id='tweet-button"+panelNumber+"' allowtransparency='true' frameborder='0' scrolling='no' src='http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=horizontal' style='width:110px; height:20px;'></iframe></div> <div class='col-md-4'> <img src='img/sampleMap02.jpg' id='panel-static-image"+panelNumber+"'/> </div> </a> </h4> </div> <div id='collapse"+panelNumber+"' class='panel-collapse collapse'> <div class='panel-body'> <div class = 'googlemap'> <div id='mapcanvas"+panelNumber+"' style='width: 100%; height: 300px;'></div> </div> <div id='journey-area-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> <div style='width: 100%; height:30px;'></div> <div class='row'> <div class='col-md-4 box'> <div style='width: 100%; height:30px;'></div> <p>Start Time: <span id='start-stat"+panelNumber+"'>xxxxxx</span></p> <p>End Time: <span id='end-stat"+panelNumber+"'>xxxxxx</span></p> <p> Distance: <span id='distance-stat"+panelNumber+"'>xxxxxx</span> miles</p> <p>Duration: <span id='duration-stat"+panelNumber+"'>xxxxxx</span> minutes</p> <p>Speed: <span id='speed-stat"+panelNumber+"'>xxxxxx</span> mph</p> <p>Petrol Saved: <span id='petrol-stat"+panelNumber+"'>xxxxxx</span> L</p> <p>CO2 Saved: <span id='co2-stat"+panelNumber+"'>xxxxxxx</span> kg</p> </div> <div class='col-md-8 box'> <div id='journey-column-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> </div> </div> </div> </div> </div>");	
			// incremenet highest panel, panel number and while count
			highestPanel++;
			panelNumber++;
			whileCount++;
			// checks for the final loop of the while
			if((journeyCount==highestPanel) || (whileCount==MAX_PANELS_TO_ADD)){
				// refreshes the data in the panels
				setupAccordion();
			}// end if
		}// end while
    } // end download URL function
	);//end download url
}