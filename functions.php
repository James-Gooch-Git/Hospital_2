<?php

function getStaff() {
    // Database connection parameters
    $host = "127.0.0.1";
    $port = 3306;
    $dbname = "mydb";
    $username = "root";
    $password = "Javg070796!?";
    
    // Combine host and port into a single string
    $hostWithPort = $host . ":" . $port;
    
    $conn= new mysqli($hostWithPort, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch all records from employees table
    $sql = "SELECT Staff.*, Staff_Type.type_description 
    FROM Staff
    INNER JOIN Staff_Type ON Staff.type_ID = Staff_Type.type_ID";

    // Execute query
    $result = $conn->query($sql);

    $arrayResult = array();

    // Check if records exist
    if ($result->num_rows > 0) {
        // Fetch data row by row
        while ($row = $result->fetch_assoc()) {
            // Add each row to the result array
            $arrayResult[] = $row;
        }
    }

    // Close connection
    $conn->close();

    // Return the result array
    return $arrayResult;
}

function getPatients() {
    // Database connection parameters
    $host = "127.0.0.1";
    $port = 3306;
    $dbname = "mydb";
    $username = "root";
    $password = "Javg070796!?";
    
    // Combine host and port into a single string
    $hostWithPort = $host . ":" . $port;
    
    $conn= new mysqli($hostWithPort, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch all records from employees table
    $sql = "SELECT * FROM Patient";

    // Execute query
    $result = $conn->query($sql);

    $arrayResult = array();

    // Check if records exist
    if ($result->num_rows > 0) {
        // Fetch data row by row
        while ($row = $result->fetch_assoc()) {
            // Add each row to the result array
            $arrayResult[] = $row;
        }
    }

    // Close connection
    $conn->close();

    // Return the result array
    return $arrayResult;
}

function getAvailability() {
    // Database connection parameters
    $host = "127.0.0.1";
    $port = 3306;
    $dbname = "mydb";
    $username = "root";
    $password = "Javg070796!?";
    
    // Combine host and port into a single string
    $hostWithPort = $host . ":" . $port;
    
    $conn= new mysqli($hostWithPort, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch all records from employees table
    $sql = "SELECT Availability.*, 
                Staff.fName AS consultantName, 
                TimeSlot.hour_block AS timeSlotHourBlock
            FROM Availability
            JOIN Staff ON Availability.user_ID = Staff.user_ID
            JOIN TimeSlot ON Availability.time_slot_ID = TimeSlot.time_slot_ID
            ";

    // Execute query
    $result = $conn->query($sql);

    $arrayResult = array();

    // Check if records exist
    if ($result->num_rows > 0) {
        // Fetch data row by row
        while ($row = $result->fetch_assoc()) {
            // Add each row to the result array
            $arrayResult[] = $row;
        }
    }

    // Close connection
    $conn->close();

    // Return the result array
    return $arrayResult;
}
