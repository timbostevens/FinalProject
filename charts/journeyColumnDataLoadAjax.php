<?php


// pull journey number from Get request
$journeyNumber = $_GET["journey"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("summary");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

include("../../connection.php");

// escape the string for security
// $journeyNumber = mysqli_real_escape_string($connection, $journeyNumber);

// prepare statement
$statQuery = $db->prepare("SELECT 'Speed (mph)' as parameter, ROUND(average_speed_mph,2) as val, min, max, average
            FROM journeysimport, (SELECT ROUND(MIN(average_speed_mph),2) as min, ROUND(MAX(average_speed_mph),2) as max, ROUND(AVG(average_speed_mph),2) as average
            FROM journeysimport) as temp_summary
          WHERE journey_id = ?
    
    UNION
    
    SELECT 'Distance (mi)' as parameter, ROUND(distance_mi,2) as val, min, max, average
            FROM journeysimport, (SELECT ROUND(MIN(distance_mi),2) as min, ROUND(MAX(distance_mi),2) as max, ROUND(AVG(distance_mi),2) as average
            FROM journeysimport) as temp_summary
          WHERE journey_id = ?
    
  UNION
    
    SELECT 'Duration (mins)' as parameter, ROUND(duration_mins,2) as val, min, max, average
            FROM journeysimport, (SELECT ROUND(MIN(duration_mins),2) as min, ROUND(MAX(duration_mins),2) as max, ROUND(AVG(duration_mins),2) as average
            FROM journeysimport) as temp_summary
          WHERE journey_id = ?
    
  UNION
    
    SELECT 'Petrol Saved (L)' as parameter, ROUND(petrol_saved_ltr,2) as val, min, max, average
            FROM journeysimport, (SELECT ROUND(MIN(petrol_saved_ltr),2) as min, ROUND(MAX(petrol_saved_ltr),2) as max, ROUND(AVG(petrol_saved_ltr),2) as average
            FROM journeysimport) as temp_summary
          WHERE journey_id = ?
    
  UNION
    
    SELECT 'CO2 Saved (kg)' as parameter, ROUND(co2_saved_kg,2) as val, min, max, average
            FROM journeysimport, (SELECT ROUND(MIN(co2_saved_kg),2) as min, ROUND(MAX(co2_saved_kg),2) as max, ROUND(AVG(co2_saved_kg),2) as average
            FROM journeysimport) as temp_summary
          WHERE journey_id = ?");

// bind parameters (all integers)
// mysqli_stmt_bind_param($statQuery, 'iiiii',$journeyNumber,$journeyNumber,$journeyNumber,$journeyNumber,$journeyNumber);

$statQuery->execute(array($journeyNumber,$journeyNumber,$journeyNumber,$journeyNumber,$journeyNumber));

// get result
// mysqli_stmt_execute($statQuery);

// get result and pass to var
// $result = mysqli_stmt_get_result($statQuery);

$result = $statQuery->fetchAll(PDO::FETCH_ASSOC);

// $result = mysqli_query($connection, $statQuery);

// if there is no result, throw an error
// if (!$result) {
//   die('Invalid query: ' . mysql_error());
// }

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

// while ($row = @mysqli_fetch_assoc($result)){

foreach ($result as $row) {
  // ADD TO XML DOCUMENT NODE

  // states the node name
  $node = $dom->createElement("sum");
  // creates a new node
  $newnode = $parnode->appendChild($node);

  // $row[] states column name in to retrieve from db results
  // setAttribute(.... is how it is listed in produced xml
  $newnode->setAttribute("parameter",$row['parameter']);
  $newnode->setAttribute("val",$row['val']);
  $newnode->setAttribute("min",$row['min']);
  $newnode->setAttribute("max", $row['max']);
  $newnode->setAttribute("average", $row['average']);
}

echo $dom->saveXML();

?>