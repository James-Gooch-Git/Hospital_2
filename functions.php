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

function getTypeID() {
    // Database connection parameters
    $mysqli = require __DIR__ . "/database.php";
    // SQL query to fetch all records from employees table
    $sql = "SELECT type_ID FROM Patient";

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

function getPatientsDropdown() {
    $mysqli = require __DIR__ . "/database.php";

    // Prepare a query to select patient ID and name from the Patients table
    $sql = "SELECT patient_ID, patient_fName, patient_lName FROM Patient ORDER BY patient_ID";
    $result = $mysqli->query($sql);

    if ($result === false) {
        // Error handling if the query fails
        die('Error fetching patients: ' . $mysqli->error);
    }

    // Fetch all results as an associative array
    $patients = $result->fetch_all(MYSQLI_ASSOC);

    // Free result and return patients array
    $result->free();
    return $patients;
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
                CONCAT(Staff.fName, ' ', Staff.lName) AS consultantName, 
                TimeSlot.hour_block AS timeSlotHourBlock,
                CASE 
                    WHEN Patient.patient_ID IS NOT NULL THEN CONCAT('Patient ID: ', Patient.patient_ID)
                    ELSE 'No Patient Assigned'
                END AS patientId,
                CASE 
                    WHEN Patient.patient_fName IS NOT NULL THEN CONCAT('Patient Name: ', Patient.patient_fName, ' ', Patient.patient_lName)
                    
                END AS patientName
            FROM Availability
            JOIN Staff ON Availability.user_ID = Staff.user_ID
            JOIN TimeSlot ON Availability.time_slot_ID = TimeSlot.time_slot_ID
            LEFT JOIN Patient ON Availability.patient_ID = Patient.patient_ID";

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

function getDiagnosis() {
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
    $sql = "SELECT 
                Diagnosis.diagnosis_ID,
                Diagnosis.diagnosis_name,
                CONCAT(Staff.fName, ' ', Staff.lName) AS staffName,
                CONCAT(Patient.patient_fName, ' ', Patient.patient_lName) AS patientName
            FROM 
                Diagnosis
            JOIN 
                Staff ON Diagnosis.user_ID = Staff.user_ID
            LEFT JOIN 
                Patient ON Diagnosis.patient_ID = Patient.patient_ID;
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