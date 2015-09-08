<?php
// Constants for data filepath, error filepath and logfile
define("DATA_FILEPATH", "source/");
define("DATA_ERROR_FILEPATH", "source/errors/");
define("DATA_SUCCESS_FILEPATH", "source/loaded/");
define("DATALOAD_LOGFILE","logging/loadlog.txt");
define("LARGE_CAR_CO2",0.467064); // pulled from DEFRA Carbon Emissions
define("CAR_MPG",28); //Combined - pulled from http://www.aboutautomobile.com/Fuel/1981/Delorean/DMC+12
define("IMP_GALLON_TO_LITRE", 4.54609); // conversion factor for imp gallon to litre

//include("db.php");

// load journey count - instead of db as we'll need the count
// later for the next bit and I don't want to duplicate connections
include("journeyCount.php");

// create start of insert datapoint query
// not converted to prepared statement to make it easier to catch errors
// (if it was a prepared statement and x points had already loaded before an error was found, it would be difficult ro step it back)
$insertPointQuery = "INSERT INTO datapointsimport VALUES ";

// create start of insert journeys query
$insertJourneyStmt = $db->prepare("INSERT INTO journeysimport (journey_id, upload_timestamp, source_file) VALUES (?,NOW(),?)");

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
// $result = mysqli_query($db, $queryDatapoints);

$result = $db->query($queryDatapoints);

$resultArray = $result->fetchAll();

// gets all files in folder with pattern
$allFiles = glob(DATA_FILEPATH."*.json");

// remove filepath to leave clean filename
foreach ($allFiles as &$value) {
	$value = str_replace(DATA_FILEPATH, "", $value);
}
// destroy foreach value
unset($value);

//Iterates over each value in the array passing them to the callback function.
//If the callback function returns true, the current value from array is returned into the result array.
$newFiles = array_filter(
	// passes in file from array into the callback function
	$allFiles, function ($file) {

		// file found flag
		$fileFound = false;
		global $resultArray;

		foreach ($resultArray as $row) {	

			if ($row['source_file']===$file){
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
		global $db;
		global $insertPointQuery;
		global $insertJourneyStmt;
		global $rowNumber;
		global $dateErrorFlag;

		// get file (re-append filepath)
		$jsonData = file_get_contents(DATA_FILEPATH.$newFile);

		// decodes the data into an array
		$json = json_decode($jsonData, true);

		// check if this is a valid array
		if(is_array($json)){
			
			// creates a new recursive array iterator
			$iterator = new RecursiveArrayIterator($json);

			// gets journey count from journeyCount.php and increments it by 1 (the next journey number)
			$journeyCount = $journeyCount+1;

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

			// bind and execute query - apply result (true/flase) to var
			// $insertResult = $insertJourneyStmt->execute(array($journeyCount,$newFile));

			// bind the values (int, strng) into the prepared statement
			// mysqli_stmt_bind_param($insertJourneyStmt,'is',$journeyCount,$newFile);



			$loadErrorFlag = false;

			// check for date error flag
			if($dateErrorFlag===false){

				try {
						// begin transaction
						$db->beginTransaction();

						
				// create prepared statement to retrieve summary stats
				$summarySelectStmt=$db->prepare("SELECT DATE_FORMAT (MIN(point_timestamp), '%Y-%m-%d') as journey_date,
									DATE_FORMAT (MIN(point_timestamp), '%H:%i:%s') as start_time,
									DATE_FORMAT (MAX(point_timestamp), '%H:%i:%s') as end_time,
									MAX(total_dist_mi)/((MAX(time_elapsed_sec)/60)/60) as average_speed_mph,
									MAX(total_dist_mi) as distance_mi,
									MAX(time_elapsed_sec)/60 as duration_mins,
								    start_coords.start_lat,
								    start_coords.start_long,
									end_coords.end_lat,
								    end_coords.end_long
									FROM datapointsimport,
									(SELECT lat_dd as start_lat, long_dd as start_long from datapointsimport WHERE point_id = 1 AND journey_id = ?) as start_coords,
								    (SELECT lat_dd as end_lat, long_dd as end_long from datapointsimport WHERE journey_id = ? ORDER BY point_id DESC LIMIT 1) as end_coords
									WHERE journey_id = ?");


				// create prepared statement to update database with summary stats
				$summaryUpdateStmt = $db->prepare("UPDATE journeysimport SET journey_date=?,
																start_time=?,
																end_time=?,
																average_speed_mph=?,
																distance_mi=?,
																duration_mins=?,
																petrol_saved_ltr=?,
																co2_saved_kg=?,
																start_lat_dd=?,
																start_long_dd=?,
																end_lat_dd=?,
																end_long_dd=?
															WHERE journey_id=?");


				


						$insertJourneyStmt->execute(array($journeyCount,$newFile));

						$db->query($insertPointQuery);

						// bind parameters and execute
						$summarySelectStmt->execute(array($journeyCount,$journeyCount,$journeyCount));

						$row = $summarySelectStmt->fetch(PDO::FETCH_ASSOC);

						// create var for CO2 saving
						$co2Saving = $row['distance_mi']*LARGE_CAR_CO2;

						// create var for petrol saving
						$petrolSaving = ($row['distance_mi']/CAR_MPG)*IMP_GALLON_TO_LITRE;

						$summaryUpdateStmt->execute(array($row['journey_date'],$row['start_time'],$row['end_time'],$row['average_speed_mph'],$row['distance_mi'],$row['duration_mins'],$petrolSaving,$co2Saving,$row['start_lat'],$row['start_long'],$row['end_lat'],$row['end_long'],$journeyCount));

						// commit transaction
						$db->commit();

						// create text string for logging
						$journeySuccess = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Journey Load Success - File: ".$newFile." Journey Ref: ".$journeyCount;
						// write to log file
						file_put_contents(DATALOAD_LOGFILE, $journeySuccess, FILE_APPEND | LOCK_EX);



					} catch (PDOException $ex){
						// rollback transaction
						$db->rollBack();
						// create text string for logging
						$pdoFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Database Load FAIL (& Rolled Back) - File: ".$newFile." Database Error: ".$ex->getMessage();
						// write to log file
						file_put_contents(DATALOAD_LOGFILE, $pdoFail, FILE_APPEND | LOCK_EX);
						// rollback journey count
						$journeyCount = $journeyCount-1;
					} // end catch


			} else {// move file to errors folder & log error
			
				// create string containing new file location
				// $newFileLocation = DATA_ERROR_FILEPATH.$newFile;

				// move file to error folder (re-append path)
				// rename(DATA_FILEPATH.$newFile, $newFileLocation);

				// create text string for logging
				$dateFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Date FAIL - File: ".$newFile;
				// write to log file
				file_put_contents(DATALOAD_LOGFILE, $dateFail, FILE_APPEND | LOCK_EX);

				// reverts the journey count
				$journeyCount = $journeyCount-1;


			} // end if/else date check

			// reset queries
			$insertPointQuery = "INSERT INTO datapointsimport VALUES ";
			$rowNumber = 1;
			$dateErrorFlag = false;

		} else { // move file to errors folder & log error
			// create string containing new file location
			$newFileLocation = DATA_ERROR_FILEPATH.$newFile;

			// move file to error folder (re-append path)
			// rename(DATA_FILEPATH.$newFile, $newFileLocation);

			// create text string for logging
			$arrayFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Array Load FAIL - File: ".$newFile;
			// write to log file
			file_put_contents(DATALOAD_LOGFILE, $arrayFail, FILE_APPEND | LOCK_EX);

		}// end if/else array check

	}); // end array_filter


} // end function

/*
FUNCTION
Updates summary stats
Takes the journey number to update as an argument
*/
// function updateSummaryStats($journeyCount){


// 	global $db;

// 	// create prepared statement to retrieve summary stats
// 	$summarySelectStmt=$db->prepare("SELECT DATE_FORMAT (MIN(point_timestamp), '%Y-%m-%d') as journey_date,
// 						DATE_FORMAT (MIN(point_timestamp), '%H:%i:%s') as start_time,
// 						DATE_FORMAT (MAX(point_timestamp), '%H:%i:%s') as end_time,
// 						MAX(total_dist_mi)/((MAX(time_elapsed_sec)/60)/60) as average_speed_mph,
// 						MAX(total_dist_mi) as distance_mi,
// 						MAX(time_elapsed_sec)/60 as duration_mins,
// 					    start_coords.start_lat,
// 					    start_coords.start_long,
// 						end_coords.end_lat,
// 					    end_coords.end_long
// 						FROM datapointsimport,
// 						(SELECT lat_dd as start_lat, long_dd as start_long from datapointsimport WHERE point_id = 1 AND journey_id = ?) as start_coords,
// 					    (SELECT lat_dd as end_lat, long_dd as end_long from datapointsimport WHERE journey_id = ? ORDER BY point_id DESC LIMIT 1) as end_coords
// 						WHERE journey_id = ?");

// // bind parameters and execute
// $summarySelectStmt->execute(array($journeyCount,$journeyCount,$journeyCount));
// // get first row of results (there only is one row)
// $row = $summarySelectStmt->fetch(PDO::FETCH_ASSOC);


// 	// bind parameters (integer)
// 	// mysqli_stmt_bind_param($summarySelectStmt, 'iii',$journeyCount,$journeyCount,$journeyCount);
// 	// execute prepared statement
// 	// mysqli_stmt_execute($summarySelectStmt);

//     // run summarySelectStmt
// 	// $result = mysqli_stmt_get_result($summarySelectStmt);
//     // add results to an array
// 	// $row = mysqli_fetch_array($result);

// 	// create prepared statement to update database with summary stats
// 	$summaryUpdateStmt = $db->prepare("UPDATE journeysimport SET journey_date=?,
// 													start_time=?,
// 													end_time=?,
// 													average_speed_mph=?,
// 													distance_mi=?,
// 													duration_mins=?,
// 													petrol_saved_ltr=?,
// 													co2_saved_kg=?,
// 													start_lat_dd=?,
// 													start_long_dd=?,
// 													end_lat_dd=?,
// 													end_long_dd=?
// 												WHERE journey_id=?");

// 	// create var for CO2 saving
// 	$co2Saving = $row['distance_mi']*LARGE_CAR_CO2;

// 	// create var for petrol saving
// 	$petrolSaving = ($row['distance_mi']/CAR_MPG)*IMP_GALLON_TO_LITRE;

//     // bind and execute = applys reuslt (true/false) to var
// 	$summaryResult = $summaryUpdateStmt->execute(array($row['journey_date'],$row['start_time'],$row['end_time'],$row['average_speed_mph'],$row['distance_mi'],$row['duration_mins'],$petrolSaving,$co2Saving,$row['start_lat'],$row['start_long'],$row['end_lat'],$row['end_long'],$journeyCount));

// 	// if sucessfully run
// 	if ($summaryResult) {
// 		// create text string
// 		$summarySuccess = "\n".date('d/m/Y H:i:s', time())." Summary Generation Success - Journey Ref: ".$journeyCount;
// 		// write to file
// 		file_put_contents(DATALOAD_LOGFILE, $summarySuccess, FILE_APPEND | LOCK_EX);
// 	} else {
// 		// create text string
// 		$summaryFail = "\n".date('d/m/Y H:i:s', time())." Summary Generation FAIL - Journey Ref: ".$journeyCount;
// 		// write to file
// 		file_put_contents(DATALOAD_LOGFILE, $summaryFail, FILE_APPEND | LOCK_EX);
// 	}

// }


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
				// creates a timestamp for now
				$now = new DateTime();
				// check if new date matches the retieved date
				// this is needed as php turns 31 Feb into 3 March!!!!
				// also checks for future dates			
				if(($validityCheckString!==date_format($newDate, 'j M Y H:i:s'))||($newDate >= $now)){
					// sets error flag to true
					$dateErrorFlag = true;
					// breaks the loop
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
			// checks for speeds over 100mph and removes them
			} elseif(($iterator -> key()=="velocity_mph") && ($iterator -> current().PHP_EOL>100)){
				// appends null to the spped attribute
				$insertPointQuery= $insertPointQuery."Null".", ";

			// all other attributes
			} else {


			//////////////////////////////////////////////////////////////////////////////////
			////////////LAT AND LONG ARE CURRENTLY BACKWARDS IN THE SOURCE FILES//////////////
			//////////////////////MY DATABASE FIELD NAMES CORRECT THIS////////////////////////

    		// adds the value
			$insertPointQuery=$insertPointQuery.$iterator -> current().PHP_EOL.", ";
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