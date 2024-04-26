<?php

session_start();

$mysqli = require __DIR__ . "/database.php";


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$userId = $_POST['user_ID'];


$stmt = $mysqli->prepare("DELETE FROM Staff WHERE user_ID = ?");
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    header('Location: View_Employee.php');
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>

