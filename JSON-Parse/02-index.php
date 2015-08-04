<?php
	// get file
	$jsondata = file_get_contents("02 Simple Data.json");
	// decode into array
	$json = json_decode($jsondata, true);
	// cycly though array to get data
	foreach ($json as $key) {
		// print to screen
		echo "Timestamp: ".$key['timestamp']." Battery: ".$key['battery']. " Distance: ".$key['distance_from_prev_miles']." Velocity: ".$key['velocity_mph']."<br/>";
	}
?>