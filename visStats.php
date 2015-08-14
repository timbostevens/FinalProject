<?php

    // session_start();
    // gets connection details
    include("connection.php");
    // sql query to count journeys
    $visStmt="SELECT COUNT(journey_id) as 'total journeys',
        temp_av_speed as 'av speed',
        SUM(duration_mins) as 'total time',
        ROUND(AVG(duration_mins),2) as 'average time',
        ROUND(SUM(distance_mi),2) as 'total distance',
        ROUND(AVG(distance_mi),2) as 'average distance',
        ROUND(SUM(petrol_saved_ltr),2) as 'total petrol',
        ROUND(AVG(petrol_saved_ltr),2) as 'average petrol',
        ROUND(SUM(co2_saved_kg),2) as 'total co2',
        ROUND(AVG(co2_saved_kg),2) as 'average co2'
      FROM journeysimport,
            (SELECT ROUND(AVG(velocity_mph),2) as temp_av_speed
            FROM datapointsimport) as tempspeed";
    // runs the query and sets to variable
    $result = mysqli_query($connection,$visStmt);
    // gets the first row (all that is needed for this one)
    $row = mysqli_fetch_array($result);
    // extracts value from first (only) row
    $totalJourneys=$row['total journeys'];
    $averageSpeed=$row['av speed'];
    $totalTime=$row['total time'];
    $averageTime=$row['average time'];
    $totalDistance=$row['total distance'];
    $averageDistance=$row['average distance'];
    $totalPetrol=$row['total petrol'];
    $averagePetrol=$row['average petrol'];
    $totalCo2=$row['total co2'];
    $averageCo2=$row['average co2'];

?>