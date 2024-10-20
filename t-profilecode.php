<?php
session_start();
include('connection/dbconfig.php');

// Check if the form was submitted
if (isset($_POST['updateProfile'])) {
    // Retrieve form data
    $tutorID = $_SESSION['auth_tutor']['tutor_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $teachingMode = $_POST['teachingMode'];
    $ratePerHour = $_POST['ratePerHour'];
    $bio = $_POST['bio'];

    // Check if a new profile picture is uploaded
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === 0) {
        $profilePicture = $_FILES['profilePicture'];
        
        // Validate image file type (allow only jpeg and png)
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (in_array($profilePicture['type'], $allowedTypes)) {
            // Upload directory
            $uploadDir = 'img/';
            $profilePictureName = 'profile_' . time() . '_' . basename($profilePicture['name']);
            $uploadPath = $uploadDir . $profilePictureName;
            
            // Move the uploaded file to the desired directory
            if (move_uploaded_file($profilePicture['tmp_name'], $uploadPath)) {
                // Update the database with the new profile picture
                $updateQuery = "UPDATE tutor SET firstName = ?, lastName = ?, teachingMode = ?, ratePerHour = ?, bio = ?, profilePicture = ? WHERE tutorID = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("ssssssi", $firstName, $lastName, $teachingMode, $ratePerHour, $bio, $profilePictureName, $tutorID);
                $stmt->execute();
                $stmt->close();
                $_SESSION['auth_tutor']['profile_picture'] = $profilePictureName;  // Update session data
                $_SESSION['success'] = "Profile updated successfully.";
            } else {
                $_SESSION['error'] = "Failed to upload profile picture.";
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Only JPEG and PNG are allowed.";
        }
    } else {
        // No profile picture uploaded, update other fields
        $updateQuery = "UPDATE tutor SET firstName = ?, lastName = ?, teachingMode = ?, ratePerHour = ?, bio = ? WHERE tutorID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssssi", $firstName, $lastName, $teachingMode, $ratePerHour, $bio, $tutorID);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success'] = "Profile updated successfully.";
    }

    // Redirect back to the profile edit page
    header("Location: t-profile.php");
    exit();
} else {
    // If the form was not submitted properly, redirect back
    $_SESSION['error'] = "Please fill out the form properly.";
    header("Location: t-profile.php");
    exit();
}
