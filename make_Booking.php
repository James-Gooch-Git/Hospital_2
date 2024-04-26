
<?php

$mysqli = require __DIR__ . "/database.php";



$sql = "SELECT user_ID, fName FROM Staff";
$stmt = $mysqli->prepare($sql);

$stmt->execute();
$result = $stmt->get_result();
$staffMembers = $result->fetch_all(MYSQLI_ASSOC);

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="JSFunctions.js" defer></script>
</head>
<body>

<div class="container">
    <aside class="sidebar sidebar-right">
    <main class="content">
       
    <div id="bookingForm">
        <div id="dateSelection">
            <h1> Make a Booking </h1>
        <form action="select_user.php" method="post">
            <label for="date">Select a date:</label>
            <input type="date" class="bookingdate" id="date" name="date">
            <input type="submit" class = "btn" value="Choose Date">
        </form>
        </div>

        <div id="staffSelection" style="display: none;">
                <form action="booking.php" method="post">
                    <label for="staff">Select a staff member:</label>
                    <select id="staff" name="staff" onchange="showTimeSlotDropdown()">
                        <option value="">Please select a staff member</option>
                        <?php foreach ($staffMembers as $member): ?>
                        <option value="<?php echo htmlspecialchars($member['user_ID']); ?>">
                            <?php echo htmlspecialchars($member['fName']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
        </div>

        <div id="timeSlotSelection" style="display: none;">
            <label for="timeSlot">Select a time slot:</label>
            <select id="timeSlot" name="timeSlot">
                <option value="">Please select a time slot</option>
            </select>
        </div>
    </div>

    <script>
    function showStaffDropdown() {
        var date = document.getElementById('date').value;
        if (date) {
            document.getElementById('staffSelection').style.display = 'block';
        }
    }

    function showTimeSlotDropdown() {
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
