<?php
session_start();

// Assuming the logged-in user's type_ID is stored in the session

//$canEdit = isset($_SESSION["type_ID"]) && in_array($_SESSION["type_ID"], [1]);
$canEdit = true;

include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure your CSS file is linked here -->
    <script src="JSFunctions.js" defer></script>
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="content">
     
        <div class="search-container">
            <input type="text" id="searchPInput" placeholder="Search patients..." onkeyup="searchPatients()">
            <a href="Add_Patient.php" class="btn">Add Patient</a>
        </div>

        <div id="patientList">
            <?php
            $patients = getPatients();
            foreach ($patients as $patient) {
                echo "<form method='POST' action='update_patient.php' class='update-form' id='patientForm_{$patient['patient_ID']}'>";
                echo "<div class='patient-box' id='patientBox_{$patient['patient_ID']}'>";
                echo "<p>First Name:" . htmlspecialchars($patient['patient_fName']) . "</p>";
                echo "<p>Last Name: " . htmlspecialchars($patient['patient_lName']) . "</p>";
                echo "<p>Contact Number: " . htmlspecialchars($patient['patient_ContactNO']) . "</p>";
                echo "<p>Email: " . htmlspecialchars($patient['patient_Email']) . "</p>";
                echo "<p>Address: " . htmlspecialchars($patient['patient_address']) . "</p>";
                echo "<div id='editFields_{$patient['patient_ID']}' style='display:none;'>";
                echo "<input type='hidden' name='patient_ID' value='" . htmlspecialchars($patient['patient_ID']) . "'>";
    
                echo "<input type='text' name='patient_fName' value='" . htmlspecialchars($patient['patient_fName']) . "' >";
                echo "<input type='text' name='patient_lName' value='" . htmlspecialchars($patient['patient_lName']) . "' class='edit-input'>";
                echo "<input type='text' name='patient_ContactNO' value='" . htmlspecialchars($patient['patient_ContactNO']) . "' class='edit-input'>";
                echo "<input type='text' name='patient_Email' value='" . htmlspecialchars($patient['patient_Email']) . "' class='edit-input'>";
                echo "<input type='text' name='patient_address' value='" . htmlspecialchars($patient['patient_address']) . "' class='edit-input'>";
                echo "</div>";
                
                if ($canEdit) {
                    echo "<div class='patient-actions' id='actionButtons_{$patient['patient_ID']}'>";
                    echo "<a href='#' class='btn update-btn' onclick='enableEdit(" . $patient['patient_ID'] . ")'>Edit</a>";
                    echo "<button onclick='confirmDelete(" . $patient['patient_ID'] . ")' class='btn delete-btn'>Delete</button>";
                    echo "</div>";
                    
                    echo "<div class='confirm-actions' style='display:none;' id='confirmButtons_{$patient['patient_ID']}'>";
                  
                    echo "<button onclick='confirmEdit(" . $patient['patient_ID'] . ")' class='btn confirm-btn'>Confirm</button>";
                    echo "<button onclick='cancelEdit(" . $patient['patient_ID'] . ")' class='btn cancel-btn'>Cancel</button>";
                    echo "</div>";
                }
                echo "<a href='View_Diagnosis.php?patient_ID=" . $patient['patient_ID'] . "' class='btn view-diagnosis-btn'>View Diagnoses</a>";
                echo "<a href='View_Prescription.php?patient_ID=" . $patient['patient_ID'] . "' class='btn view-prescription-btn'>View Prescriptions</a>";

                echo "</form>";
            
                echo "</div>";
            
            }
            ?>
        </div>
    </main>
</div>

</body>
</html>
