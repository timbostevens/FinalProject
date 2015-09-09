<?php

// pull the total number of panels from the request
$journeyRequired = $_GET["req"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("summary");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../../connection.php");


$stmt = $db->prepare("SELECT ordered.row as panel_count
									from (SELECT  @rownum:=@rownum+1 'row', journey_id AS JourneyID
      										FROM journeysimport, (SELECT @rownum:=0) temp_row_table
      										ORDER BY journey_date DESC, start_time DESC) AS ordered
									WHERE journeyID = ?");

header("Content-type: text/xml");

// bind parameters and execute
$stmt->execute(array($journeyRequired));

  // get all results
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// cycle through results
foreach($result as $row){

  // states the node name
  $node = $dom->createElement("count");
  // creates a new node
  $newnode = $parnode->appendChild($node);
  // gets attribute and adds it to the node
  $newnode->setAttribute("panel_count",$row['panel_count']);
};

echo $dom->saveXML();

?>