<?php

include("../connection.php");

$deleteData = "DELETE FROM datapointsimport WHERE journey_id>0";

// mysqli_query($connection, $deleteData);

$db->exec($deleteData);


$deleteJourneys = "DELETE FROM journeysimport WHERE journey_id>0";

// mysqli_query($connection, $deleteJourneys);

$db->exec($deleteJourneys);

echo "Done";

?>