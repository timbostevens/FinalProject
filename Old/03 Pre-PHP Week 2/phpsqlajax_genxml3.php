<?php

$username="root";
$password="";
$database="test";

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "SELECT * FROM datapoints";
$result = mysql_query($query);

// if there is no result, throw an error
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE

  // states the node name
  $node = $dom->createElement("marker");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("name",$row['point_id']);
  $newnode->setAttribute("speed", $row['speed_kmh']);
  $newnode->setAttribute("lat", $row['lat_dd']);
  $newnode->setAttribute("lng", $row['long_dd']);
  $newnode->setAttribute("b_current", $row['battery_current']);
}

echo $dom->saveXML();

?>