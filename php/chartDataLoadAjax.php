<?php
// constant for logging filepath
define("AJAX_LOGFILE","../logging/ajaxlog.txt");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("journeys");
$parnode = $dom->appendChild($node);

try{

    // Opens a connection to a MySQL server
    include("../../connection.php");

    // create query
    $allSummaryQuery = "SELECT journey_id,
                                average_speed_mph,
                                distance_mi,
                                duration_mins,
                                petrol_saved_ltr,
                                co2_saved_kg
                              FROM journeysimport WHERE 1";

    header("Content-type: text/xml");

    // Iterate through the rows, adding XML nodes for each

    foreach ($db->query($allSummaryQuery) as $row) {
      // ADD TO XML DOCUMENT NODE

      // states the node name
      $node = $dom->createElement("journey");
      // creates a new node
      $newnode = $parnode->appendChild($node);

      // $row[] states column name in to retrieve from db results
      // setAttribute(.... is how it is listed in produced xml
      // $newnode->setAttribute("journey_ref",$row['journey_id']);
      $newnode->setAttribute("speed",$row['average_speed_mph']);
      $newnode->setAttribute("distance",$row['distance_mi']);
      $newnode->setAttribute("duration", $row['duration_mins']);
      $newnode->setAttribute("petrol", $row['petrol_saved_ltr']);
      $newnode->setAttribute("co2", $row['co2_saved_kg']);
    }

}catch(PDOException $ex){

      // create text string for logging
      $databaseFail = "\nDATABASE ERROR\n".date('d/m/Y H:i:s', time())." ".__FILE__." Error: ".$ex->getMessage();
      // write to log file
      file_put_contents(AJAX_LOGFILE, $databaseFail, FILE_APPEND | LOCK_EX);

} // end catch

echo $dom->saveXML();

?>