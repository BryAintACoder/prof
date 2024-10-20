<?php
session_start();
include('connection/dbconfig.php');

if(isset($_POST['login_button']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database based on email
    $query = "SELECT tutorID, firstName, lastName, email, degreeProgram, year, gdriveLink, password, approvalStatus FROM tutor WHERE email=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1)
    {
        $row = $result->fetch_assoc();

        // Verify the hashed password
        if(password_verify($password, $row['password']))
        {
            // Authentication successful
            $_SESSION['tutorauthentication'] = true;
            $_SESSION['auth_tutor'] = [
                'tutor_id' => $row['tutorID'],
                'tutor_fullname' => $row['firstName'].' '.$row['lastName'],
                'tutor_email' => $row['email'],
              

            ];
            $_SESSION['message'] = "You are Logged In Successfully";
            header("Location: t-index.php");
            exit(); // Terminate the script
        }
    }

    // Authentication failed
    $_SESSION['message'] = "Invalid Email or Password";
    header("Location: t-login.php");
    exit(); // Terminate the script
}
?>


