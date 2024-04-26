<?php

function getStaff() {
   
    $host = "127.0.0.1";
    $port = 3306;
    $dbname = "mydb";
    $username = "root";
    $password = "Javg070796!?";
    
   
    $hostWithPort = $host . ":" . $port;
    
    $conn= new mysqli($hostWithPort, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $sql = "SELECT Staff.*, Staff_Type.type_description 
    FROM Staff
    INNER JOIN Staff_Type ON Staff.type_ID = Staff_Type.type_ID";

  
    $result = $conn->query($sql);

    $arrayResult = array();

  
    if ($result->num_rows > 0) {
       
        while ($row = $result->fetch_assoc()) {
           
            $arrayResult[] = $row;
        }
    }

    $conn->close();

    
    return $arrayResult;
}

function getDiagnosisForPatient($patientID) {
  
    $mysqli = require __DIR__ . '/database.php'; 

    
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

  
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    
    $stmt->bind_param('i', $patientID);

   
    $stmt->execute();

   
    $result = $stmt->get_result();
    if ($result === false) {
        die('Execute failed: ' . $mysqli->error);
    }

    $diagnoses = $result->fetch_all(MYSQLI_ASSOC);

   
    $stmt->close();

  
    $mysqli->close();

    return $diagnoses;
}


function getTypeID() {
  
    $mysqli = require __DIR__ . "/database.php";
   
    $sql = "SELECT type_ID FROM Patient";

    
    $result = $conn->query($sql);

    $arrayResult = array();

  
    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
           
            $arrayResult[] = $row;
        }
    }

    $conn->close();

   
    return $arrayResult;
}




function getPrescriptionsForPatient($patientID) {
    $mysqli = require __DIR__ . '/database.php'; 
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

 
    $sql = "SELECT patient_ID, patient_fName, patient_lName FROM Patient ORDER BY patient_ID";
    $result = $mysqli->query($sql);

    if ($result === false) {
        
        die('Error fetching patients: ' . $mysqli->error);
    }

   
    $patients = $result->fetch_all(MYSQLI_ASSOC);

   
    $result->free();
    return $patients;
}


function getPatients() {
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

    $sql = "SELECT * FROM Patient";

    $result = $conn->query($sql);

    $arrayResult = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arrayResult[] = $row;
        }
    }

    $conn->close();

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







function getAvailability() {
    $host = "127.0.0.1";
    $port = 3306;
    $dbname = "mydb";
    $username = "root";
    $password = "Javg070796!?";
    

    $hostWithPort = $host . ":" . $port;
    
    $conn= new mysqli($hostWithPort, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

    $result = $conn->query($sql);

    $arrayResult = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arrayResult[] = $row;
        }
    }

    $conn->close();

    return $arrayResult;
}

function getDiagnosis() {
    $host = "127.0.0.1";
    $port = 3306;
    $dbname = "mydb";
    $username = "root";
    $password = "Javg070796!?";
    
    $hostWithPort = $host . ":" . $port;
    
    $conn= new mysqli($hostWithPort, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

    $result = $conn->query($sql);

    $arrayResult = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arrayResult[] = $row;
        }
    }

    $conn->close();

    return $arrayResult;
}