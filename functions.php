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

function getDiagnosisForPatient($patientID) {
    // Include the database connection file
    $mysqli = require __DIR__ . '/database.php'; // Adjust the path as needed

    // SQL query to fetch all diagnosis details for a given patient
    $query = "SELECT 
                Diagnosis.diagnosis_ID,
                Diagnosis.diagnosis_name,
                CONCAT(Patient.patient_fName, ' ', Patient.patient_lName) AS patientName,
                CONCAT(Staff.fName, ' ', Staff.lName) AS staffName
              FROM 
                Diagnosis
              JOIN 
                Patient ON Diagnosis.patient_ID = Patient.patient_ID
              JOIN 
                Staff ON Diagnosis.user_ID = Staff.user_ID
              WHERE 
                Diagnosis.patient_ID = ?";

    // Prepare the SQL statement
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    // Bind the patient ID to the query
    $stmt->bind_param('i', $patientID);

    // Execute the query
    $stmt->execute();

    // Get the result set from the prepared statement
    $result = $stmt->get_result();
    if ($result === false) {
        die('Execute failed: ' . $mysqli->error);
    }

    // Fetch all rows as an associative array
    $diagnoses = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();

    // Close the database connection
    $mysqli->close();

    return $diagnoses;
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




function getPrescriptionsForPatient($patientID) {
    $mysqli = require __DIR__ . '/database.php'; // Adjust the path as needed
    $query = "SELECT 
                Prescription.prescription_Id,
                Prescription.medication_name,
                Prescription.cost,
                Prescription.date_prescribed,
                CONCAT(Patient.patient_fName, ' ', Patient.patient_lName) AS patientName,
                CONCAT(Staff.fName, ' ', Staff.lName) AS staffName
              FROM 
                Prescription
              JOIN 
                Patient ON Prescription.patient_ID = Patient.patient_ID
              JOIN 
                Staff ON Prescription.user_ID = Staff.user_ID
              WHERE 
                Prescription.patient_ID = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die('MySQL prepare error: ' . $mysqli->error);
    }

    $stmt->bind_param('i', $patientID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        die('Execute failed: ' . $mysqli->error);
    }

    $prescriptions = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $mysqli->close();

    return $prescriptions;
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

function getUserDetails($userID) {
    $mysqli = require __DIR__ . '/database.php';  // Adjust the path if necessary

    $query = "SELECT fName, lName, email, contact_No, email, address FROM Staff WHERE user_ID = ?";
    
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die('MySQL prepare error: ' . $mysqli->error);
    }

    $stmt->bind_param('i', $userID);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        return null;  // No user found
    }

    $userDetails = $result->fetch_assoc();

    $stmt->close();
    $mysqli->close();

    return $userDetails;
}


// function getPatientDetails($patientID) {
//     // Database connection parameters
//     $host = "127.0.0.1";
//     $port = 3306;
//     $dbname = "mydb";
//     $username = "root";
//     $password = "Javg070796!?";
    
//     // Combine host and port into a single string
//     $hostWithPort = $host . ":" . $port;
    
//     $conn= new mysqli($hostWithPort, $username, $password, $dbname);
    
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     // SQL query to fetch all records from employees table
//     $sql = "SELECT * FROM Patient WHERE patient_ID = ?";

//     // Execute query
//     $result = $conn->query($sql);

//     $arrayResult = array();

//     // Check if records exist
//     if ($result->num_rows > 0) {
//         // Fetch data row by row
//         while ($row = $result->fetch_assoc()) {
//             // Add each row to the result array
//             $arrayResult[] = $row;
//         }
//     }

//     // Close connection
//     $conn->close();

//     // Return the result array
//     return $arrayResult;
// }




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