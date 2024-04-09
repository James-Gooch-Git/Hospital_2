<?php
// Include the database connection file
require __DIR__ . "/database.php";

// Initialize variables to hold form data
$date = $user_id = $time_slot_id = "";
$staffMembers = $timeSlots = [];

// Process the form submission based on the stage of booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Stage 1: Date selection
    if (isset($_POST['date'])) {
        $date = $_POST['date'];

        // Fetch staff members
        $sql = "SELECT user_ID, fName FROM Staff";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->execute();
            $result = $stmt->get_result();
            $staffMembers = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        }
    }

    // Stage 2: Staff member selection (user_ID)
    if (isset($_POST['user_ID'])) {
        $user_id = $_POST['user_ID'];
        $date = $_POST['date']; // Make sure to pass the previously selected date forward

        // Fetch available time slots for the selected staff member and date
        $sql = "SELECT ts.time_slot_ID, ts.hour_block, IFNULL(a.is_available, 1) AS is_available
                FROM TimeSlot ts
                LEFT JOIN Availability a ON ts.time_slot_ID = a.time_slot_id AND a.date = ?
                WHERE (a.user_id = ? OR a.user_id IS NULL) AND a.date = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sis', $date, $user_id, $date);
            $stmt->execute();
            $result = $stmt->get_result();
            $timeSlots = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        }
    }

    // Stage 3: Time slot selection (Final booking step)
    // This step would typically involve inserting or updating a booking record in your database
    if (isset($_POST['time_slot_id'])) {
        $time_slot_id = $_POST['time_slot_id'];
        $date = $_POST['date'];
        $user_id = $_POST['user_id'];

        // Insert or update booking record in database
        // Example SQL (adjust according to your database schema)
        /*
        $sql = "INSERT INTO Bookings (user_id, time_slot_id, date) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('iis', $user_id, $time_slot_id, $date);
            if ($stmt->execute()) {
                // Success! Redirect or inform the user
                echo "Booking successful!";
            } else {
                // Handle error
                echo "Error: " . $mysqli->error;
            }
            $stmt->close();
        }
        */
    }
}

// Redirect or render the form again with updated data based on the booking stage
// For simplicity, this example assumes the form and logic are on the same page
?>
