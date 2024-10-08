
<?php

$mysqli = require __DIR__ . "/database.php";


$date = $_POST['date'];



include 'functions.php'; 
$staffMembers = GetStaff();
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
    <?php include 'sidebar.php'; ?>
    
    <main class="content">
        <?php include 'list_bookings.php'; ?>
    </main>
  
    <aside class="sidebar sidebar-right">
        <form action="select_time_slot.php" method="post" class="staff-selection-form">
            <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
            <label for="user_ID">Select a staff member:</label>
            <div class="form-controls">
                <select id="user_ID" name="user_ID">
                    <?php foreach ($staffMembers as $member): ?>
                        <?php if($member['type_ID'] != 1 && $member['type_ID'] != 4):  ?>
                            <option value="<?php echo htmlspecialchars($member['user_ID']); ?>">
                                <?php echo htmlspecialchars($member['type_description']) . " | Staff ID " . htmlspecialchars($member['user_ID']) . " | " . htmlspecialchars($member['fName']) . " " . htmlspecialchars($member['lName']) ; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Choose Staff Member" class="btn">
                <a href="View_Bookings.php" class="btn">Back</a>
            </div>
        </form>
    </aside>

    

       
    

    

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
