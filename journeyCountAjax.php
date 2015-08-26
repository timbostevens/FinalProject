<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("journeys");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("connection.php");

// create query
$countQuery = "SELECT COUNT(*) AS 'count' FROM journeysimport";
// runs the query and sets to variable
$result = mysqli_query($connection, $countQuery);
// gets the first row (all that is needed for this one)
$row = mysqli_fetch_array($result);


// if there is no result, throw an error
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

  // states the node name
  $node = $dom->createElement("count");
  // creates a new node
  $newnode = $parnode->appendChild($node);
  // gets attribute and adds it to the node
  $newnode->setAttribute("journey_count",$row['count']);

echo $dom->saveXML();

?>