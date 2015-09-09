<?php

// pull journey number from Get request
$journeyNumber = $_GET["journey"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../../connection.php");

// escape the string for security
// $journeyNumber = mysqli_real_escape_string($connection, $journeyNumber);

// prepare statement
$stmt = $db->prepare("SELECT point_id,
              journey_id,
              lat_dd,
              long_dd,
              battery_percent,
              ROUND(velocity_mph, 2) as velocity_mph
        FROM datapointsimport WHERE journey_id = ?");

// bind and run
$stmt->execute(array($journeyNumber));
// get all the results
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
foreach ($result as $row) {
  // ADD TO XML DOCUMENT NODE
  // states the node name
  $node = $dom->createElement("marker");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("journey_ref",$row['journey_id']);
  $newnode->setAttribute("point",$row['point_id']);
  $newnode->setAttribute("speed",$row['velocity_mph']);
  $newnode->setAttribute("lat", $row['lat_dd']);
  $newnode->setAttribute("lng", $row['long_dd']);
  $newnode->setAttribute("bat_percent", $row['battery_percent']);
}

echo $dom->saveXML();

?>