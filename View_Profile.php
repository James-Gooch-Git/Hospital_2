<?php
session_start();
include 'functions.php'; 

// Check if the user is logged in and has a user ID set
if (!isset($_SESSION['user_ID'])) {
    header("Location: login.php");
    exit;
}

$user = getUserDetails($_SESSION['user_ID']);
if (!$user) {
    header("Location: login.php");
    exit;
}



//$canEdit = isset($_SESSION["type_ID"]) && in_array($_SESSION["type_ID"], [1]);
$canEdit = true;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure your CSS file is linked here -->
    <script src="JSFunctions.js" defer></script>
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="content">
        <div id="profile-box" class="profile-box">
            <h2>User Profile</h2>
            <form id="editForm">
                <div>
                    <label>First Name:</label>
                    <span id="fName-text"><?= htmlspecialchars($user['fName']) ?></span>
                    <input type="text" name="fName" id="fName-input" value="<?= htmlspecialchars($user['fName']) ?>" style="display:none;">
                </div>
                <div>
                    <label>Last Name:</label>
                    <span id="lName-text"><?= htmlspecialchars($user['lName']) ?></span>
                    <input type="text" name="lName" id="lName-input" value="<?= htmlspecialchars($user['lName']) ?>" style="display:none;">
                </div>
                <div>
                    <label>Email:</label>
                    <span><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div>
                    <label>Contact Number:</label>
                    <span id="contact-text"><?= htmlspecialchars($user['contact_No']) ?></span>
                    <input type="text" name="contact_No" id="contact-input" value="<?= htmlspecialchars($user['contact_No']) ?>" style="display:none;">
                </div>
                <div>
                    <label>Address:</label>
                    <span id="address-text"><?= htmlspecialchars($user['address']) ?></span>
                    <input type="text" name="address" id="address-input" value="<?= htmlspecialchars($user['address']) ?>" style="display:none;">
                </div>
                <button type="button" onclick="toggleEditU()">Edit</button>
                <button type="button" onclick="saveEditU()">Save</button>
                <button type="button" onclick="cancelEditU()">Cancel</button>
            </form>

        </div>
    </main>
</div>


</body>
</html>
