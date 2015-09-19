<?php
// constant for logging filepath
define("AJAX_LOGFILE","../logging/ajaxlog.txt");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


try{

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

}catch(PDOException $ex){

      // create text string for logging
      $databaseFail = "\nDATABASE ERROR\n".date('d/m/Y H:i:s', time())." ".__FILE__." Error: ".$ex->getMessage();
      // write to log file
      file_put_contents(AJAX_LOGFILE, $databaseFail, FILE_APPEND | LOCK_EX);

} // end catch

echo $dom->saveXML();

?>