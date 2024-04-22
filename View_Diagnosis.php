<?php
session_start();
include 'functions.php'; 

$patientID = $_GET['patient_ID'] ?? null; // Use the null coalescing operator to handle cases where `patient_ID` isn't in the URL

if (null === $patientID) {
    echo "No patient selected."; // Handle the case where no patient ID is provided
    exit;
}

$diagnoses = getDiagnosisForPatient($patientID); // Assuming you have a function to fetch diagnoses for a patient
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Diagnoses</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure your CSS file is linked properly -->
    <script src="JSFunctions.js" defer></script>
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="content">
    <?php
        if ($_SESSION['type_ID'] == 1 || $_SESSION['type_ID'] == 2 || $_SESSION['type_ID'] == 3) {
                echo "<a href='Add_Diagnosis.php?patient_ID=" . htmlspecialchars($patientID) . "' class='btn'>Add New Diagnosis</a>";
            }
    ?>        
        <a href="view_Patient.php" class="btn">Back to Patients</a>

        <div id="diagnosisList">
            <?php 
            if (!empty($diagnoses)) {
                foreach ($diagnoses as $diagnosis) {
                    echo "<form method='POST' action='update_diagnosis.php' class='update-form' id='diagnosisForm_{$diagnosis['diagnosis_ID']}'>";
                    echo "<div class='diagnosis-box' id='diagnosisBox_{$diagnosis['diagnosis_ID']}'>";
                    echo "<p>Diagnosis ID: " . htmlspecialchars($diagnosis['diagnosis_ID']) . "</p>";
                    echo "<p>Description: " . htmlspecialchars($diagnosis['diagnosis_name']) . "</p>";
                    echo "<p>Patient Name: " . htmlspecialchars($diagnosis['patientName']) . "</p>";
                    echo "<p>Staff Name: " . htmlspecialchars($diagnosis['staffName']) . "</p>";
                    echo "<div class='confirm-actions' style='display:none;' id='confirmButtons_{$diagnosis['diagnosis_ID']}'>";
                    echo "<button class='btn confirm-btn'>Confirm</button>";
                    echo "<button class='btn cancel-btn' onclick='cancelEdit(" . $diagnosis['diagnosis_ID'] . ")'>Cancel</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";
                }
            } else {
                echo "No medical history.";
            }
            ?>
        </div>
    </main>
</div>

</body>
</html>
