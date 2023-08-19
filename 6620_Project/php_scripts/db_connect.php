<?php
$server = "mysql1.cs.clemson.edu";
$username = "MeTube_6620_vao3";
$password = "6620_Students";
$dbname = "MeTube_6620_zt8l";

// open connection with mysql
$conn = new mysqli($server,
                   $username,
                   $password,
                   $dbname);

// Check for connection
if ($conn->connect_error){
    die("Connection failed: " .  $conn->connect_error);
}
//echo "'Successfully connected to DB'";
?>