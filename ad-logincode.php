<?php
session_start();
include('connection/dbconfig.php');

if(isset($_POST['login_button']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve password from the database based on username
    $query = "SELECT adminID, username, password FROM admin WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1)
    {
        $row = $result->fetch_assoc();

        // Verify the password
        if($password == $row['password'])
        {
            // Authentication successful
            $_SESSION['admin_authenticated'] = true; // Set admin authentication flag
            $_SESSION['auth_admin'] = [
                'user_id' => $row['adminID'],
                'username' => $row['username'],
            ];
            $_SESSION['message'] = "You are Logged In Successfully";
            header("Location: ad-index.php");
            exit(0);
        }
    }

    // Authentication failed
    $_SESSION['message'] = "Invalid Username or Password"; // Update error message
    header("Location: ad-login.php");
    exit(0);

    
}
?>
