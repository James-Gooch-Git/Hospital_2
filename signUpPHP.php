<?php



if (empty($_POST["fName"])) 
{
    die("First Name is required");
}

if (empty($_POST["lName"])) 
{
    die("Last Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
{
    die("Valid email is required");
}

if (empty($_POST["type_ID"])) 
{
    die("Job Title is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO Staff (fName, lName, contact_No, email, password_hash, address, type_ID)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)){
    die("SQL error: " . $mysqli->error);
} 

$type_ID = (int) $_POST['type_ID'];

$stmt ->bind_param("ssssssi",
                   $_POST["fName"],
                   $_POST["lName"],
                   $_POST["contact_No"],
                   $_POST["email"],
                   $password_hash,
                   $_POST["address"],
                   $type_ID);

try {
    if ($stmt->execute()) {
        echo "<script>
        alert('Signup successful');
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 2000); // Redirect after 2 seconds
      </script>";
       exit;
    } else {
        // This else block might not be necessary if exceptions are thrown for errors,
        // but it's here for completeness.
        echo "An error occurred. " . $stmt->error;
    }
} catch (mysqli_sql_exception $e) {
    // If the error code is 1062, handle the duplicate entry case.
    if ($e->getCode() === 1062) {
        die("Email already taken.");
    } else {
        // For all other SQL errors, print the error message and code.
        die("An error occurred: " . $e->getMessage() . " Error number: " . $e->getCode());
    }
}
