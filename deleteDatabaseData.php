<?php

include("../connection.php");

$deleteData = "DELETE FROM datapointsimport WHERE journey_id>0";

mysqli_query($connection, $deleteData);


$deleteJourneys = "DELETE FROM journeysimport WHERE journey_id>0";

mysqli_query($connection, $deleteJourneys);

echo "Done";

?>