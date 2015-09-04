// pseodo-constant stating the maximum number of panels to add in one load
var MAX_PANELS_TO_ADD = 5;

var NO_JOURNEY_FOUND_MESSAGE = "Ooops, it looks like you requested a journey that doesn't exist.\n\nI'm going to load the 5 most recent instead";


/*
Works out how many panels are required and sends that number to the next function
*/
function setupAccordion(requiredJourney){

// if the script has received a required journey number
if(typeof requiredJourney!=='undefined'){

            var urlGetTarget = "howManyPanelAjax.php?req="+requiredJourney;

            downloadUrl(urlGetTarget, function(panelResult) {
                var xml = panelResult.responseXML;
                var resultArray = xml.documentElement.getElementsByTagName("count");
                // retrieve attribute    
                panelsRequired = resultArray[0].getAttribute("panel_count");

                // check for a blank entry in panels required
                // this happens when a journey is searched for but it doesn't exist in the database
                if (panelsRequired==="") {

                    alert(NO_JOURNEY_FOUND_MESSAGE);
                    
                    // recursive call to run setupAccordion again withouth the journey number
                    setupAccordion();


                } else {
                //before they are populated, the correct number of panesl need to be created.
                addNewPanels(panelsRequired);
            }


            } // end download URL function
            );//end download url
} else {

            // var to hold panel number check
            var panelCheck = 1;
            // check for the current highest panel number
            while($('#panel'+panelCheck).length){
                panelCheck++;
            }
            // correction to remove last increment in while loop
            // this is now equivalent to the total number of panels
            panelCheck-=1;
            // send the number of required panels to populateAccordion
            populateAccordion(panelCheck);
    } // end else

} // end setupAccordion


/*
Adds the HTML for the number of panesl required
*/
  function addNewPanels(panelsRequired){

    // check how many panels exist
    // var to hold panel number
    panelNumber = 1;
    // check for the current highest panel number
    while($('#panel'+panelNumber).length){
        panelNumber++;
    }
    // var to hold current highest value
    highestPanel = panelNumber-1;

    // check how many journeys there are in the database
    // Ajax call string
    var urlGet = "journeyCountAjax.php";
    // get data from MySQL and calls download URL function
    downloadUrl(urlGet, function(data) {
        var xml = data.responseXML;
        // get xml element
        var journeyCountArray = xml.documentElement.getElementsByTagName("count");
        // get value from array
        var journeyCount = journeyCountArray[0].getAttribute("journey_count"); 

        // if a var was passed
        if (typeof panelsRequired!=='undefined') {
        // check we have enough journeys to fill the panel numbers
                if (journeyCount>=panelsRequired) {
                // calculate how many more to add
                var additionalPanelsRequired = panelsRequired-highestPanel;
                // console.log("Got: "+highestPanel+", Need: "+panelsRequired+", Journeys: "+journeyCount+", Additional Required: "+additionalPanelsRequired);
                // add them
                        for (var loop = 0; loop < additionalPanelsRequired; loop++) {
                            // add the new panel after the current highest panel number
                            $("#panel"+highestPanel).after("<div class='panel panel-default accordion-panel' id='panel"+panelNumber+"'> <div class='panel-heading' id='panel-heading"+panelNumber+"'> <h4 class='panel-title'> <a id='panelLink"+panelNumber+"' data-toggle='collapse' data-parent='#accordion' href='#collapse"+panelNumber+"'> <div class='row'> <div class='col-md-2 hidden-xs hidden-sm panel-title-expand'> <div id='expand-icon"+panelNumber+"' class='fa fa-angle-right fa-2x expand-symbol'></div> </div> <div class='col-md-7 panel-title-text'> <p class='accordion-title' id='journeyP"+panelNumber+"'>Journey x</p> <p id='dateP"+panelNumber+"'>Date x</p> <p id='startP"+panelNumber+"'>Start x</p> <p id='distanceP"+panelNumber+"'>x miles</p> </div> <div class='col-md-3 panel-title-map'> <img src='img/sampleMap02.jpg' id='panel-static-image"+panelNumber+"'/> </div> </div> </a> </h4> </div> <div id='collapse"+panelNumber+"' class='panel-collapse collapse'> <div class='panel-body'> <div class = 'journey-social-holder'> <a id='facebook-button"+panelNumber+"' style='float: right' href='http://localhost/Project/FinalProject/journeys.php' data-image='http://localhost/Project/FinalProject/img/qubev.png' data-title='The Electric Delorean Rides Again!' data-desc='Some description k jh for this article' class='btnShare'><img src='img/FB-f-Logo__blue_58.png' alt='share' style='width:20px;height:20px;'></a> <iframe id='tweet-button"+panelNumber+"' allowtransparency='true' frameborder='0' scrolling='no'src='http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=none'style='width:70px; height:20px; float: right'></iframe> <p style='float: right'>share this journey</p> </div> <div class = 'googlemap'> <div id='mapcanvas"+panelNumber+"' style='width: 100%; height: 300px;'></div> </div> <div id='journey-area-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> <div style='width: 100%; height:30px;'></div> <div class='row'> <div class='col-md-4 box'> <div style='width: 100%; height:30px;'></div> <p>Start Time: <span id='start-stat"+panelNumber+"'>xxxxxx</span></p> <p>End Time: <span id='end-stat"+panelNumber+"'>xxxxxx</span></p> <p> Distance: <span id='distance-stat"+panelNumber+"'>xxxxxx</span> miles</p> <p>Duration: <span id='duration-stat"+panelNumber+"'>xxxxxx</span> minutes</p> <p>Speed: <span id='speed-stat"+panelNumber+"'>xxxxxx</span> mph</p> <p>Petrol Saved: <span id='petrol-stat"+panelNumber+"'>xxxxxx</span> L</p> <p>CO2 Saved: <span id='co2-stat"+panelNumber+"'>xxxxxxx</span> kg</p> </div> <div class='col-md-8 box'> <div id='journey-column-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> </div> </div> </div> </div> </div>");    
                            // incremenet highest panel, panel number and while count
                            highestPanel++;
                            panelNumber++;

                        } // end for

                        populateAccordion(highestPanel, panelsRequired);

                } else {
                    console.log("FAIL");
                }

        // if a var wasn't passed as an argument
        } else {

        // var to manage the maximum number of new panels to add
        var whileCount = 1;
        // while loop - runs if there are more journeys to load
        // and the number of panels added is less than the max stated
        while((journeyCount>highestPanel) && (whileCount<=MAX_PANELS_TO_ADD)){
            // add the new panel after the current highest panel number
            $("#panel"+highestPanel).after("<div class='panel panel-default accordion-panel' id='panel"+panelNumber+"'> <div class='panel-heading' id='panel-heading"+panelNumber+"'> <h4 class='panel-title'> <a id='panelLink"+panelNumber+"' data-toggle='collapse' data-parent='#accordion' href='#collapse"+panelNumber+"'> <div class='row'> <div class='col-md-2 hidden-xs hidden-sm panel-title-expand'> <div id='expand-icon"+panelNumber+"' class='fa fa-angle-right fa-2x expand-symbol'></div> </div> <div class='col-md-7 panel-title-text'> <p class='accordion-title' id='journeyP"+panelNumber+"'>Journey x</p> <p id='dateP"+panelNumber+"'>Date x</p> <p id='startP"+panelNumber+"'>Start x</p> <p id='distanceP"+panelNumber+"'>x miles</p> </div> <div class='col-md-3 panel-title-map'> <img src='img/sampleMap02.jpg' id='panel-static-image"+panelNumber+"'/> </div> </div> </a> </h4> </div> <div id='collapse"+panelNumber+"' class='panel-collapse collapse'> <div class='panel-body'> <div class = 'journey-social-holder'> <a id='facebook-button"+panelNumber+"' style='float: right' href='http://localhost/Project/FinalProject/journeys.php' data-image='http://localhost/Project/FinalProject/img/qubev.png' data-title='The Electric Delorean Rides Again!' data-desc='Some description k jh for this article' class='btnShare'><img src='img/FB-f-Logo__blue_58.png' alt='share' style='width:20px;height:20px;'></a> <iframe id='tweet-button"+panelNumber+"' allowtransparency='true' frameborder='0' scrolling='no'src='http://platform.twitter.com/widgets/tweet_button.html?via=QUBDeLorean&amp;text=Replace%20Me&amp;count=none'style='width:70px; height:20px; float: right'></iframe> <p style='float: right'>share this journey</p> </div> <div class = 'googlemap'> <div id='mapcanvas"+panelNumber+"' style='width: 100%; height: 300px;'></div> </div> <div id='journey-area-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> <div style='width: 100%; height:30px;'></div> <div class='row'> <div class='col-md-4 box'> <div style='width: 100%; height:30px;'></div> <p>Start Time: <span id='start-stat"+panelNumber+"'>xxxxxx</span></p> <p>End Time: <span id='end-stat"+panelNumber+"'>xxxxxx</span></p> <p> Distance: <span id='distance-stat"+panelNumber+"'>xxxxxx</span> miles</p> <p>Duration: <span id='duration-stat"+panelNumber+"'>xxxxxx</span> minutes</p> <p>Speed: <span id='speed-stat"+panelNumber+"'>xxxxxx</span> mph</p> <p>Petrol Saved: <span id='petrol-stat"+panelNumber+"'>xxxxxx</span> L</p> <p>CO2 Saved: <span id='co2-stat"+panelNumber+"'>xxxxxxx</span> kg</p> </div> <div class='col-md-8 box'> <div id='journey-column-chart"+panelNumber+"' style='width: 100%; height: 300px'></div> </div> </div> </div> </div> </div>");    
            // incremenet highest panel, panel number and while count
            highestPanel++;
            panelNumber++;
            whileCount++;

        }// end while
        // populate the panels with content
        populateAccordion(highestPanel);
    } // end else
    } // end download URL function
    );//end download url
} // end add new panels


/*
Populates the panesl with the right ammount of data
*/

function populateAccordion(journeysRequired, journeyToHighlight){

var urlGetData = "accordionManagerAjax.php?panels="+journeysRequired;

downloadUrl(urlGetData, function(dataResult) {
	var xml = dataResult.responseXML;
	var journeyArray = xml.documentElement.getElementsByTagName("journeyrecord");
        // retrieve attributes for each element
        
        for (var i = 0; i < journeyArray.length; ++i) {
            //Creating all the vars for clarity
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
            var twitterMessage = "Electric DeLorean Rides Again! "+distance+" miles on "+date;
            // get twitter button
            var tweetButton = document.getElementById("tweet-button"+panelNumber);
            // change text in the message
            var newLink = "http://localhost/Project/FinalProject/journeys.php?journey="+journeyID;
            // add message and journey specific URL
            tweetButton.src = tweetButton.src.replace(/&text=[^&]+/, "&text=" + encodeURIComponent(twitterMessage)+"&url="+encodeURIComponent(newLink));
            // facebook button updated with custom text
            var facebookButton = document.getElementById("facebook-button"+panelNumber);
            facebookButton.setAttribute('data-desc', 'It travelled '+distance+' miles on '+date);
            facebookButton.href='http://localhost/Project/FinalProject/journeys.php?journey='+journeyID;
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

        // if there is a journey to highlight, move there and expand it
        if (typeof journeyToHighlight!=='undefined') {
                // mimic click on correct panel
                // expands and highlights
                document.getElementById("journeyP"+journeyToHighlight).click();
                // zoom to correct panel
                $('html, body').animate({scrollTop: $("#journeyP"+journeyToHighlight).offset().top-100}, 500);
                // $("#journeyP"+journeyToHighlight).get(0).scrollIntoView();
                

        }
      } // end download URL function
    );//end download url
  }// end populateAccordion()
