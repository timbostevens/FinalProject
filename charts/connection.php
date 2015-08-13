<?php
// parameters for connection
$webaddress = 'localhost';
$username="root";
$password="";
$database="test";

// make connection
$connection = mysqli_connect($webaddress,$username,$password,$database);
// check connection
if (!$connection) {
	die('Not connected : ' . mysql_error());}

?>