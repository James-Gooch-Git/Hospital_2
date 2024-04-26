<?php
session_start();
include_once 'functions.php';


$mysqli = require __DIR__ . "/database.php";

$patientId = $_GET['patient_ID'] ?? null;
if ($patientId === null) {
    echo "No patient selected.";
    exit;
}

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT 
            Prescription.prescription_Id, 
            Prescription.medication_name, 
            Prescription.cost,
            Prescription.date_prescribed,
            CONCAT(Patient.patient_fName, ' ', Patient.patient_lName) AS patientName, 
            CONCAT(Staff.fName, ' ', Staff.lName) AS staffName
          FROM 
            Prescription 
          JOIN 
            Patient ON Prescription.patient_ID = Patient.patient_ID
          JOIN 
            Staff ON Prescription.user_ID = Staff.user_ID
          WHERE 
            Prescription.patient_ID = ?";

$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die('MySQL prepare error: ' . $mysqli->error);
}

$stmt->bind_param('i', $patientId); // 'i' for integer
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescriptions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<?php include 'sidebar.php'; ?>
    <main class="content">
        <?php
       if ($_SESSION['type_ID'] == 1 || $_SESSION['type_ID'] == 2) {
            echo "<a href='Add_Prescription.php?patient_ID=" . htmlspecialchars($patientId) . "' class='btn'>Add New Prescription</a>";
        }
        ?>
        <a href="view_Patient.php" class="btn">Back to Patients</a>

        <div id="prescriptionList">
            <?php
            if ($result->num_rows > 0) {
                while ($prescription = $result->fetch_assoc()) {
                    echo "<div class='prescription-box'>";
                    echo "<p>Prescription ID: " . htmlspecialchars($prescription['prescription_Id']) . "</p>";
                    echo "<p>Medication Name (Dose): " . htmlspecialchars($prescription['medication_name']) . "</p>";
                    echo "<p>Cost: " . htmlspecialchars($prescription['cost']) . "</p>";
                    echo "<p>Date Prescribed: " . htmlspecialchars($prescription['date_prescribed']) . "</p>";
                    echo "<p>Patient Name: " . htmlspecialchars($prescription['patientName']) . "</p>";
                    echo "<p>Staff Name: " . htmlspecialchars($prescription['staffName']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<div class='no-data'>No prescriptions found.</div>";
            }
            ?>
        </div>
    </main>
</div>

</body>
</html>

<?php
$stmt->close();
$mysqli->close();
?>
