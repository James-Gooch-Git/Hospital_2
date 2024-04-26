<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);





$host = "127.0.0.1";
$port = 3306;
$dbname = "mydb";
$username = "root";
$password = "Javg070796!?";

$hostWithPort = $host . ":" . $port;

$mysqli = new mysqli($hostWithPort, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error); 
}

return $mysqli;
