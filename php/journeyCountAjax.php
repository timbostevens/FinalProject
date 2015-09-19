<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("journeys");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../../connection.php");

// create query
$countQuery = "SELECT COUNT(*) AS 'count' FROM journeysimport";

header("Content-type: text/xml");

foreach ($db->query($countQuery) as $row) {
	  // states the node name
  $node = $dom->createElement("count");
  // creates a new node
  $newnode = $parnode->appendChild($node);
  // gets attribute and adds it to the node
  $newnode->setAttribute("journey_count",$row['count']);
}


echo $dom->saveXML();

?>