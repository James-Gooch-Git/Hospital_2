<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['user_ID'])) {
    echo "Error: User not logged in";  // Plain text error message
    exit;
}

$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_ID'];
    $fName = $_POST['fName'] ?? '';
    $lName = $_POST['lName'] ?? '';
    $contact_No = $_POST['contact_No'] ?? '';
    $address = $_POST['address'] ?? '';

    $stmt = $mysqli->prepare("UPDATE Staff SET fName = ?, lName = ?, contact_No = ?, address = ? WHERE user_ID = ?");
    if (!$stmt) {
        echo "Error: Prepare failed: " . $mysqli->error;  // Plain text error message
        exit;
    }

    $stmt->bind_param('ssssi', $fName, $lName, $contact_No, $address, $userId);
    if ($stmt->execute()) {
        echo "Success"; // Indicate success but do not redirect here
        $stmt->close();
        $mysqli->close();
    } else {
        echo "Error: Execute failed: " . $stmt->error;
    }
    $stmt->close();
    $mysqli->close();
}    
?>
