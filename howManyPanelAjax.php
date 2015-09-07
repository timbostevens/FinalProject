<?php

// pull the total number of panels from the request
$journeyRequired = $_GET["req"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("summary");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../connection.php");

// escape the string for security
// $journeyRequired = mysqli_real_escape_string($connection, $journeyRequired);

// // create query
// $countQuery = "SELECT COUNT(*) AS 'count' FROM journeysimport";
// // runs the query and sets to variable
// $result = mysqli_query($connection, $countQuery);
// // gets the first row (all that is needed for this one)
// $row = mysqli_fetch_array($result);


// $stmt = mysqli_prepare($connection, "SELECT COUNT(journey_id) as panel_count
// 									FROM journeysimport
// 									WHERE journey_id >= ?");



$stmt = $db->prepare("SELECT ordered.row as panel_count
									from (SELECT  @rownum:=@rownum+1 'row', journey_id AS JourneyID
      										FROM journeysimport, (SELECT @rownum:=0) temp_row_table
      										ORDER BY journey_date DESC, start_time DESC) AS ordered
									WHERE journeyID = ?");


// get result
// mysqli_stmt_execute($stmt);

// get result and pass to var
// $result = mysqli_stmt_get_result($stmt);

// // if there is no result, throw an error
// if (!$result) {
//   echo "NO RESULT";
// }

header("Content-type: text/xml");

// gets the first row (all that is needed for this one)
// $row = mysqli_fetch_array($result);


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