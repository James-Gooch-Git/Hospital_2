<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'functions.php';
require __DIR__ . "/database.php";

// Fetch patients from database
$patientQuery = "SELECT patient_ID, patient_fName FROM Patient ORDER BY patient_fName";
$result = $mysqli->query($patientQuery);
if (!$result) {
    die('Query failed: ' . $mysqli->error);
}
$patients = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['availability_id'], $_POST['patient_ID'])) {
    $availabilityId = $_POST['availability_id'];
    $patientId = $_POST['patient_ID'];

    // Optional: Validate the patient ID before assignment (e.g., check if it exists in the database)

    // Prepare the SQL statement to update the Availability table
    $sql = "UPDATE Availability SET patient_ID = ? WHERE availability_id = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $stmt->bind_param('ii', $patientId, $availabilityId);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }

    $stmt->close();
    
    // Redirect back to the view availabilities page or wherever appropriate
    header('Location: View_Bookings.php'); // Adjust this as needed
    exit();
}
?>
