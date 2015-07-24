<?php
    
  // Creates multi-dimensional array for 5 most recent journeys of first timestamp and journey id


    // gets connection details
    include("connection.php");
    // sql query to get id and date of 5 most recent journeys
    $query="SELECT tempdata.journey_id as Journey, DATE_FORMAT(tempdata.point_timestamp,'%D %M %Y') as FirstTimestamp
    //FROM (SELECT * FROM datapoints WHERE point_id=1) as tempdata
    //JOIN (SELECT journey_id
      //FROM journeys
      //ORDER BY journey_id desc
      //LIMIT 5) as tempjour ON tempjour.journey_id=tempdata.journey_id
      //ORDER BY tempdata.journey_id desc";



    // runs the query and sets to variable
  $result = mysqli_query($connection,$query);
    // create array to hold results (will be multidimensional)
  $resultArray = [];
    // cycle through reuslt and add to reuslts array
  while($row = mysqli_fetch_array($result)){
      // create array for each row
      $innerArray = [$row['Journey'], $row['FirstTimestamp']];
      // add each row array to the outer array
     array_push($resultArray, $innerArray);
 };
  // counts the number of journeys
  $journeyCount = count($resultArray);


?>