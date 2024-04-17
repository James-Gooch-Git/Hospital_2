<?php
// Include database configuration and open connection
include_once 'functions.php';
$mysqli = require __DIR__ . "/database.php";

// Enable error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation and processing logic
    if (empty($_POST["patient_fName"])) {
        die("First Name is required");
    }

    if (empty($_POST["patient_lName"])) {
        die("Last Name is required");
    }

    if (!filter_var($_POST["patient_Email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }

    if (empty($_POST["patient_address"])) {
        die("Address is required");
    }

    $sql = "INSERT INTO Patient (patient_fName, patient_lName, patient_ContactNO, patient_Email, patient_address)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sssss",
                      $_POST["patient_fName"],
                      $_POST["patient_lName"],
                      $_POST["patient_ContactNO"],
                      $_POST["patient_Email"],
                      $_POST["patient_address"]);

    try {
        if ($stmt->execute()) {
            header("Location: View_Patient.php");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        die("An error occurred: " . $e->getMessage());
    } finally {
        $stmt->close(); // Ensure the statement is closed even if an exception occurs
    }

    
}

// Close statement and connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/SignUp/JS/validation.js" defer></script>
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <main class="content">
            <h1>Add Patient</h1>
            <form action="Add_Patient.php" method="post" id="addpatient" novalidate class="form">
                <div class="form-group">
                    <label for="patient_fName">First Name</label>
                    <input type="text" id="patient_fName" name="patient_fName" class="form-control">
                </div>
                <div class="form-group">
                    <label for="patient_lName">Last Name</label>
                    <input type="text" id="patient_lName" name="patient_lName" class="form-control">
                </div>
                <div class="form-group">
                    <label for="patient_ContactNO">Contact Number</label>
                    <input type="tel" id="patient_ContactNO" name="patient_ContactNO" class="form-control">
                </div>
                <div class="form-group">
                    <label for="patient_Email">Email</label>
                    <input type="email" id="patient_Email" name="patient_Email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="patient_address">Address</label>
                    <input type="text" id="patient_address" name="patient_address" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Submit</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
