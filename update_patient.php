<?php
$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = $_POST['patient_ID'];
    $patient_fName = $_POST['patient_fName'];
    $patient_lName = $_POST['patient_lName'];
    $patient_ContactNO = $_POST['patient_ContactNO'];
    $patient_Email = $_POST['patient_Email']; 
    $patient_address = $_POST['patient_address'];

    $stmt = $mysqli->prepare("UPDATE Patient SET patient_fName = ?, patient_lName = ?, patient_ContactNO = ?, patient_Email = ?, patient_address = ? WHERE patient_ID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    $stmt->bind_param('sssssi', $patient_fName, $patient_lName, $patient_ContactNO, $patient_Email, $patient_address, $patientId);
    if ($stmt->execute()) {
        header('Location: View_Patient.php');
    } else {
        echo "<script>console.error('Error updating record:', " . json_encode($stmt->error) . ");</script>";
    
        echo "<script>console.log('Parameters:', " . json_encode([$patient_fName, $patient_lName, $patient_ContactNO, $patient_Email, $patient_address, $patientId]) . ");</script>";
    }
    $stmt->close();
    
}
?>
