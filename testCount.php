<?php

    session_start();
    
    include("connection.php");
    
    $query="SELECT COUNT(*) AS 'count' FROM journeys";
    
    $result = mysqli_query($connection,$query);
    
    $row = mysqli_fetch_array($result);
    
    $journeyCount=$row['count'];

    echo $journeyCount;

?>