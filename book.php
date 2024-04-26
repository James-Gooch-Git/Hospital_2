<?php

$mysqli = require __DIR__ . "/database.php";


$date = $_POST['date'];
$user_id = $_POST['user_id'];
$time_slot_id = $_POST['time_slot_id'];

$sql = "INSERT INTO Availability (date, user_id, time_slot_id, is_available) VALUES (?, ?, ?, 0)
        ON DUPLICATE KEY UPDATE is_available = 0";

$stmt = $mysqli->prepare($sql);


$stmt->bind_param('sii', $date, $user_id, $time_slot_id);


if ($stmt->execute()) {
    $_SESSION['success_message'] = "Booking successfully recorded.";
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();


?>


<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="style.css">
    <script src="JSFunctions.js" defer></script>
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
   
    <main class="content">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<p>" . $_SESSION['success_message'] . "</p>";
         
            unset($_SESSION['success_message']);
        }
        ?>
        </aside>
        <?php include 'list_bookings.php'; ?>
        <aside class="sidebar sidebar-right">
     
       
    </main>

    <?php include 'make_Booking.php'; ?>
    
   
</div>


</body>
</html>

