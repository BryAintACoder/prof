<?php
session_start();
include('connection/dbconfig.php'); 
error_reporting(E_ALL);
ini_set('display_errors', 1);



if(isset($_POST['register_btn']))
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $degreeProgram = $_POST['degreeProgram'];
    $year = $_POST['year'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check Email
    $checkemail = "SELECT email FROM student WHERE email=? LIMIT 1";
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
            $stmt = $conn->prepare("INSERT INTO student (firstname, lastname, email, degreeProgram, year, password) VALUES (?, ?, ?, ?, ?,?)");

            // Bind the parameters to the statement as strings. 
            $stmt->bind_param("ssssss", $firstname, $lastname, $email, $degreeProgram, $year, $hashed_password);

            // Execute the prepared statement
            $stmt->execute();

            if($stmt->affected_rows > 0)
            {
                $_SESSION['message'] = "Registered Successfully";
                header("Location: s-login.php");
                exit(0);
            }
            else
            {
                $_SESSION['message'] = "Something Went Wrong!";
                header("Location: s-registration.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['message'] = "Password and Confirm Password do not match";
            header("Location: s-registration.php");
            exit(0);
        }
    }
}
?>