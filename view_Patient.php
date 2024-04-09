
<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure your CSS file is linked here -->
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="content">
        <?php
        $patients = getPatients();
        foreach ($patients as $patient) {
            echo "<div class='patient-box'>";
            echo "<p>First Name:" . htmlspecialchars($patient['patient_fName']) . "</p>";
            echo "<p>Last Name: " . htmlspecialchars($patient['patient_lName']) . "</p>";
            echo "<p>Contact Number: " . htmlspecialchars($patient['patient_ContactNO']) . "</p>";
            echo "<p>Email: " . htmlspecialchars($patient['patient_Email']) . "</p>";
            echo "<p>Address: " . htmlspecialchars($patient['patient_address']) . "</p>";
       
            echo "<div class='patient-actions'>";
            echo "<a href='update_Patient.php?id=" . htmlspecialchars($patient['id']) . "' class='btn update-btn'>Update</a>";
            echo "<button onclick='confirmDelete(" . htmlspecialchars($patient['id']) . ")' class='btn delete-btn'>Delete</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </main>
</div>

</body>
</html>
