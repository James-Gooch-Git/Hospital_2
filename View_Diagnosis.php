<?php include 'functions.php'; 
// Assuming you're fetching patient details from the database
$patientID = $_GET['patient_ID'] ?? null; // Use the null coalescing operator to handle cases where `patient_ID` isn't in the URL

if (null === $patientID) {
    echo "No patient selected."; // Handle the case where no patient ID is provided
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure your CSS file is linked properly -->
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="content">
        <!-- Dynamic link for adding diagnosis, make sure $patientID is defined and fetched as shown above -->
        <a href="Add_Diagnosis.php?patient_ID=<?= htmlspecialchars($patientID) ?>" class="button">Add New Diagnosis</a>
        <?php include 'list_diagnosis.php'; ?>
    </main>
</div>

</body>
</html>
