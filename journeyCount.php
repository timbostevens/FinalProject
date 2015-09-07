<?php
    // gets connection details
    include("../connection.php");
    // sql query to count journeys
    $query="SELECT COUNT(*) AS 'count' FROM journeysimport";
    // create full statement
    $stmt = $db->query($query);
    // get result and apply to var
    $journeyCount = $stmt->fetchColumn(0);
?>