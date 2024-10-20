<?php
// Include database connection
include('connection/dbconfig.php');

// Check if delete form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteSubject'])) {
    // Get the subject ID from the form submission
    $subjectId = $_POST['subjectId'];

    // SQL query to delete subject from database
    $deleteSql = "DELETE FROM subjects WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $subjectId);

    // Execute the deletion statement
    if ($deleteStmt->execute()) {
        // Check if any rows were affected
        if ($deleteStmt->affected_rows > 0) {
            // Subject deleted successfully
            $_SESSION['message'] = "Subject deleted successfully";
        } else {
            // No rows were affected, meaning the subject was not found
            $_SESSION['message'] = "Error: Subject not found or already deleted";
        }
    } else {
        // Error occurred while executing the deletion statement
        $_SESSION['message'] = "Error: Unable to delete subject - " . $deleteStmt->error;
    }

    // Close deletion statement
    $deleteStmt->close();
}

// Close connection
$conn->close();

// Redirect back to subjectmanagement.php
header("Location: subjectmanagement.php");
exit();
?>
