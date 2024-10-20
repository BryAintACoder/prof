<?php
session_start();
include('connection/dbconfig.php');

// Check if the user is logged in
if (!isset($_SESSION['authentication'])) {
    header("Location: s-login.php");
    exit();
}

// Retrieve studentID from the session
$studentID = $_SESSION['auth_user']['user_id'];

// Get session form data
$tutorID = $_POST['tutorID'];
$sessionDate = $_POST['sessionDate'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$duration = $_POST['duration'];
$subject = $_POST['subjectExpertise'];
$teachingMode = $_POST['teachingMode'];
$need = $_POST['need'];

// Check if the selected date is already booked for the tutor
$query = "SELECT * FROM session WHERE tutorID = ? AND sessionDate = ? AND startTime = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $tutorID, $sessionDate, $startTime);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Date is already booked - show alert and retain form data
    echo "<script>
            alert('The selected date and time are already booked. Please select another date or time.');
            window.history.back(); // Return to the previous form with the data retained
          </script>";
    exit();
}

// Insert session data into the session table
$query = "INSERT INTO session (tutorID, studentID, sessionDate, startTime, endTime, duration, subject, teachingMode, need, status) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iississsss", $tutorID, $studentID, $sessionDate, $startTime, $endTime, $duration, $subject, $teachingMode, $need, $status);

// Set status to Pending by default
$status = "Pending";

// Execute the prepared statement
if ($stmt->execute()) {
    // Session added successfully
    $_SESSION['message'] = "Session requested successfully.";
    header("Location: s-pending.php");
    exit();
}

//code not working

 else {
    // Error in adding session
    echo "<script>
            alert('Error in requesting session. Please try again.');
            window.history.back(); // Return to the previous form with the data retained
          </script>";
    exit();
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
