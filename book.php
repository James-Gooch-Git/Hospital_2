<?php
// Include the database connection file
$mysqli = require __DIR__ . "/database.php";

// Retrieve the form data
$date = $_POST['date'];
$user_id = $_POST['user_id'];
$time_slot_id = $_POST['time_slot_id'];

// Prepare a query to insert or update the booking in the Availability table
// This example assumes you want to mark the slot as not available (is_available = 0)
$sql = "INSERT INTO Availability (date, user_id, time_slot_id, is_available) VALUES (?, ?, ?, 0)
        ON DUPLICATE KEY UPDATE is_available = 0";

$stmt = $mysqli->prepare($sql);

// Bind the parameters to the query
$stmt->bind_param('sii', $date, $user_id, $time_slot_id);

// Execute the query
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Booking successfully recorded.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement
$stmt->close();

// Optionally, redirect the user to another page or show a confirmation
// header('Location: confirmation_page.php');
// exit;
?>


<?php include 'functions.php'; ?>
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
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<p>" . $_SESSION['success_message'] . "</p>";
            // Clear the message after displaying it to prevent it from showing again on refresh or navigation
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

