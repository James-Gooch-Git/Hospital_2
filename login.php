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
            echo "Type ID: " . $_SESSION["type_ID"];

            session_regenerate_id();

            $_SESSION["user_ID"] = $user["user_ID"];
            $_SESSION["type_ID"] = $user["type_ID"]; 

            header("Location: View_Patient.php");
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
                    
                        <!-- <h1>Log in</h1> -->
                        
                        <form method="post">
                            <div class = login-details>

                            <div class="loginsign"> Log in</div>

                                <div class="login-email">
                                    <label class="loginlabel" for="email">Email</label>
                                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                                </div>

                                <div class="form-group">
                                    <label class="loginlabel" for="password">Password</label>
                                    <input type="password" name="password" id="password">
                                </div>
                    
                    
                                <button class="btn"> Log in </button>
                                <hr class="horizontal-line"></div>
                                
                                <div>
                                    <center><a href="SignUpHTML.html" class="btn">Sign Up</a></center>
                                </div>
                            </div>  
                        </form>

                        
                       
                        <div class = "loginform">          
                            
                            </div>
                      
                            <?php if ($is_invalid): ?>
                                <em>Invalid login</em>
                                <?php endif; ?>
                       
                            </div>
                       
                   
                </div>

        </div>
    </div>   
    
</body>