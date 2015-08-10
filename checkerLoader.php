<?php
// Constants for data filepath, error filepath and logfile
define("DATA_FILEPATH", "source/");
define("DATA_ERROR_FILEPATH", "source/errors/");
define("DATALOAD_LOGFILE","logging/loadlog.txt");

//include("connection.php");

// load journey count - instead of connection as we'll need the count
// later for the next bit and I don't want to duplicate connections
include("journeyCount.php");

// create start of insert datapoint query
$insertPointQuery = "INSERT INTO datapointsimport VALUES ";

// create start of insert journeys query
$insertJourneyStmt = mysqli_prepare($connection,"INSERT INTO journeysimport (journey_id, upload_timestamp, source_file) VALUES (?,NOW(),?)");

// row and journey numbers definded outside function to allow for recusrsive incrementation
$rowNumber = 1;

// flag for date errors
$dateErrorFlag = false;

////////////////////////////////////////
// This section checks for new files////
///////////////////////////////////////

// Select rows from the datapoints table
$queryDatapoints = "SELECT source_file FROM journeysimport";
// runs query and passes results to var
$result = mysqli_query($connection, $queryDatapoints);

// gets all files in folder with pattern
$allFiles = glob(DATA_FILEPATH."*.json");
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

////////////////////////
////REMOVE FOR PRODUCTION
///////////////////

	echo "no new files<br/>";
}

	echo "done";

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
		global $insertPointQuery;
		global $insertJourneyStmt;
		global $rowNumber;
		global $dateErrorFlag;

// get file
		$jsonData = file_get_contents($newFile);

// decodes the data into an array
		$json = json_decode($jsonData, true);

// check if this is a valid array
		if(is_array($json)){
			
			// creates a new recursive array iterator
			$iterator = new RecursiveArrayIterator($json);

			// gets journey count from journeyCount.php and increments it by 1 (the next journey number)
			$journeyCount = $journeyCount+1;

			// bind the values (int, strng) into the prepared statement
			mysqli_stmt_bind_param($insertJourneyStmt,'is',$journeyCount,$newFile);

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

			// check for date error flag
			if($dateErrorFlag===false){


				// run the journey query
				if (mysqli_execute($insertJourneyStmt)) {
					// create text string
					$journeySuccess = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Journey Load Success - File: ".$newFile." Journey Ref: ".$journeyCount;
					// write to file
					file_put_contents(DATALOAD_LOGFILE, $journeySuccess, FILE_APPEND | LOCK_EX);
				} else {
					// create text string
					$journeyFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Journey Load FAIL - File: ".$newFile." Journey Ref: ".$journeyCount."mySQL Error: ".mysqli_error($connection);
					// write to file
					file_put_contents(DATALOAD_LOGFILE, $journeyFail, FILE_APPEND | LOCK_EX);
				}

				// // run the datapoint query
				if (mysqli_query($connection, $insertPointQuery)) {
					// create text string
					$datapointSuccess = "\n".date('d/m/Y H:i:s', time())." Datapoint Load Success - File: ".$newFile." Journey Ref: ".$journeyCount;
					// write to file
					file_put_contents(DATALOAD_LOGFILE, $datapointSuccess, FILE_APPEND | LOCK_EX);
				} else {
					// create text string
					$datapointFail = "\n".date('d/m/Y H:i:s', time())." Datapoint Load FAIL - File: ".$newFile." Journey Ref: ".$journeyCount."mySQL Error: ".mysqli_error($connection);
					// write to file
					file_put_contents(DATALOAD_LOGFILE, $datapointFail, FILE_APPEND | LOCK_EX);
				}
			
				// run the update summary stats function
				updateSummaryStats($journeyCount);

			} else {// move file to errors folder & log error
			
				// create string containing new file location
				$newFileLocation = str_replace(DATA_FILEPATH,DATA_ERROR_FILEPATH,$newFile);
				// move file to error folder
				rename($newFile, $newFileLocation);

				// create text string
				$dateFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Date FAIL - File: ".$newFile;
				// write to file
				file_put_contents(DATALOAD_LOGFILE, $dateFail, FILE_APPEND | LOCK_EX);


			}
			// reset queries
			$insertPointQuery = "INSERT INTO datapointsimport VALUES ";
			$rowNumber = 1;
			$dateErrorFlag = false;

		}else { // move file to errors folder & log error
			// create string containing new file location
			$newFileLocation = str_replace(DATA_FILEPATH,DATA_ERROR_FILEPATH,$newFile);
			// move file to error folder
			rename($newFile, $newFileLocation);

			// create text string
			$arrayFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Array Load FAIL - File: ".$newFile;
			// write to file
			file_put_contents(DATALOAD_LOGFILE, $arrayFail, FILE_APPEND | LOCK_EX);

		}// end if/else array check

	}); // end array_filter


} // end function

/*
FUNCTION
Updates summary stats
Takes the journey number to update as an argument
*/
function updateSummaryStats($journeyCount){


	global $connection;

	// create prepared statement to retrieve summary stats
	$summarySelectStmt=mysqli_prepare($connection, "SELECT DATE_FORMAT (MIN(point_timestamp), '%Y-%m-%d') as journey_date,
	DATE_FORMAT (MIN(point_timestamp), '%H:%i:%s') as start_time,
	DATE_FORMAT (MAX(point_timestamp), '%H:%i:%s') as end_time,
	MAX(total_dist_mi)/((MAX(time_elapsed_sec)/60)/60) as average_speed_mph,
	MAX(total_dist_mi) as distance_mi,
	MAX(time_elapsed_sec)/60 as duration_mins
	FROM datapointsimport
	WHERE journey_id = ?");

	// bind parameters (integer)
	mysqli_stmt_bind_param($summarySelectStmt, 'i',$journeyCount);
	// execute prepared statement
	mysqli_stmt_execute($summarySelectStmt);

    // run summarySelectStmt
	$result = mysqli_stmt_get_result($summarySelectStmt);
    // add results to an array
	$row = mysqli_fetch_array($result);



	/////////////////////////////////////////////
	/////CHNAGE TO PREPARED STATEMENT///////
	///////////////////////////////////////////

    // create query to update database with summary stats
	$summaryupdatequery = "UPDATE journeysimport SET";
	$summaryupdatequery = $summaryupdatequery." journey_date='".$row['journey_date'];
	$summaryupdatequery = $summaryupdatequery."', start_time='".$row['start_time'];
	$summaryupdatequery = $summaryupdatequery."', end_time='".$row['end_time'];		
	$summaryupdatequery = $summaryupdatequery."', average_speed_mph=".$row['average_speed_mph'];
	$summaryupdatequery = $summaryupdatequery.", distance_mi=".$row['distance_mi'];
	$summaryupdatequery = $summaryupdatequery.", duration_mins=".$row['duration_mins'];
	$summaryupdatequery = $summaryupdatequery." WHERE journey_id=".$journeyCount;

    //echo $summaryupdatequery;
	// run the query
	if (mysqli_query($connection, $summaryupdatequery)) {
		// create text string
		$summarySuccess = "\n".date('d/m/Y H:i:s', time())." Summary Generation Success - Journey Ref: ".$journeyCount;
		// write to file
		file_put_contents(DATALOAD_LOGFILE, $summarySuccess, FILE_APPEND | LOCK_EX);
	} else {
		// create text string
		$summaryFail = "\n".date('d/m/Y H:i:s', time())." Summary Generation FAIL - Journey Ref: ".$journeyCount."mySQL Error: ".mysqli_error($connection);
		// write to file
		file_put_contents(DATALOAD_LOGFILE, $summaryFail, FILE_APPEND | LOCK_EX);
	}

}




/*
FUNCTION
Creates main body of data point insert query
recursive function to loop through multi-dimensional array
*/
function iteratorLooper($iterator){

// create references to vars outside function
	global $insertPointQuery;
	global $rowNumber;
	global $journeyCount;
	global $dateErrorFlag;

// checks for valid entry
	while (($iterator->valid()) and ($dateErrorFlag!==true)){

	// if the entry has children
		if($iterator->hasChildren()){
		// recursive call to loop down a level
			iteratorLooper($iterator -> getChildren());
        // if it doesn't have children
		} else {
    	// checks for a new entry - uses timestamp as a new line id
			if($iterator -> key()=="timestamp"){
				
				///////////////////////
				////Date Validation////
				//////////////////////

				// get string from iterator
				$validityCheckString = $iterator -> current().PHP_EOL;
				// trim carrigae return from end
				$validityCheckString = str_replace("\n", "",$validityCheckString);
				// create new date/time from the retrieved value
				$newDate = date_create_from_format('j M Y H:i:s',$validityCheckString);
				// check if new date matches the retieved date
				// this is needed as php turns 31 Feb into 3 March!!!!				
				if($validityCheckString!==date_format($newDate, 'j M Y H:i:s')){
					$dateErrorFlag = true;
					break;
				};

				// adds opening brackets, rowNumber and journey number and start of string to date
				$insertPointQuery
				= $insertPointQuery
				." (".$rowNumber.", ".$journeyCount.", STR_TO_DATE('";
				// add the value with the string to date format
					$insertPointQuery = $insertPointQuery.$iterator -> current().PHP_EOL."', '%d %M %Y %H:%i:%s'), ";
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