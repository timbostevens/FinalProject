function addNewPanels(){

// loop 5 times (to add 5 panels)
for (var i = 0; i <= 4; i++) {

	// var to hold panel number
	var panelNumber = 1;
	// check for the current highest panel number
	while($('#panel'+panelNumber).length){
		panelNumber++;
	}
	// var to hold current highest value
	var highestPanel = panelNumber-1;

	// add the new panel after the current highest panel number
		$("#panel"+highestPanel).after("<div class='panel panel-default accordion-panel' id='panel"+panelNumber+"'> <div class='panel-heading'> <h4 class='panel-title'> <a id='panelLink"+panelNumber+"' data-toggle='collapse' data-parent='#accordion' href='#collapse"+panelNumber+"'> <div class='row'> <div class='col-md-8'> <p class='accordion-title' id='journeyP"+panelNumber+"'>Journey x</p> <p id='dateP"+panelNumber+"'>Date x</p> <p id='startP"+panelNumber+"'>Start x</p> <p><small>13 km</small></p> </div> <div class='col-md-4'> <img src='img/sampleMap02.jpg' id='panel-static-image"+panelNumber+"'/> </div> </a> </h4> </div> <div id='collapse"+panelNumber+"' class='panel-collapse collapse'> <div class='panel-body'> <div class = 'googlemap'> <div id='mapcanvas"+panelNumber+"' style='width: 100%; height: 300px;'></div> </div> <div id='journey-area-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> <div style='width: 100%; height:30px;'></div> <div class='row'> <div class='col-md-4 box'> <div style='width: 100%; height:30px;'></div> <p>Start Time: <span id='start-stat"+panelNumber+"'>xxxxxx</span></p> <p>End Time: <span id='end-stat"+panelNumber+"'>xxxxxx</span></p> <p> Distance: <span id='distance-stat"+panelNumber+"'>xxxxxx</span> miles</p> <p>Duration: <span id='duration-stat"+panelNumber+"'>xxxxxx</span> minutes</p> <p>Speed: <span id='speed-stat"+panelNumber+"'>xxxxxx</span> mph</p> <p>Petrol Saved: <span id='petrol-stat"+panelNumber+"'>xxxxxx</span> L</p> <p>CO2 Saved: <span id='co2-stat"+panelNumber+"'>xxxxxxx</span> kg</p> </div> <div class='col-md-8 box'> <div id='journey-column-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> </div> </div> </div> </div> </div>");	
	}
	// refreshes the accordion
	setupAccordion();
}