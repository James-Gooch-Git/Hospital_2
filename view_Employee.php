
<?php
session_start();
$updateStatus = isset($_GET['update']) && $_GET['update'] === 'success';





include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure your CSS file is linked here -->
    <script src="JSFunctions.js" defer></script>
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="content">
    <div class="search-container">
            <input type="text" id="searchEInput" placeholder="Search Employees..." onkeyup="searchStaff()">
    </div>

    <div id = "staffList">
        <?php
        $employees = getStaff();
        foreach ($employees as $employee) {
            echo "<form method='POST' action='update_employee.php' class='update-form' id='employeeForm_{$employee['user_ID']}'>";


            echo "<div class='employee-box' id='employeeBox_{$employee['user_ID']}'>";
            echo "<p>Employee Number: " . htmlspecialchars($employee['user_ID']) . "</p>";
            echo "<p>First Name:" . htmlspecialchars($employee['fName']) . "</p>";
            echo "<p>Last Name: " . htmlspecialchars($employee['lName']) . "</p>";
            echo "<p>Contact Number: " . htmlspecialchars($employee['contact_No']) . "</p>";
            echo "<p>Email: " . htmlspecialchars($employee['email']) . "</p>";
            echo "<p>Address: " . htmlspecialchars($employee['address']) . "</p>";
            echo "<p>Job Title: " . htmlspecialchars($employee['type_description']) . "</p>";
            echo "<div id='editFields_{$employee['user_ID']}' style='display:none;'>";
            echo "<input type='hidden' name='user_ID' value='" . htmlspecialchars($employee['user_ID']) . "'>";

            echo "<input type='text' name='fName' value='" . htmlspecialchars($employee['fName']) . "' >";
            echo "<input type='text' name='lName' value='" . htmlspecialchars($employee['lName']) . "' class='edit-input'>";
            echo "<input type='text' name='contact_No' value='" . htmlspecialchars($employee['contact_No']) . "' class='edit-input'>";
            echo "<input type='text' name='email' value='" . htmlspecialchars($employee['email']) . "' class='edit-input'>";
            echo "<input type='text' name='address' value='" . htmlspecialchars($employee['address']) . "' class='edit-input'>";
            echo "</div>";
            echo "<div class='employee-actions' id='actionButtons_{$employee['user_ID']}'>";
            
            if ($_SESSION['type_ID'] == 1) {
                
            echo "<a href='#' class='btn update-btn' onclick='enableEditE(" . $employee['user_ID'] . ")'>Edit</a>";
            echo "<button onclick='confirmDeleteE(" . $employee['user_ID'] . ")' class='btn delete-btn'>Delete</button>";
            
            }
            echo "</div>";
            echo "<div class='confirm-actions' style='display:none;' id='confirmButtons_{$employee['user_ID']}'>";
            
            echo "<button onclick='confirmEditE(" . $employee['user_ID'] . ")' class='btn confirm-btn'>Confirm</button>";
            echo "<button onclick='cancelEditE(" . $employee['user_ID'] . ")' class='btn cancel-btn'>Cancel</button>";
            echo "</div>";
            
            echo "</form>";
            
            echo "</div>";
    
        }
        ?>
    </div>
    </main>
</div>

</body>
</html>
