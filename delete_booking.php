<?php

session_start();

$mysqli = require __DIR__ . "/database.php";


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$availabilityId = $_POST['availability_id'];


$stmt = $mysqli->prepare("DELETE FROM Availability WHERE availability_id = ?");
$stmt->bind_param("i", $availabilityId);


if ($stmt->execute()) {
    header('Location: View_Bookings.php');
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>

