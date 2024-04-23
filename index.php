
<?php
include 'login.php';

session_start();

if (isset($_SESSION["user_ID"])) {

    $smysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM Staff
            WHERE user_ID = {$_SESSION["user_ID"]}";

    $result = $mysqli ->query($sql);

    $user = $result ->fetch_assoc();
}

?>



</body>