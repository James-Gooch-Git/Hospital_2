<?php

session_start();

$mysqli = require __DIR__ . "/database.php";


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$patientId = $_POST['patient_ID'];


$stmt = $mysqli->prepare("DELETE FROM Patient WHERE patient_ID = ?");
$stmt->bind_param("i", $patientId);


if ($stmt->execute()) {
    header('Location: View_Patient.php');
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>

