
<?php 
session_start();

$canEdit = isset($_SESSION["type_ID"]) && in_array($_SESSION["type_ID"], [1, 2, 3, 4]);

include 'functions.php'; 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
   
    <main class="content">
    <?php
    include_once 'functions.php';

 
    $patients = getPatientsDropdown();

    $Availabilities = getAvailability();
    foreach ($Availabilities as $availability) {
        echo "<div class='availability-box'>";
        echo "<p>Date: " . htmlspecialchars($availability['date']) . "</p>";
        echo "<p>Time (1hr): " . htmlspecialchars($availability['timeSlotHourBlock']) . "</p>";
        echo "<p>Consultant: " . htmlspecialchars($availability['consultantName']) . "</p>";
        echo "<p>" . htmlspecialchars($availability['patientName']) . "</p>"; // Displaying patient name
        echo "<p>" . htmlspecialchars($availability['patientId']) . "</p>";

        echo "<div class='availability-actions'>";
        echo "<form action='assign_patient.php' method='post'>";
        echo "<input type='hidden' name='availability_id' value='" . htmlspecialchars($availability['availability_id']) . "'>";
        echo "<select class='patientdrop' name='patient_ID'>";
        foreach ($patients as $patient) {
            echo "<option value='" . htmlspecialchars($patient['patient_ID']) . "'>Patient ID " . htmlspecialchars($patient['patient_ID']) . " | " . htmlspecialchars($patient['patient_fName']) . " " . htmlspecialchars($patient['patient_lName']) . "</option>";
        }
        
        echo "</select>";
        echo "<button type='submit' class='btn assign-btn'>Assign Patient</button>";
        echo "</form>";
        echo "<button onclick='confirmDeleteB(" . htmlspecialchars($availability['availability_id']) . ")' class='btn delete-btn'>Delete</button>";

        echo "</div>";
        echo "</div>";
    }
    ?>

    </main>

    <?php 
        if ($canEdit) {
            include 'make_Booking.php'; 
        }        
    ?>
        
    
   
</div>


</body>
</html>
