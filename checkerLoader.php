<?php

//include("connection.php");

// load journey count - instead of connection as we'll need the count
// later for the next bit and I don't want to duplicate connections
include("journeyCount.php");

// create start of insert datapoint query
$insertPointQuery = "INSERT INTO datapointsimport VALUES ";

// create start of insert journeys query
$insertJourneyQuery = "INSERT INTO journeysimport (journey_id, upload_timestamp, source_file) VALUES ";

// row and journey numbers definded outside function to allow for recusrsive incrementation
$rowNumber = 1;


////////////////////////////////////////
// This section checks for new files////
///////////////////////////////////////

// Select rows from the datapoints table
$queryDatapoints = "SELECT source_file FROM journeysimport";
// runs query and passes results to var
$result = mysqli_query($connection, $queryDatapoints);

//////////////////////////////
//Need some sql validation here
//////////////////////////////

// gets all files in folder with pattern
$allFiles = glob("source/*.json");
//Iterates over each value in the array passing them to the callback function.
//If the callback function returns true, the current value from array is returned into the result array.
$newFiles = array_filter(
			// passes in file from array into the callback function
	$allFiles, function ($file) {
				// file found flag
		$fileFound = false;
		global $result;

		// ensure row iteration starts at 0
		mysqli_data_seek($result, 0);

		// cycle though query results
		while ($row = @mysqli_fetch_assoc($result)){

			if ($row['source_file']===$file){
						//echo "Match found for ".$file."<br/>";
				$fileFound = true;
			}
				}// end while

				// returns true if file is not found
				return (!$fileFound);
			}
			);
// if there are new files pass them to the dataLoader function
if ($newFiles){

	dataloader($newFiles);
} else {
	echo "no new files";
}


/*
FUNCTION
Manages upload of new files
Takes an array of new journey filesnames as an argument and uploads each one in turn
*/
function dataLoader($newFiles){

// retrieve how many journeys have been created thus far
	//include("journeyCount.php");

// cycle through each of the new files and send each one to the callback function
array_filter($newFiles, function($newFile){

		global $journeyCount;
		global $connection;
		global $insertPointQuery
	;
		global $insertJourneyQuery;
		global $rowNumber;

// get file
		$jsonData = file_get_contents($newFile);

// decodes the data into an array
		$json = json_decode($jsonData, true);

// creates a new recursive array iterator
		$iterator = new RecursiveArrayIterator($json);

// gets journey count from journeyCount.php and increments it by 1 (the next journey number)
		$journeyCount = $journeyCount+1;

// add first parameter (journey id) to journey query
		$insertJourneyQuery = $insertJourneyQuery."(".$journeyCount;

// add second parameter (upload time) to journey query
		$insertJourneyQuery = $insertJourneyQuery.", NOW()";

// add third parameter (source filename) to journey query
		$insertJourneyQuery = $insertJourneyQuery.", '".$newFile."')";

// calls function and passes in interator
iterator_apply($iterator, 'iteratorLooper', array($iterator));

////////////////////////////////////////////////////
///////////FIX SOME DATAPOINT ERRORS////////////////
///////////////////////////////////////////////////

// address first set of double brackets after first entry
$insertPointQuery = str_replace(", ),)," , "),",$insertPointQuery
);
// remove extra commas at the end of line
$insertPointQuery = str_replace(", )," , ")",$insertPointQuery
);
// insert commas back in between entries
$insertPointQuery = str_replace(") (" , "), (",$insertPointQuery
 );


// run the journey query
if (mysqli_query($connection, $insertJourneyQuery)) {
	echo "Success";
} else {
	echo "<br/>".$insertJourneyQuery."<br/>";
	echo "Journey Error:<br>" . mysqli_error($connection);
}

// // run the datapoint query
if (mysqli_query($connection, $insertPointQuery
)) {
	echo "Success";
} else {
	echo "<br/>".$insertPointQuery
."<br/>";
	echo "Datapoint Error:<br>" . mysqli_error($connection);
}

// run the update summary stats function
updateSummaryStats($journeyCount);

// reset queries
$insertPointQuery = "INSERT INTO datapointsimport VALUES ";
$insertJourneyQuery = "INSERT INTO journeysimport (journey_id, upload_timestamp, source_file) VALUES ";
$rowNumber = 1;


}); // end array_filter


} // end function

/*
FUNCTION
Updates summary stats
Takes the journey number to update as an argument
*/
function updateSummaryStats($journeyCount){


	global $connection;

	// create query to retrieve summary stats
	$summaryselectquery="SELECT DATE_FORMAT (MIN(point_timestamp), '%Y-%m-%d') as journey_date,
	DATE_FORMAT (MIN(point_timestamp), '%H:%i:%s') as start_time,
	DATE_FORMAT (MAX(point_timestamp), '%H:%i:%s') as end_time,
	MAX(total_dist_mi)/((MAX(time_elapsed_sec)/60)/60) as average_speed_mph,
	MAX(total_dist_mi) as distance_mi,
	MAX(time_elapsed_sec)/60 as duration_mins
	FROM datapointsimport
	WHERE journey_id = ".$journeyCount;
    // run summaryselectquery
	$result = mysqli_query($connection,$summaryselectquery);
    // add results to an array
	$row = mysqli_fetch_array($result);


    // create query to update database with summary stats
	$summaryupdatequery = "UPDATE journeysimport SET";
	$summaryupdatequery = $summaryupdatequery." journey_date='".$row['journey_date'];
	$summaryupdatequery = $summaryupdatequery."', start_time='".$row['start_time'];
	$summaryupdatequery = $summaryupdatequery."', end_time='".$row['end_time'];		
	$summaryupdatequery = $summaryupdatequery."', average_speed_mph=".$row['average_speed_mph'];
	$summaryupdatequery = $summaryupdatequery.", distance_mi=".$row['distance_mi'];
	$summaryupdatequery = $summaryupdatequery.", duration_mins=".$row['duration_mins'];
	$summaryupdatequery = $summaryupdatequery." WHERE journey_id=".$journeyCount;

    // echo $summaryupdatequery;
	// run the query
	if (mysqli_query($connection, $summaryupdatequery)) {
		echo "Success";
	} else {
		echo "<br/>".$summaryupdatequery."<br/>";
		echo "Summary Stats Error:<br>" . mysqli_error($connection);
	}

}




/*
FUNCTION
Creates main body of data point insert query
recursive function to loop through multi-dimensional array
*/
function iteratorLooper($iterator){

// create references to vars outside function
	global $insertPointQuery
;
	global $rowNumber;
	global $journeyCount;
	global $insertJourneyQuery;

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
				// adds opening brackets, rowNumber and journey number and start of string to date
				$insertPointQuery
			 = $insertPointQuery
				." (".$rowNumber.", ".$journeyCount.", STR_TO_DATE('";
				// add the value with the string to date format
				$insertPointQuery
			 = $insertPointQuery
				.$iterator -> current().PHP_EOL."', '%d %M %Y %H:%i:%s'), ";
				// increments row number
$rowNumber++;
			} else { // if it's not a new row
    			// adds the value


			//////////////////////////////////////////////////////////////////////////////////
			////////////LAT AND LONG ARE CURRENTLY BACKWARDS IN THE SOURCE FILES//////////////
			//////////////////////MY DATABASE FIELD NAMES CORRECT THIS////////////////////////


			$insertPointQuery
		 = $insertPointQuery
			.$iterator -> current().PHP_EOL.", ";
		}
	}

		// if this is the last entry in a row then close brackets
	if($iterator -> key()=="route"){
		$insertPointQuery
	 = $insertPointQuery
		."),";
}

			// go to next iteration
$iterator->next();

	}// end while loop

}// end function


?>