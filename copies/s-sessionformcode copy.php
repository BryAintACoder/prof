<?php
session_start();
include('connection/dbconfig.php');

// Check if the user is logged in
if (!isset($_SESSION['authentication'])) {
    // Redirect the user to the login page if not logged in
    header("Location: s-login.php");
    exit();
}

// Get current logged-in user data
$userID = $_SESSION['auth_user']['user_id']; // Assuming user_id is the ID of the user in the database

// Get tutor data from the URL parameter (you need to implement this)
$tutorID = $_POST['tutorID']; // Assuming you are passing the tutor ID as a parameter

// Get session form data
$sessionDate = $_POST['sessionDate'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$duration = $_POST['duration'];
$subject = $_POST['subject'];
$teachingMode = $_POST['teachingMode'];
$need = $_POST['need'];

// Insert session data into the session table
$query = "INSERT INTO session (tutorID, studentID, sessionDate, startTime, endTime, duration, subject, teachingMode, need, status) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iississsss", $tutorID, $userID, $sessionDate, $startTime, $endTime, $duration, $subject, $teachingMode, $need, $status);

// Set status to Pending by default
$status = "Pending";

// Execute the prepared statement
if ($stmt->execute()) {
    // Session added successfully
    $_SESSION['message'] = "Session requested successfully.";
    header("Location: s-index.php");
    exit();
} else {
    // Error in adding session
    $_SESSION['error'] = "Error in requesting session. Please try again.";
    header("Location: s-sessionform.php");
    exit();
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
