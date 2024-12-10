<?php
session_start();
include('../includes/dbconn.php');

// Redirect if the user is not logged in
if (!isset($_SESSION['emplogin']) || strlen($_SESSION['emplogin']) == 0) {
    header('location:../index.php');
    exit;
}

// Initialize messages to hold success and error feedback
$successMessage = '';
$errorMessage = '';

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through each item in the posted data to process transfer requests
    foreach ($_POST as $key => $facultyId) {
        if (strpos($key, 'faculty_') === 0) { // Only process fields starting with 'faculty_'
            // Extract the course code from the key (e.g., 'faculty_CET101' -> 'CET101')
            $courseCode = substr($key, 8);

            // Validate that both the facultyId and courseCode are present
            if (!empty($facultyId) && !empty($courseCode)) {
                try {
                    // Get the current employee ID from the session
                    $employeeId = $_SESSION['emplogin'];

                    // Insert the transfer request into the class_transfers table
                    $sql = "INSERT INTO class_transfers (employee_id, course_code, transfer_to_id, transfer_date, status) 
                            VALUES (:employeeId, :courseCode, :facultyId, NOW(), 'Pending')";
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_STR);
                    $stmt->bindParam(':courseCode', $courseCode, PDO::PARAM_STR);
                    $stmt->bindParam(':facultyId', $facultyId, PDO::PARAM_INT);

                    // Execute the query and check if successful
                    if ($stmt->execute()) {
                        $successMessage .= "Transfer request for course $courseCode has been submitted successfully.<br>";
                    } else {
                        $errorMessage .= "Failed to submit transfer request for course $courseCode.<br>";
                    }
                } catch (PDOException $e) {
                    // Log or show error if the database query fails
                    $errorMessage .= "Error processing transfer for course $courseCode: " . $e->getMessage() . "<br>";
                }
            } else {
                $errorMessage .= "Invalid data provided for course $courseCode.<br>";
            }
        }
    }
}

// Store messages in session variables to display on class-transfer.php
$_SESSION['successMessage'] = $successMessage;
$_SESSION['errorMessage'] = $errorMessage;

// Redirect back to class-transfer.php
header('location:class-transfer.php');
exit;
?>
