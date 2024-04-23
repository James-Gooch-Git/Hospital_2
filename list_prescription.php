<?php
include_once 'functions.php';

$mysqli = require __DIR__ . "/database.php";

// Database connection check
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$patientId = isset($_GET['patient_ID']) ? $_GET['patient_ID'] : die('Patient ID not specified.');

// Prepare the statement with joins to fetch names
$query = "SELECT 
            Prescription.prescription_Id, 
            Prescription.medication_name, 
            Prescription.cost,
            Prescription.date_prescribed,
            CONCAT(Patient.patient_fName, ' ', Patient.patient_lName) AS patientName, 
            CONCAT(Staff.fName, ' ', Staff.lName) AS staffName
          FROM 
            Prescription 
          JOIN 
            Patient ON Prescription.patient_ID = Patient.patient_ID
          JOIN 
            Staff ON Prescription.user_ID = Staff.user_ID
          WHERE 
            Prescription.patient_ID = ?";

$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die('MySQL prepare error: ' . $mysqli->error);
}

// Bind parameters
$stmt->bind_param('i', $patientId); // 'i' is the type for integer

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are diagnoses available
if ($result->num_rows > 0) {
    // Display the results
    while ($perscription = $result->fetch_assoc()) {
        echo "<p>Perscription ID: " . htmlspecialchars($perscription['prescription_Id']) . "</p>";
        echo "<p>Medication Name (Dose): " . htmlspecialchars($perscription['medication_name']) . "</p>";
        echo "<p>Cost: " . htmlspecialchars($perscription['cost']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($perscription['date_prescribed']) . "</p>";
        echo "<p>Patient Name: " . htmlspecialchars($perscription['patientName']) . "</p>";
        echo "<p>Staff Name: " . htmlspecialchars($perscription['staffName']) . "</p>";
    }
} else {
    // Display a message if no perscription entries are found
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin-top: 10px;'>";
    echo "No medical history.";
    echo "</div>";
}

// Close statement
$stmt->close();

// Close connection
$mysqli->close();
?>
