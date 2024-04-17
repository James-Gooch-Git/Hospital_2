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
            Diagnosis.diagnosis_ID, 
            Diagnosis.diagnosis_name, 
            CONCAT(Patient.patient_fName, ' ', Patient.patient_lName) AS patientName, 
            CONCAT(Staff.fName, ' ', Staff.lName) AS staffName
          FROM 
            Diagnosis 
          JOIN 
            Patient ON Diagnosis.patient_ID = Patient.patient_ID
          JOIN 
            Staff ON Diagnosis.user_ID = Staff.user_ID
          WHERE 
            Diagnosis.patient_ID = ?";

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
    while ($diagnosis = $result->fetch_assoc()) {
        echo "<p>Diagnosis ID: " . htmlspecialchars($diagnosis['diagnosis_ID']) . "</p>";
        echo "<p>Description: " . htmlspecialchars($diagnosis['diagnosis_name']) . "</p>";
        echo "<p>Patient Name: " . htmlspecialchars($diagnosis['patientName']) . "</p>";
        echo "<p>Staff Name: " . htmlspecialchars($diagnosis['staffName']) . "</p>";
    }
} else {
    // Display a message if no diagnosis entries are found
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin-top: 10px;'>";
    echo "No medical history.";
    echo "</div>";
}

// Close statement
$stmt->close();

// Close connection
$mysqli->close();
?>
