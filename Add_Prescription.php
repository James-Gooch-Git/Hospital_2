<?php
include 'functions.php';
$mysqli = require __DIR__ . "/database.php";

$patientID = $_GET['patient_ID'];

if (isset($_GET['patient_ID'])) {
    $selectedPatientID = $_GET['patient_ID'];
} elseif (isset($_POST['patient_ID'])) {
    $selectedPatientID = $_POST['patient_ID'];
} else {

    header("Location: error.php");
    exit;
}


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function fetchAll($mysqli, $query) {
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close(); 
    return $data;
}

$users = fetchAll($mysqli, "SELECT user_ID, CONCAT(fName, ' ', lName) AS fullName FROM Staff ORDER BY fName");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedPatientID = $_POST['patient_ID'] ?? null;
    if (empty($selectedPatientID)) {
        die('Patient ID is required.');
    }
    if (empty($_POST["medication_name"])) {
        die("Medication name is required");
    }
    if (empty($_POST["cost"])) {
        die("Cost is required");
    }
    if (empty($_POST["date_prescribed"])) {
        die("Date prescribed is required");
    }

    $sql = "INSERT INTO Prescription (medication_name, cost, date_prescribed, user_ID, patient_ID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sdssi", $_POST["medication_name"], $_POST["cost"], $_POST["date_prescribed"], $_POST["user_ID"], $_POST["patient_ID"]);
    $url = $selectedPatientID;
    try {
        $stmt->execute();
        header("Location: View_Prescription.php?patient_ID=" . urlencode($selectedPatientID));
        exit;
    } catch (mysqli_sql_exception $e) {
        die("An error occurred: " . $e->getMessage());
    } finally {
        $stmt->close();
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Prescription</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <main class="content">
            <h1>Add Prescription</h1>
            <form action="Add_Prescription.php" method="post" id="addprescription" novalidate class="form">
                <input type="hidden" name="patient_ID" value="<?= htmlspecialchars($selectedPatientID) ?>">
                <div class="form-group">
                    <label for="medication_name">Medication Name</label>
                    <input type="text" id="medication_name" name="medication_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" step="0.01" id="cost" name="cost" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date_prescribed">Date Prescribed</label>
                    <input type="date" id="date_prescribed" name="date_prescribed" class="form-control">
                </div>
                <div class="form-group">
                    <label for="user_ID">Prescriber</label>
                    <select id="user_ID" name="user_ID" class="form-control">
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['user_ID']) ?>"><?= htmlspecialchars($user['fullName']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Submit</button>
                    <a href="View_Prescription.php?patient_ID=<?= htmlspecialchars($patientID) ?>" class="btn">Back to Patients Prescriptions</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
