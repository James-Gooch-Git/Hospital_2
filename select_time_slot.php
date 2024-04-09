<?php
// Include the database connection file
$mysqli = require __DIR__ . "/database.php";

$date = $_POST['date'];
$user_id = $_POST['user_ID'];

// Adjust your SQL to match the TimeSlot table structure
// Assuming hour_block contains the time range as a string
$sql = "SELECT ts.time_slot_ID, ts.hour_block, IFNULL(a.is_available, 1) AS is_available
        FROM TimeSlot ts
        LEFT JOIN Availability a ON ts.time_slot_ID = a.time_slot_id AND a.date = ?
        WHERE a.user_id = ? OR a.user_id IS NULL";

// Prepare and execute the statement
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    // Error handling: Prepare failed
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}
$stmt->bind_param('si', $date, $user_id); // 's' for string (date), 'i' for integer (user_id)
$stmt->execute();
$result = $stmt->get_result();
$timeSlots = $result->fetch_all(MYSQLI_ASSOC);

include_once 'functions.php';
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
   
    
       
   

    
    <main class="content">
         <?php include_once 'list_bookings.php'; ?>
    </main>
  
    <aside class="sidebar sidebar-right">
        <form action="book.php" method="post">
            <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <label for="time_slot_id">Select a time slot:</label>
            <select id="time_slot_id" name="time_slot_id">
                <?php foreach ($timeSlots as $slot): ?>
                    <option value="<?php echo htmlspecialchars($slot['time_slot_ID']); ?>"
                            <?php echo (!$slot['is_available']) ? 'disabled' : ''; ?>>
                        <?php echo htmlspecialchars($slot['hour_block']) . (!$slot['is_available'] ? ' (Not Available)' : ' (Available)'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Book Time Slot">
        </form>
    </aside>
       
    <script>
    function showStaffDropdown() {
        // Display the staff dropdown when a date is selected
        var date = document.getElementById('date').value;
        if (date) {
            document.getElementById('staffSelection').style.display = 'block';
        }
    }

    function showTimeSlotDropdown() {
        // Display the time slot dropdown when a staff member is selected
        var staff = document.getElementById('staff').value;
        if (staff) {
            document.getElementById('timeSlotSelection').style.display = 'block';
        }
    }
    </script>
       
    </main>
    </aside>

</div>

</body>
</html>
