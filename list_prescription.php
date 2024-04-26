<?php
include_once 'functions.php';

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$patientId = isset($_GET['patient_ID']) ? $_GET['patient_ID'] : die('Patient ID not specified.');

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

$stmt->bind_param('i', $patientId); // 'i' is the type for integer

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($perscription = $result->fetch_assoc()) {
        echo "<p>Perscription ID: " . htmlspecialchars($perscription['prescription_Id']) . "</p>";
        echo "<p>Medication Name (Dose): " . htmlspecialchars($perscription['medication_name']) . "</p>";
        echo "<p>Cost: " . htmlspecialchars($perscription['cost']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($perscription['date_prescribed']) . "</p>";
        echo "<p>Patient Name: " . htmlspecialchars($perscription['patientName']) . "</p>";
        echo "<p>Staff Name: " . htmlspecialchars($perscription['staffName']) . "</p>";
    }
} else {
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin-top: 10px;'>";
    echo "No medical history.";
    echo "</div>";
}

$stmt->close();

$mysqli->close();
?>
