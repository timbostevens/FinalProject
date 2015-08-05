<?php
// retrieve how many journeys have been created thus far
include("journeyCount.php");

// get file
$jsondata = file_get_contents("01-Original-Data.json");

// decodes the data into an array
$json = json_decode($jsondata, true);

// creates a new recursive array iterator
$iterator = new RecursiveArrayIterator($json);

// create start of insert datapoint query
$insertpointquery = "INSERT INTO datapointsimport VALUES ";

// create start of insert journeys query
$insertjourneyquery = "INSERT INTO journeysimport (journey_id, upload_timestamp) VALUES ";

// row and journey numbers definded outside function to allow for recusrsive incrementation
$rownumber = 1;
// gets journey count from journeyCount.php and increments it by 1 (the next journey number)
$journeynumber = $journeyCount+1;

// add first parameter (journey id) to journey query
$insertjourneyquery = $insertjourneyquery."(".$journeynumber;

// add second parameter (upload time) to journey query
$insertjourneyquery = $insertjourneyquery.", NOW())";

// calls function and passes in interator
iterator_apply($iterator, 'iteratorLooper', array($iterator));

////////////////////////////////////////////////////
///////////FIX SOME DATAPOINT ERRORS////////////////
///////////////////////////////////////////////////

// address first set of double brackets after first entry
$insertpointquery = str_replace(", ),)," , "),",$insertpointquery);
// remove extra commas at the end of line
$insertpointquery = str_replace(", )," , ")",$insertpointquery);
// insert commas back in between entries
$insertpointquery = str_replace(") (" , "), (",$insertpointquery);


// run the journey query
if (mysqli_query($connection, $insertjourneyquery)) {
    echo "Success";
} else {
    echo "Error:<br>" . mysqli_error($connection);
}

// run the datapoint query
if (mysqli_query($connection, $insertpointquery)) {
    echo "Success";
} else {
    echo "Error:<br>" . mysqli_error($connection);
}

// run the update summary stats function
updatesummarystats($journeynumber);



/*
FUNCTION
Updates summasry stats
Takes the journey number to update as an argument
*/
function updatesummarystats($journeynumber){


global $connection;

	// create query to retrieve summary stats
	$summaryselectquery="SELECT DATE_FORMAT (MIN(point_timestamp), '%H:%i:%s') as start_time,
								DATE_FORMAT (MAX(point_timestamp), '%H:%i:%s') as end_time,
        						MAX(total_dist_mi)/((MAX(time_elapsed_sec)/60)/60) as average_speed_mph,
        						MAX(total_dist_mi) as distance_mi,
								MAX(time_elapsed_sec)/60 as duration_mins
						FROM datapointsimport
						WHERE journey_id = ".$journeynumber;
    // run summaryselectquery
    $result = mysqli_query($connection,$summaryselectquery);
    // add results to an array
    $row = mysqli_fetch_array($result);


    // create query to update database with summary stats
    $summaryupdatequery = "UPDATE journeysimport SET";
    $summaryupdatequery = $summaryupdatequery." start_time='".$row['start_time'];
	$summaryupdatequery = $summaryupdatequery."', end_time='".$row['end_time'];		
	$summaryupdatequery = $summaryupdatequery."', average_speed_mph=".$row['average_speed_mph'];
	$summaryupdatequery = $summaryupdatequery.", distance_mi=".$row['distance_mi'];
	$summaryupdatequery = $summaryupdatequery.", duration_mins=".$row['duration_mins'];
	$summaryupdatequery = $summaryupdatequery." WHERE journey_id=".$journeynumber;

    //echo $summaryupdatequery;
	// run the query
	if (mysqli_query($connection, $summaryupdatequery)) {
    	echo "Success";
	} else {
    	echo "Error:<br>" . mysqli_error($connection);
	}

}




/*
FUNCTION
recursive function to loop through multi-dimensional array
*/
function iteratorLooper($iterator){

// create references to vars outside function
	global $insertpointquery;
	global $rownumber;
	global $journeynumber;
	global $insertjourneyquery;

// checks for valid entry
	while ($iterator->valid()){

	// if the entry has children
		if($iterator->hasChildren()){
		// recursive call to loop down a level
			iteratorLooper($iterator -> getChildren());
        // if it doesn't have children
		} else {
    	// checks for a new entry - uses timestamp as a new line id
			if($iterator -> key()=="timestamp"){
				// adds opening brackets, rownumber and journey number and start of string to date
				$insertpointquery = $insertpointquery." (".$rownumber.", ".$journeynumber.", STR_TO_DATE('";
				// add the value with the string to date format
				$insertpointquery = $insertpointquery.$iterator -> current().PHP_EOL."', '%d %M %Y %H:%i:%s'), ";
				// increments row number
				$rownumber++;
			} else { // if it's not a new row
    			// adds the value
				$insertpointquery = $insertpointquery.$iterator -> current().PHP_EOL.", ";
			}
		}

		// if this is the last entry in a row then close brackets
			if($iterator -> key()=="route"){
				$insertpointquery = $insertpointquery."),";
			}

			// go to next iteration
			$iterator->next();

	}// end while loop
}// end function

?>