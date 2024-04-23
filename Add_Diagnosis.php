<?php
include 'functions.php';
$mysqli = require __DIR__ . "/database.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Fetch users and patients for dropdowns
function fetchAll($mysqli, $query) {
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close(); // Ensure statement is closed here
    return $data;
}

$selectedPatientID = isset($_GET['patient_ID']) ? $_GET['patient_ID'] : header("Location: error.php"); // Redirect if ID not present

// Fetch users and patients for dropdowns
$users = fetchAll($mysqli, "SELECT user_ID, CONCAT(fName, ' ', lName) AS fullName FROM Staff ORDER BY fName");
$patients = fetchAll($mysqli, "SELECT patient_ID, CONCAT(patient_fName, ' ', patient_lName) AS fullName FROM Patient ORDER BY patient_fName");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedPatientID = $_POST['patient_ID'] ?? null;
    if (empty($selectedPatientID)) {
        die('Patient ID is required.');
    }
    if (empty($_POST["diagnosis_name"])) {
        die("Diagnosis name is required");
    }

    $sql = "INSERT INTO Diagnosis (diagnosis_name, user_ID, patient_ID) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sii", $_POST["diagnosis_name"], $_POST["user_ID"], $_POST["patient_ID"]);
    $url = $selectedPatientID;
    try {
        $stmt->execute();
        header("Location: View_Diagnosis.php?patient_ID=" . urlencode($selectedPatientID));
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
    <title>Add Diagnosis</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <main class="content">
            <h1>Add Diagnosis</h1>
            <form action="Add_Diagnosis.php" method="post" id="adddiagnosis" novalidate class="form">
                <input type="hidden" name="patient_ID" value="<?= htmlspecialchars($selectedPatientID) ?>">
                <div class="form-group">
                    <label for="diagnosis_name">Diagnosis Name</label>
                    <input type="text" id="diagnosis_name" name="diagnosis_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="user_ID">Assigned Staff</label>
                    <select id="user_ID" name="user_ID" class="form-control">
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['user_ID']) ?>"><?= htmlspecialchars($user['fullName']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Submit</button>
                    <a href="View_Diagnosis.php?patient_ID=<?= htmlspecialchars($patientID) ?>" class="btn">Back to Patient Diagnosis</a>
               
                </div>
            </form>
        </main>
    </div>
</body>
</html>