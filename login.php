<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT* FROM Staff
            WHERE email = '%s'", 
            $mysqli ->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();

            session_regenerate_id();

            $_SESSION["user_ID"] = $user["user_ID"];

            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log in</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class = "login-page">
        <div class ="login-container">

                <div class="login-box">
                    <div class="split-view">
                        <h1>Log in</h1>
                        <?php if ($is_invalid): ?>
                            <em>Invalid login</em>
                            <?php endif; ?>

                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password">
                            </div>
                        
                            <button> Log in </button>

                            
                        </form>
                        <div class="vertical-line"></div>

                        <div>
                            <a href="SignUpHTML.html" class="btn signup-btn">Sign Up</a>
                        </div>
                    </div>
                </div>

        </div>
    </div>   
    
</body>