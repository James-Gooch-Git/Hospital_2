<?php
include_once 'functions.php';

// Assuming getPatients is a function that fetches patient data as an array of ['patient_id' => x, 'patient_name' => y]
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
    echo "<select name='patient_ID'>";
    foreach ($patients as $patient) {
        echo "<option value='" . htmlspecialchars($patient['patient_ID']) . "'>Patient ID " . htmlspecialchars($patient['patient_ID']) . " | " . htmlspecialchars($patient['patient_fName']) . " " . htmlspecialchars($patient['patient_lName']) . "</option>";
    }
    
    echo "</select>";
    echo "<button type='submit' class='btn assign-btn'>Assign Patient</button>";
    echo "</form>";
    echo "<button onclick='confirmDelete(" . htmlspecialchars($availability['availability_id']) . ")' class='btn delete-btn'>Delete</button>";

    echo "</div>";
    echo "</div>";
}
?>
