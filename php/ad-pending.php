<?php

include('connection/dbconfig.php');

if(isset($_POST['approve_btn'])) {
    // Handle approve action
    if(isset($_POST['tutorID'])) {
        $tutorID = $_POST['tutorID'];

        // Update approval status to "Approved"
        $update_query = "UPDATE tutor SET approvalStatus='Approved' WHERE tutorID='$tutorID'";
        $update_result = mysqli_query($conn, $update_query);

        if($update_result) {
            $_SESSION['message'] = "Tutor approved successfully";
        } else {
            $_SESSION['message'] = "Failed to approve tutor";
        }
    }
}

if(isset($_POST['decline_btn'])) {
    // Handle decline action
    if(isset($_POST['tutorID'])) {
        $tutorID = $_POST['tutorID'];

        // Update approval status to "Declined"
        $update_query = "UPDATE tutor SET approvalStatus='Declined' WHERE tutorID='$tutorID'";
        $update_result = mysqli_query($conn, $update_query);

        if($update_result) {
            $_SESSION['message'] = "Tutor declined successfully";
        } else {
            $_SESSION['message'] = "Failed to decline tutor";
        }
    }
}

// Retrieve pending student tutors from the database
$query = "SELECT * FROM tutor WHERE approvalStatus = 'pending'";
$result = mysqli_query($conn, $query);

// Check if there are any pending tutors
if (mysqli_num_rows($result) > 0) {
    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['tutorID']; ?></td>
            <td><?php echo $row['firstName']; ?></td>
            <td><?php echo $row['lastName']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['degreeProgram']; ?></td>
            <td><?php echo $row['year']; ?></td>
            <td><?php echo $row['gdriveLink']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="tutorID" value="<?php echo $row['tutorID']; ?>">
                    <button type="submit" class="btn btn-success" name="approve_btn">Approve</button>
                    <button type="submit" class="btn btn-danger" name="decline_btn">Decline</button>
                </form>
            </td>
        </tr>
        <?php
    }
} else {
    // No pending tutors found
    echo "<tr><td colspan='8'>No pending tutors</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>
