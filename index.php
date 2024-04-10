
<?php

session_start();

if (isset($_SESSION["user_ID"])) {

    $smysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM Staff
            WHERE user_ID = {$_SESSION["user_ID"]}";

    $result = $mysqli ->query($sql);

    $user = $result ->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class = "login-page">
    <div>
            <?php if (isset($user)): ?>
                <?php include 'sidebar.php'; ?>
                <p>Hello <?= htmlspecialchars($user["fName"]) ?></p>
                

            <?php else: ?>

                <a href="login.php" class="btn login-btn">Log in</a>
                <a href="SignUpHTML.html" class="btn signup-btn">Sign up</a>
                
            <?php endif; ?>  
    
        <main class="content">
    
        </main>

        
        
    
    </div>
</div>
  

</body>