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
		$("#panel"+highestPanel).after("<div class='panel panel-default accordion-panel' style='display:block' id='panel"+panelNumber+"'> <div class='panel-heading'> <h4 class='panel-title'> <a id='panelLink6' data-toggle='collapse' data-parent='#accordion' href='#collapse6'> <div class='row'> <div class='col-md-8'> <p class='accordion-title' id='journeyP6'>Journey x</p> <p id='dateP6'>Date x</p> <p id='startP6'>Start x</p> <p><small>13 km</small></p> </div> <div class='col-md-4'> <img src='img/sampleMap02.jpg' id='panel-static-image6'/> </div> </a> </h4> </div> <div id='collapse6' class='panel-collapse collapse'> <div class='panel-body'> <div class = 'googlemap'> <div id='mapcanvas6' style='width: 100%; height: 300px;'></div> </div> <div id='journey-area-chart6' style='width: 100%; height: 300px'></div> <div style='width: 100%; height:30px;'></div> <div class='row'> <div class='col-md-4 box'> <div style='width: 100%; height:30px;'></div> <p>Start Time: <span id='start-stat6'>xxxxxx</span></p> <p>End Time: <span id='end-stat6'>xxxxxx</span></p> <p> Distance: <span id='distance-stat6'>xxxxxx</span> miles</p> <p>Duration: <span id='duration-stat6'>xxxxxx</span> minutes</p> <p>Speed: <span id='speed-stat6'>xxxxxx</span> mph</p> <p>Petrol Saved: <span id='petrol-stat6'>xxxxxx</span> L</p> <p>CO2 Saved: <span id='co2-stat6'>xxxxxxx</span> kg</p> </div> <div class='col-md-8 box'> <div id='journey-column-chart6' style='width: 100%; height: 300px'></div> </div> </div> </div> </div> </div>");	// panelNumber++;
	}
}