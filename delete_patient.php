<?php
// Ensure you have session started if using session-based authentication
session_start();

$mysqli = require __DIR__ . "/database.php";

// Check if user is authenticated
// if (!isset($_SESSION['user_ID'])) {
//     echo "Not authenticated";
//     exit; // Stop script if user not authenticated
// }

// Database connection


// Check for errors in connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the employee ID from POST data
$patientId = $_POST['patient_ID'];

// Prepare the DELETE statement to prevent SQL injection
$stmt = $mysqli->prepare("DELETE FROM Patient WHERE patient_ID = ?");
$stmt->bind_param("i", $patientId);

// Execute the query
if ($stmt->execute()) {
    header('Location: View_Patient.php');
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>

