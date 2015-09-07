<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../../connection.php");

// create query
$heatStmt = "SELECT lat_dd,
                long_dd
         FROM datapointsimport";


header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
  foreach ($db->query($heatStmt) as $row) {
  // ADD TO XML DOCUMENT NODE

  // states the node name
  $node = $dom->createElement("marker");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("lat", $row['lat_dd']);
  $newnode->setAttribute("lng", $row['long_dd']);
}

echo $dom->saveXML();

?>