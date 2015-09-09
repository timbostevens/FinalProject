<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("journeys");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../../connection.php");

// prepare statement
$allSummaryQuery = "SELECT DATE_FORMAT(journey_date, '%d/%m/%Y') as jour_date,
                        distance_mi,
                        duration_mins,
                        petrol_saved_ltr,
                        co2_saved_kg
                      FROM journeysimport
                      ORDER BY journey_date DESC, start_time DESC
                      LIMIT 20";

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
foreach ($db->query($allSummaryQuery) as $row) {
  // ADD TO XML DOCUMENT NODE
  // states the node name
  $node = $dom->createElement("journey");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("journey_date",$row['jour_date']);
  $newnode->setAttribute("distance",$row['distance_mi']);
  $newnode->setAttribute("duration", $row['duration_mins']);
  $newnode->setAttribute("petrol", $row['petrol_saved_ltr']);
  $newnode->setAttribute("co2", $row['co2_saved_kg']);
}

echo $dom->saveXML();

?>