<?php

require __DIR__ . "/database.php";

$date = $user_id = $time_slot_id = "";
$staffMembers = $timeSlots = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (isset($_POST['date'])) {
        $date = $_POST['date'];

     
        $sql = "SELECT user_ID, fName FROM Staff";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->execute();
            $result = $stmt->get_result();
            $staffMembers = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        }
    }

   
    if (isset($_POST['user_ID'])) {
        $user_id = $_POST['user_ID'];
        $date = $_POST['date'];
        

       
        $sql = "SELECT ts.time_slot_ID, ts.hour_block, IFNULL(a.is_available, 1) AS is_available
                FROM TimeSlot ts
                LEFT JOIN Availability a ON ts.time_slot_ID = a.time_slot_id AND a.date = ?
                WHERE (a.user_id = ? OR a.user_id IS NULL) AND a.date = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sis', $date, $user_id, $date);
            $stmt->execute();
            $result = $stmt->get_result();
            $timeSlots = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        }
    }


    if (isset($_POST['time_slot_id'])) {
        $time_slot_id = $_POST['time_slot_id'];
        $date = $_POST['date'];
        $user_id = $_POST['user_id'];

  
    }
}


?>
