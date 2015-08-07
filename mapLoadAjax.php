<?php

// pull journey number from Get request
$journeyNumber = $_GET["journey"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("connection.php");

// Set the active MySQL database

// $db_selected = mysqli_select_db($database, $connection);
// if (!$db_selected) {
//   die ('Can\'t use db : ' . mysql_error());
// }

// Select rows from the datapoints table
//updates results so that journey 1 becomes the highest journey number from the database
//$queryDatapoints = "SELECT * FROM datapointsimport WHERE journey_id = $journeyNumber";
//$result = mysqli_query($connection, $queryDatapoints);

// prepare statement
$stmt = mysqli_prepare($connection, "SELECT * FROM datapointsimport WHERE journey_id = ?");

// bind parameters
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
  $newnode->setAttribute("speed", $row['velocity_mph']);
  $newnode->setAttribute("lat", $row['lat_dd']);
  $newnode->setAttribute("lng", $row['long_dd']);
  $newnode->setAttribute("b_current", $row['battery_percent']);
}

echo $dom->saveXML();

?>