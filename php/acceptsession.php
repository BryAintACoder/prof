<?php
session_start();

include('../connection/dbconfig.php'); // Include your database connection file

// Check if the session ID is provided in the URL
if (isset($_GET['sessionID'])) {
    // Get the session ID from the URL
    $sessionID = $_GET['sessionID'];
    // Retrieve logged-in tutor's tutorID
    $tutorID = $_SESSION['auth_tutor']['tutor_id'];
    
    // Prepare and execute a query to update session status
    $sql = "UPDATE session SET status = 'Waiting for Payment' WHERE sessionID = ? AND tutorID = ?";
    if ($conn) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $sessionID, $tutorID);
        $stmt->execute();
        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            // Redirect to tutor's dashboard
            header("Location: ../t-dashboard.php");
            exit();
        } else {
            // Display an error message if the session ID is not found or does not belong to the tutor
            echo "Session not found or does not belong to you.";
        }
    } else {
        // Handle database connection errors
        echo "Failed to connect to the database.";
    }
} else {
    // Display an error message if the session ID is not provided in the URL
    echo "Session ID not provided.";
}
?>
