<?php

    session_start();
    // gets connection details
    include("../connection.php");
    // sql query to count journeys
    $query="SELECT COUNT(*) AS 'count' FROM journeysimport";
    // runs the query and sets to variable
    $result = mysqli_query($connection,$query);
    // gets the first row (all that is needed for this one)
    $row = mysqli_fetch_array($result);
    // extracts value from first row
    $journeyCount=$row['count'];

?>