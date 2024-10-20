<?php
session_start();
include('connection/dbconfig.php'); 
error_reporting(E_ALL); ini_set('display_errors', 1);
if(isset($_POST['register_btn']))
{
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $email = $_POST['email'];
    $degreeProgram = $_POST['degreeProgram'];
    $year = $_POST['year'];
    $gdriveLink = $_POST['gdriveLink'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $approvalStatus = "Pending";

    // Check Email
    $checkemail = "SELECT email FROM tutor WHERE email=? LIMIT 1";
    $stmt_checkemail = $conn->prepare($checkemail);
    $stmt_checkemail->bind_param("s", $email);
    $stmt_checkemail->execute();
    $result = $stmt_checkemail->get_result();

    if($result->num_rows > 0)
    {
        // Email Already Exists
        $_SESSION['message'] = "Email already exists";
        header("Location: s-registration.php");
        exit(0);
    }
    else
    {
        if($password == $confirm_password)
        {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare a statement
            $stmt = $conn->prepare("INSERT INTO tutor (firstName, lastName, email, degreeProgram, year, gdriveLink, password, approvalStatus ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            // Bind the parameters to the statement as strings. 
            $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $degreeProgram, $year, $gdriveLink, $hashed_password, $approvalStatus);

            // Execute the prepared statement
            $stmt->execute();

            if($stmt->affected_rows > 0)
            {
                $_SESSION['message'] = "Registered Successfully";
                header("Location: t-login.php");
                exit(0);
            }
            else
            {
                $_SESSION['message'] = "Something Went Wrong!";
                header("Location: t-registration.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['message'] = "Password and Confirm Password do not match";
            header("Location: t-registration.php");
            exit(0);
        }
    }
}
?>