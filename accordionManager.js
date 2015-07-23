function accordionManager(journeyCount){
	
	// cycle throught the panels and show them if there are journeys to fill them
	for (var i = 1; i <= journeyCount; i++) {
		
		document.getElementById("panel"+i).style.display = "block";
	};


}