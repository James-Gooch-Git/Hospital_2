<?php
$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_ID'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $contact_No = $_POST['contact_No'];
    $email = $_POST['email']; 
    $address = $_POST['address'];

    $stmt = $mysqli->prepare("UPDATE Staff SET fName = ?, lName = ?, contact_No = ?, email = ?, address = ? WHERE user_ID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    $stmt->bind_param('sssssi', $fName, $lName, $contact_No, $email, $address, $userId);
    if ($stmt->execute()) {
        
        header('Location: view_Employee.php');
         
    } else {
        // Log error to browser console
        echo "<script>console.error('Error updating record:', " . json_encode($stmt->error) . ");</script>";
    
        // Additionally, for debugging, log the parameters to the console
        echo "<script>console.log('Parameters:', " . json_encode([$fName, $lName, $contact_No, $email, $address, $userId]) . ");</script>";
    }
    $stmt->close();
    
}
?>
