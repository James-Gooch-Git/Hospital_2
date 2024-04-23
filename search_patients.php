<?php
session_start();
include 'functions.php';
require __DIR__ . "/database.php";
$canEdit = isset($_SESSION["type_ID"]) && in_array($_SESSION["type_ID"], [1, 2, 3, 4]);


$query = $_POST['query'] ?? '';

// Sanitize the input for security
$query = $mysqli->real_escape_string($query);

$sql = "SELECT * FROM Patient WHERE patient_fName LIKE '%$query%' OR patient_lName LIKE '%$query%' OR patient_ContactNO LIKE '%$query%' OR patient_address LIKE '%$query%' OR patient_Email LIKE '%$query%'";

$result = $mysqli->query($sql);

while ($patient = $result->fetch_assoc()) {
    echo "<div class='employee-box'>"; // Consider renaming this class to 'patient-box' for clarity
                echo "<p>First Name:" . htmlspecialchars($patient['patient_fName']) . "</p>";
                echo "<p>Last Name: " . htmlspecialchars($patient['patient_lName']) . "</p>";
                echo "<p>Contact Number: " . htmlspecialchars($patient['patient_ContactNO']) . "</p>";
                echo "<p>Email: " . htmlspecialchars($patient['patient_Email']) . "</p>";
                echo "<p>Address: " . htmlspecialchars($patient['patient_address']) . "</p>";
                if ($canEdit) {
                    echo "<div class='patient-actions'>";
                    echo "<a href='update_Patient.php?id=" . htmlspecialchars($patient['patient_ID']) . "' class='btn update-btn'>Update</a>";
                    echo "<button onclick='confirmDelete(" . htmlspecialchars($patient['patient_ID']) . ")' class='btn delete-btn'>Delete</button>";
                    echo "</div>"; // This ensures that 'patient-actions' div is properly closed within the if condition
                }
                echo "</div>";
}
?>
