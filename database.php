<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

// $config = require '/Users/jamesgooch/Library/CloudStorage/OneDrive-SheffieldHallamUniversity/SignUp/config.php'; // Adjust the path as necessary
// $dbConfig = $config['db'];

// $mysqli = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

// if ($mysqli->connect_errno) {
//     die("Connection error: " . $mysqli->connect_error);
// }

// return $mysqli;



$host = "127.0.0.1";
$port = 3306;
$dbname = "mydb";
$username = "root";
$password = "Javg070796!?";

// Combine host and port into a single string
$hostWithPort = $host . ":" . $port;

$mysqli = new mysqli($hostWithPort, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error); // Change `con` to `connect_error`
}

return $mysqli;
