<?php

$username="root";
$password="";
$database="test";

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("journeys");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select rows from the datapoints table
//updates results so that journey 1 becomes the highest journey number from the database
$queryDatapoints = "SELECT tempdata.journey_id as JourneyID, DATE_FORMAT(tempdata.point_timestamp,'%D %M %Y') as FirstTimestamp
    FROM (SELECT * FROM datap WHERE point_id=1) as tempdata
    JOIN (SELECT journey_id
      FROM jour
      ORDER BY journey_id desc
      LIMIT 5) as tempjour ON tempjour.journey_id=tempdata.journey_id
      ORDER BY tempdata.journey_id desc";
$result = mysql_query($queryDatapoints);

// if there is no result, throw an error
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE

  // states the node name
  $node = $dom->createElement("journeyrecord");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("journeyID",$row['JourneyID']);
  $newnode->setAttribute("date", $row['FirstTimestamp']);

}

echo $dom->saveXML();

?>