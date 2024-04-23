<?php
session_start();
include 'functions.php';
require __DIR__ . "/database.php";
$canEdit = isset($_SESSION["type_ID"]) && in_array($_SESSION["type_ID"], [1, 2, 3, 4]);


$query = $_POST['query'] ?? '';

// Sanitize the input for security
$query = $mysqli->real_escape_string($query);


$sql = "SELECT Staff.*, Staff_Type.type_description 
FROM Staff
INNER JOIN Staff_Type ON Staff.type_ID = Staff_Type.type_ID
WHERE fName LIKE '%$query%' OR lName LIKE '%$query%' OR email LIKE '%$query%' OR address LIKE '%$query%' OR type_description LIKE '%$query%'";

$result = $mysqli->query($sql);

while ($employee = $result->fetch_assoc()) {
    echo "<div class='employee-box'>"; // Consider renaming this class to 'patient-box' for clarity
                echo "<p>First Name:" . htmlspecialchars($employee['fName']) . "</p>";
                echo "<p>Last Name: " . htmlspecialchars($employee['lName']) . "</p>";
                echo "<p>Contact Number: " . htmlspecialchars($employee['contact_No']) . "</p>";
                echo "<p>Email: " . htmlspecialchars($employee['email']) . "</p>";
                echo "<p>Address: " . htmlspecialchars($employee['address']) . "</p>";
                echo "<p>Job Title: " . htmlspecialchars($employee['type_description']) . "</p>";
                
                if ($canEdit) {
                    echo "<div class='patient-actions'>";
                    echo "<a href='update_Employee.php?id=" . htmlspecialchars($employee['user_ID']) . "' class='btn update-btn'>Update</a>";
                    echo "<button onclick='confirmDelete(" . htmlspecialchars($employee['user_ID']) . ")' class='btn delete-btn'>Delete</button>";
                    echo "</div>"; // This ensures that 'patient-actions' div is properly closed within the if condition
                }
                echo "</div>";
}
?>
