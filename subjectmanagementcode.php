<?php
session_start();

if (isset($_POST['submit'])) {
    // Include database connection
    include('connection/dbconfig.php');

    // Get form data
    $subjectName = $_POST['subjectName'];
    $category = $_POST['category'];
    $semester = $_POST['semester'];

    // Check if the subject name already exists
    $checkSql = "SELECT * FROM subjects WHERE subject_name = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $subjectName);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Subject name already exists, show error message
        $_SESSION['message'] = "Error: Subject name already exists";
    } else {
        // Subject name is unique, proceed with insertion
        // SQL query to insert subject into database
        $insertSql = "INSERT INTO subjects (subject_name, category, semester) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("sss", $subjectName, $category, $semester);

        // Execute the insertion statement
        if ($insertStmt->execute()) {
            $_SESSION['message'] = "Subject added successfully";
        } else {
            $_SESSION['message'] = "Error: Unable to add subject";
        }

        // Close insertion statement
        $insertStmt->close();
    }

    // Close check statement and connection
    $checkStmt->close();
    $conn->close();

    // Redirect back to the subject management page
    header("Location: subjectmanagement.php");
    exit();
}
?>