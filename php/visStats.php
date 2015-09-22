<?php
// constant for logging filepath
define("AJAX_LOGFILE","../logging/ajaxlog.txt");

try{
    // gets connection details
    include("../connection.php");
    // sql query to count journeys
    $visStmt="SELECT COUNT(journey_id) as 'total_journeys',
        temp_av_speed as 'av_speed',
        SUM(duration_mins) as 'total_time',
        ROUND(AVG(duration_mins),2) as 'average_time',
        ROUND(SUM(distance_mi),2) as 'total_distance',
        ROUND(AVG(distance_mi),2) as 'average_distance',
        ROUND(SUM(petrol_saved_ltr),2) as 'total_petrol',
        ROUND(AVG(petrol_saved_ltr),2) as 'average_petrol',
        ROUND(SUM(co2_saved_kg),2) as 'total_co2',
        ROUND(AVG(co2_saved_kg),2) as 'average_co2'
      FROM journeysimport,
            (SELECT ROUND(AVG(velocity_mph),2) as temp_av_speed
            FROM datapointsimport) as tempspeed";

    // runs the query and sets to variable $row
    foreach ($db->query($visStmt) as $row) {
    $totalJourneys=$row['total_journeys'];
    $averageSpeed=$row['av_speed'];
    $totalTime=$row['total_time'];
    $averageTime=$row['average_time'];
    $totalDistance=$row['total_distance'];
    $averageDistance=$row['average_distance'];
    $totalPetrol=$row['total_petrol'];
    $averagePetrol=$row['average_petrol'];
    $totalCo2=$row['total_co2'];
    $averageCo2=$row['average_co2'];
}

}catch(PDOException $ex){

      // create text string for logging
      $databaseFail = "\nDATABASE ERROR\n".date('d/m/Y H:i:s', time())." ".__FILE__." Error: ".$ex->getMessage();
      // write to log file
      file_put_contents(AJAX_LOGFILE, $databaseFail, FILE_APPEND | LOCK_EX);

} // end catch

?>