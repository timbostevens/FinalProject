<?php
// Constants for data filepath, error filepath and logfile
define("DATA_FILEPATH", "source/");
define("DATALOAD_LOGFILE","logging/loadlog.txt");
define("LARGE_CAR_CO2",0.467064); // pulled from DEFRA Carbon Emissions
define("CAR_MPG",28); //Combined - pulled from http://www.aboutautomobile.com/Fuel/1981/Delorean/DMC+12
define("IMP_GALLON_TO_LITRE", 4.54609); // conversion factor for imp gallon to litre
define("FILE_LOAD_SUCCESS",1); // value to represent file loading success in database
define("FILE_LOAD_FAIL",2); // value to represent file loading failure in database
define("MAX_ALLOWABLE_SPEED",100); // value representing the speed at which to filter data

// // parameters for connection
$webAddressMain = "localhost";
$webAddressQubev = "localhost";
$username="root";
$password="";
$databaseMain="test";
$databaseQubev = "qubev";

// connection for the main dataabse holding the data
$dbMain = new PDO('mysql:host='.$webAddressMain.';dbname='.$databaseMain.';charset=utf8', $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// connection for the database holding the upload files
$dbQubev = new PDO('mysql:host='.$webAddressQubev.';dbname='.$databaseQubev.';charset=utf8', $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// create start of insert datapoint query
$insertPointQuery = "INSERT INTO datapointsimport VALUES ";
// create start of insert journeys query
$insertJourneyStmt = $dbMain->prepare("INSERT INTO journeysimport (journey_id, upload_timestamp, source_file) VALUES (?,NOW(),?)");
// row and journey numbers definded outside function to allow for recusrsive incrementation
$rowNumber = 1;
// flag for date errors
$dateErrorFlag = false;
// var to hold highest journey id
$highestJourneyId;
// var to hold file in file upload database
$filesInQubev;
// var to hold files in main journey database
$filesInMainDatabase;
// run the function
getPrepValues();



/*
Gets preliminary data from the database
*/
function getPrepValues(){

global $dbMain;
global $dbQubev;
global $highestJourneyId;
global $filesInQubev;
global $filesInMainDatabase;

try{
		// sql query to get current max journey id
		$query="SELECT MAX(journey_id) FROM journeysimport";
		
		// create full statement
		$stmt = $dbMain->query($query);
		
		// get result and apply to superglobal
		$highestJourneyId = $stmt->fetchColumn(0);

		// Select rows from the datapoints table
		$queryFilenamesMain = "SELECT source_file FROM journeysimport";

		// runs query and creates PDO data object
		$resultFilenamesMain = $dbMain->query($queryFilenamesMain);

		// converts PDO data object into array
		$filesInMainDatabase = $resultFilenamesMain->fetchAll(PDO::FETCH_ASSOC);

		// check for unloaded files
		$queryFilenamesQubev = "SELECT filename FROM files WHERE vis_status = 0 AND filename LIKE '%.json'";
		
		// runs query and creates PDO objecr
		$resultFilenamesQubev = $dbQubev->query($queryFilenamesQubev);
		
		// converts PDO data object into array
		$filesInQubev = $resultFilenamesQubev->fetchAll(PDO::FETCH_ASSOC);
	}catch (PDOException $ex){
		// create text string for logging
		$databaseFail = "\nPREP\n".date('d/m/Y H:i:s', time())." Database Query FAIL - Database Error: ".$ex->getMessage();
		// write to log file
		file_put_contents(DATALOAD_LOGFILE, $databaseFail, FILE_APPEND | LOCK_EX);
		//exit
		exit();
	}

	// send both arrays to the checking function
	checkForNew();
}



/*
Compares the two input arrays and sends onteh files marked as new to teh dataloader
*/
function checkForNew(){
	// setup variable scope
	global $filesInQubev;
	// empty array for filenames
	$allFiles = array();
	// restructures the array
	foreach ($filesInQubev as $row) {
		$allFiles[]=$row['filename'];
	}

	//Iterates over each value in the array passing them to the callback function.
	//If the callback function returns true, the current value from array is returned into the result array.
	$newFiles = array_filter(
		// passes in file from array into the callback function
		$allFiles, function ($file) {
		// setup varibale scope
		global $filesInMainDatabase;
		// file found flag
		$fileFound = false;
		// loops through file in main database
		foreach ($filesInMainDatabase as $row) {	
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
	}
}


/*
Manages upload of new files
Takes an array of new journey filesnames as an argument and uploads each one in turn
*/
function dataLoader($newFiles){

// cycle through each of the new files and send each one to the callback function
	array_filter($newFiles, function($newFile){

		global $highestJourneyId;
		global $dbMain;
		global $dbQubev;
		global $insertPointQuery;
		global $insertJourneyStmt;
		global $rowNumber;
		global $dateErrorFlag;

		// get file (re-append filepath)
		$jsonData = file_get_contents(DATA_FILEPATH.$newFile);

		// decodes the data into an array
		$json = json_decode($jsonData, true);

		// prepares statement for record database
		$resultStmt = $dbQubev->prepare("UPDATE files SET vis_status = ? WHERE filename = ?");

		// check if this is a valid array
		if(is_array($json)){
			
			// creates a new recursive array iterator
			$iterator = new RecursiveArrayIterator($json);

			// gets journey count increments it by 1 (to be used as the next journey number)
			$highestJourneyId += 1;

			// calls function and passes in interator
			iterator_apply($iterator, 'datapointIterator', array($iterator));
			
			//FIX SOME DATAPOINT ERRORS
			// address first set of double brackets after first entry
			$insertPointQuery = str_replace(", ),)," , "),",$insertPointQuery);
			// remove extra commas at the end of line
			$insertPointQuery = str_replace(", )," , ")",$insertPointQuery);
			// insert commas back in between entries
			$insertPointQuery = str_replace(") (" , "), (",$insertPointQuery);

			// setup load error flag
			$loadErrorFlag = false;

			// check for date error flag
			if($dateErrorFlag===false){

				try {
					// begin transaction
					$dbMain->beginTransaction();

					// create prepared statement to retrieve summary stats
					$summarySelectStmt=$dbMain->prepare("SELECT DATE_FORMAT (MIN(point_timestamp), '%Y-%m-%d') as journey_date,
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
					$summaryUpdateStmt = $dbMain->prepare("UPDATE journeysimport SET journey_date=?,
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


			

					// binds and executes insert journey statement
					$insertJourneyStmt->execute(array($highestJourneyId,$newFile));
					// executes insert point statment
					$dbMain->query($insertPointQuery);
					// bind parameters and execute summary select
					$summarySelectStmt->execute(array($highestJourneyId,$highestJourneyId,$highestJourneyId));
					// get row
					$row = $summarySelectStmt->fetch(PDO::FETCH_ASSOC);
					// create var for CO2 saving
					$co2Saving = $row['distance_mi']*LARGE_CAR_CO2;
					// create var for petrol saving
					$petrolSaving = ($row['distance_mi']/CAR_MPG)*IMP_GALLON_TO_LITRE;
					// bind and execute summary update
					$summaryUpdateStmt->execute(array($row['journey_date'],$row['start_time'],$row['end_time'],$row['average_speed_mph'],$row['distance_mi'],$row['duration_mins'],$petrolSaving,$co2Saving,$row['start_lat'],$row['start_long'],$row['end_lat'],$row['end_long'],$highestJourneyId));
					// commit transaction
					$dbMain->commit();
					// create text string for logging
					$journeySuccess = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Journey Load Success - File: ".$newFile." Journey Ref: ".$highestJourneyId;
					// write to log file
					file_put_contents(DATALOAD_LOGFILE, $journeySuccess, FILE_APPEND | LOCK_EX);
					// updates upload db
					manageUploadRecord(FILE_LOAD_SUCCESS, $newFile);

				} catch (PDOException $ex){
					// rollback transaction
					$dbMain->rollBack();
					// create text string for logging
					$databaseFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Database Load FAIL (& Rolled Back) - File: ".$newFile." Database Error: ".$ex->getMessage();
					// write to log file
					file_put_contents(DATALOAD_LOGFILE, $databaseFail, FILE_APPEND | LOCK_EX);
					// rollback journey count
					$highestJourneyId -= 1;
					// updates upload db
					manageUploadRecord(FILE_LOAD_FAIL, $newFile);

				} // end catch


			} else {// log error

				// create text string for logging
				$dateFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Date FAIL - File: ".$newFile;
				// write to log file
				file_put_contents(DATALOAD_LOGFILE, $dateFail, FILE_APPEND | LOCK_EX);
				// reverts the journey count
				$highestJourneyId -= 1;
				// updates upload db
				manageUploadRecord(FILE_LOAD_FAIL, $newFile);

			} // end if/else date check

			// reset queries
			$insertPointQuery = "INSERT INTO datapointsimport VALUES ";
			$rowNumber = 1;
			$dateErrorFlag = false;

		} else { //log error

			// create text string for logging
			$arrayFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Array Load FAIL - File: ".$newFile;
			// write to log file
			file_put_contents(DATALOAD_LOGFILE, $arrayFail, FILE_APPEND | LOCK_EX);
			// updates upload db
			manageUploadRecord(FILE_LOAD_FAIL, $newFile);

		}// end if/else array check
	}); // end array_filter
} // end function



/*
Writes status to upload db and catches errors
*/
function manageUploadRecord ($status, $filename){
/*
try catch only kicks in if the db fails between the initial file check and the final log write
thus is very unlikely
*/
try{
	// setup variable scope
	global $dbQubev;
	// prepares statement for record database
	$resultStmt = $dbQubev->prepare("UPDATE files SET vis_status = ? WHERE filename = ?");
	// binds and executes query
	$resultStmt->execute(array($status,$filename));
} catch (PDOException $ex){
	// create text string for logging
	$uploadRecordFail = "\nNEW JOURNEY\n".date('d/m/Y H:i:s', time())." Upload DB Record Fail (databases out of sync) - File: ".$newFile;
	// write to log file
	file_put_contents(DATALOAD_LOGFILE, $uploadRecordFail, FILE_APPEND | LOCK_EX);
}
}




/*
FUNCTION
Creates main body of data point insert query
recursive function to loop through multi-dimensional array
*/
function datapointIterator($iterator){

// create references to vars outside function
	global $insertPointQuery;
	global $rowNumber;
	global $highestJourneyId;
	global $dateErrorFlag;

// checks for valid entry
	while (($iterator->valid()) and ($dateErrorFlag!==true)){

	// if the entry has children
		if($iterator->hasChildren()){
		// recursive call to loop down a level
			datapointIterator($iterator -> getChildren());
        // if it doesn't have children
		} else {
    	// checks for a new entry - uses timestamp as a new line id
			if($iterator -> key()=="timestamp"){
				// date validation
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
				$insertPointQuery = $insertPointQuery." (".$rowNumber.", ".$highestJourneyId.", STR_TO_DATE('";
				// add the value with the string to date format
				$insertPointQuery = $insertPointQuery.$iterator -> current().PHP_EOL."', '%d %M %Y %H:%i:%s'), ";
				// increments row number
				$rowNumber++;
			// checks for speeds over 100mph and removes them
			} elseif(($iterator -> key()=="velocity_mph") && ($iterator -> current().PHP_EOL>MAX_ALLOWABLE_SPEED)){
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