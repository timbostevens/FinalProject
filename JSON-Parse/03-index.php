<?php
	// get file
	$jsondata = file_get_contents("03-Full-Data.json");
	// decode into array
	$json = json_decode($jsondata, true);
	// cycly though array to get data
	
	$serialized = serialize($json);


	var_dump($serialized);
	//foreach ($json as $key) {
		// print to screen
	//	echo $key['timestamp']." ".$key['coodinates']['x']. " ".$key['distance_from_prev_miles']." ".$key['velocity_mph']."<br/>";
	//}
?>