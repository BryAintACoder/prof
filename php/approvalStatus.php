<?php 
// Get the email of the currently logged-in tutor user from the session
$email = $_SESSION['auth_tutor']['tutor_email'];

// Fetch the row from the tutor table for the current tutor user
$query = "SELECT * FROM `tutor` WHERE `email` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query was successful
if ($result && $result->num_rows > 0) {
    // Output the data
    $row = $result->fetch_assoc();
    $approvalStatus = $row['approvalStatus'];

    // Display status based on approval status
    if ($approvalStatus == 'Pending') {
        $status_message = "Thank you for your registration. Please wait 1-2 days for the approval status.";
    } elseif ($approvalStatus == 'Approved') {
        header("Location: t-dashboard.php");
        exit();
    } elseif ($approvalStatus == 'Declined') {
        $status_message = "Sorry, your application was declined.";
    } else {
        $status_message = "Unknown approval status";
    }
} else {
    $status_message = "No records found for the logged-in user.";
}
// Close database connection
mysqli_close($conn);

?>