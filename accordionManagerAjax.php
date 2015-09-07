<?php

// pull the total number of panels from the request
$totalPanels = $_GET["panels"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("journeys");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../connection.php");

// setup prepared statemnt
$stmt = $db->prepare("SELECT  journey_id as JourneyID,
    DATE_FORMAT(journey_date,'%D %M %Y') as JourneyDate,
        DATE_FORMAT(start_time,'%H:%i') as StartTime,
        DATE_FORMAT(end_time,'%H:%i') as EndTime,
        ROUND(average_speed_mph,2) as AverageSpeed,
        ROUND(distance_mi,2) as Distance,
        duration_mins as Duration,
        ROUND(petrol_saved_ltr,2) as PetrolSaved,
        ROUND(co2_saved_kg,2) as CO2Saved,
        start_lat_dd as StartLat,
        start_long_dd as StartLong,
        end_lat_dd as EndLat,
        end_long_dd as EndLong
      FROM journeysimport
      ORDER BY journey_date desc, start_time desc
      LIMIT ?");


$stmt->execute(array($totalPanels));

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

foreach ($result as $row) {

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
  $newnode->setAttribute("petrol", $row['PetrolSaved']);
  $newnode->setAttribute("co2", $row['CO2Saved']);
  $newnode->setAttribute("startLat", $row['StartLat']);
  $newnode->setAttribute("startLong", $row['StartLong']);
  $newnode->setAttribute("endLat", $row['EndLat']);
  $newnode->setAttribute("endLong", $row['EndLong']);

}

echo $dom->saveXML();

?>