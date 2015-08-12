<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("journeys");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("connection.php");

// Set the active MySQL database

// $db_selected = mysql_select_db($database, $connection);
// if (!$db_selected) {
//   die ('Can\'t use db : ' . mysql_error());
// }


// I THINK ALL OF THIS IS FIXED //

////////////////////////////////////////////////////
//////DATES IN DB ARE CURRENTLY FOTRMATTED INCORRECTLY////
///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
// Can maybe simplify the query if I populate first timestamp in jour on load
////////////////////////////////////////////////////////////////////////////
// Select rows from the datapoints table
//updates results so that journey 1 becomes the highest journey number from the database
// $queryDatapoints = "SELECT tempdata.journey_id as JourneyID, DATE_FORMAT(tempdata.point_timestamp,'%D %M %Y') as FirstTimestamp, DATE_FORMAT(tempjour.start_time,'%H:%i') as StartTime, DATE_FORMAT(tempjour.end_time,'%H:%i') as EndTime, tempjour.average_speed_mph as AverageSpeed, tempjour.distance_mi as Distance, tempjour.duration_mins as Duration, tempjour.energy_saved as EnergySaved, tempjour.co2_saved as CO2Saved
//     FROM (SELECT * FROM datap WHERE point_id=1) as tempdata
//     JOIN (SELECT journey_id, start_time, end_time, average_speed_mph, distance_mi, duration_mins, energy_saved, co2_saved
//       FROM jour
//       ORDER BY journey_id desc
//       LIMIT 5) as tempjour ON tempjour.journey_id=tempdata.journey_id
//       ORDER BY tempdata.journey_id desc";

$queryDatapoints = "SELECT  journey_id as JourneyID,
    DATE_FORMAT(journey_date,'%D %M %Y') as JourneyDate,
        DATE_FORMAT(start_time,'%H:%i') as StartTime,
        DATE_FORMAT(end_time,'%H:%i') as EndTime,
        ROUND(average_speed_mph,2) as AverageSpeed,
        ROUND(distance_mi,2) as Distance,
        duration_mins as Duration,
        energy_saved as EnergySaved,
        ROUND(co2_saved_kg,2) as CO2Saved
      FROM journeysimport
      ORDER BY journey_date desc, start_time desc
      LIMIT 5";


$result = mysqli_query($connection, $queryDatapoints);

// if there is no result, throw an error
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE

  // states the node name
  $node = $dom->createElement("journeyrecord");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("journeyID",$row['JourneyID']);
  $newnode->setAttribute("date", $row['JourneyDate']);
  $newnode->setAttribute("start", $row['StartTime']);
  $newnode->setAttribute("end", $row['EndTime']);
  $newnode->setAttribute("speed", $row['AverageSpeed']);
  $newnode->setAttribute("distance", $row['Distance']);
  $newnode->setAttribute("duration", $row['Duration']);
  $newnode->setAttribute("energy", $row['EnergySaved']);
  $newnode->setAttribute("co2", $row['CO2Saved']);

}

echo $dom->saveXML();

?>