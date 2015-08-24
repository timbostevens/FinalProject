<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("days");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("connection.php");

// prepare statement
$allSummaryQuery = "SELECT  date_format(journey_date,'%d') as jDay,
                            date_format(journey_date,'%m') as jMon,
                            date_format(journey_date,'%Y') as jYear,
                            ROUND(SUM(distance_mi),2) as totalDist_mi
                          from journeysimport
                          GROUP BY journey_date";

$result = mysqli_query($connection, $allSummaryQuery);

// if there is no result, throw an error
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE

  // states the node name
  $node = $dom->createElement("calDay");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("day",$row['jDay']);
  $newnode->setAttribute("month",$row['jMon']);
  $newnode->setAttribute("year", $row['jYear']);
  $newnode->setAttribute("distance_mi", $row['totalDist_mi']);
}

echo $dom->saveXML();

?>