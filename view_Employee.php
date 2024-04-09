
<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure your CSS file is linked here -->
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="content">
        <?php
        $employees = getStaff();
        foreach ($employees as $employee) {
            echo "<div class='employee-box'>";
            echo "<p>First Name:" . htmlspecialchars($employee['fName']) . "</p>";
            echo "<p>Last Name: " . htmlspecialchars($employee['lName']) . "</p>";
            echo "<p>Contact Number: " . htmlspecialchars($employee['contact_NO']) . "</p>";
            echo "<p>Email: " . htmlspecialchars($employee['email']) . "</p>";
            echo "<p>Address: " . htmlspecialchars($employee['address']) . "</p>";
            echo "<p>Job Title: " . htmlspecialchars($employee['type_description']) . "</p>";
            echo "<div class='employee-actions'>";
            echo "<a href='update_Employee.php?id=" . htmlspecialchars($employee['id']) . "' class='btn update-btn'>Update</a>";
            echo "<button onclick='confirmDelete(" . htmlspecialchars($employee['id']) . ")' class='btn delete-btn'>Delete</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </main>
</div>

</body>
</html>
