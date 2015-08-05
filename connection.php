<?php

$webaddress = 'localhost';
$username="root";
$password="";
$database="test";



$connection = mysqli_connect($webaddress,$username,$password,$database);

if (!$connection) {  die('Not connected : ' . mysql_error());}

?>