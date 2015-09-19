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

}catch(PDOException $ex){

      // create text string for logging
      $databaseFail = "\nDATABASE ERROR\n".date('d/m/Y H:i:s', time())." ".__FILE__." Error: ".$ex->getMessage();
      // write to log file
      file_put_contents(AJAX_LOGFILE, $databaseFail, FILE_APPEND | LOCK_EX);

} // end catch

echo $dom->saveXML();

?>