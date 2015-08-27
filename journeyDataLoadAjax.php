<?php

// pull journey number from Get request
$journeyNumber = $_GET["journey"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../connection.php");

// prepare statement
$stmt = mysqli_prepare($connection, "SELECT point_id,
                                            journey_id,
                                            lat_dd,
                                            long_dd,
                                            battery_percent,
                                            ROUND(velocity_mph, 2) as velocity_mph
                                      FROM datapointsimport WHERE journey_id = ?");

// bind parameters (integer)
mysqli_stmt_bind_param($stmt, 'i',$journeyNumber);

// get result
mysqli_stmt_execute($stmt);

// get result and pass to var
$result = mysqli_stmt_get_result($stmt);

// if there is no result, throw an error
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
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