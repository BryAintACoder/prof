<?php
include('connection/dbconfig.php');

/// Function to handle tutor deletion
function deleteTutor($tutorID) {
    global $conn;
    $delete_query = "DELETE FROM tutor WHERE tutorID=?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "s", $tutorID);
    $delete_result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $delete_result;
}

// Handle tutor deletion when form is submitted
if (isset($_POST['delete_btn'])) {
    $tutorIDToDelete = $_POST['tutorID'];
    if (deleteTutor($tutorIDToDelete)) {
        header("Location: tutormanagement.php"); // Refresh the page after deletion
    } else {
        echo "Error deleting tutor.";
    }
}

// Fetch approved tutors
$approved_query = "SELECT * FROM tutor WHERE approvalStatus='Approved'";
$approved_result = mysqli_query($conn, $approved_query);

// Fetch declined tutors
$declined_query = "SELECT * FROM tutor WHERE approvalStatus='Declined'";
$declined_result = mysqli_query($conn, $declined_query);

// Function to display approved tutors
function displayApprovedTutors($approved_result) {
    while ($row = mysqli_fetch_assoc($approved_result)) {
        echo "<tr>";
        echo "<td>" . $row['tutorID'] . "</td>";
        echo "<td>" . $row['firstName'] . "</td>";
        echo "<td>" . $row['lastName'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['degreeProgram'] . "</td>";
        echo "<td>" . $row['year'] . "</td>";
        echo "<td><a href='" . $row['gdriveLink'] . "' target='_blank'>Drive Link</a></td>";
        echo "<td>
                <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this tutor?\")'>
                    <input type='hidden' name='tutorID' value='" . $row['tutorID'] . "'>
                    <button type='submit' class='btn btn-danger' name='delete_btn'>DELETE</button>
                </form>
              </td>";
        echo "</tr>";
    }
}

// Function to display declined tutors
function displayDeclinedTutors($declined_result) {
    while ($row = mysqli_fetch_assoc($declined_result)) {
        echo "<tr>";
        echo "<td>" . $row['tutorID'] . "</td>";
        echo "<td>" . $row['firstName'] . "</td>";
        echo "<td>" . $row['lastName'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['degreeProgram'] . "</td>";
        echo "<td>" . $row['year'] . "</td>";
        echo "<td><a href='" . $row['gdriveLink'] . "' target='_blank'>Drive Link</a></td>";
        echo "<td>
                <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this tutor?\")'>
                    <input type='hidden' name='tutorID' value='" . $row['tutorID'] . "'>
                    <button type='submit' class='btn btn-danger' name='delete_btn'>DELETE</button>
                </form>
              </td>";
        echo "</tr>";
    }
}
?>
