<?php
session_start();

include('connection/dbconfig.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (isset($_SESSION['user_id'])) {
    header("Location: s-index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $_SESSION['email'] = $email;

    // Prepared statement to prevent SQL injection
    $sql = "SELECT studentID, firstname, lastname, email, password FROM student WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data && password_verify($password, $data['password'])) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+3 minutes"));

        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'moshtekan@gmail.com'; // Your email address
            $mail->Password = 'hgiv uxcl zevl drlx'; // Your app password
            $mail->setFrom('example@gmail.com', 'Two Factor Authentication');
            $mail->addAddress($email, $data['firstname'] . ' ' . $data['lastname']);
            $mail->Subject = "Your OTP for Login";
            $mail->Body = "Your OTP is: $otp";
            $mail->send();
        } catch (Exception $e) {
            $_SESSION['message'] = "Failed to send OTP. Please try again.";
            header("Location: s-login.php");
            exit();
        }

        // Store OTP and expiry in the database
        $update_sql = "UPDATE student SET otp=?, otp_expiry=? WHERE studentID=?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $otp, $otp_expiry, $data['studentID']);
        $update_stmt->execute();

        // Store temporary user data in session
        $_SESSION['temp_user'] = [
            'studentID' => $data['studentID'],
            'otp' => $otp
        ];

        header("Location: otp_verification.php");
        exit();
    } else {
        $_SESSION['message'] = "Invalid Email or Password. Please try again.";
        header("Location: s-login.php");
        exit();
    }
}
?>



<!-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        #container {
            margin-left: 400px;
            border: 1px solid black;
            width: 440px;
            padding: 20px;
            margin-top: 40px;
        }

        input[type=text],
        input[type=password] {
            width: 300px;
            height: 20px;
            padding: 10px;
        }

        label {
            font-size: 20px;
            font-weight: bold;
        }

        form {
            margin-left: 50px;
        }

        a {
            text-decoration: none;
            font-weight: bold;
            font-size: 21px;
            color: blue;
        }

        a:hover {
            cursor: pointer;
            color: purple;
        }

        input[type=submit] {
            width: 70px;
            background-color: blue;
            border: 1px solid blue;
            color: white;
            font-weight: bold;
            padding: 7px;
            margin-left: 130px;
        }

        input[type=submit]:hover {
            background-color: purple;
            cursor: pointer;
            border: 1px solid purple;
        }
    </style>
</head>

<body>
    <div id="container">
        <form method="post" action="index.php">
            <label for="email">Email</label><br>
            <input type="text" name="email" placeholder="Enter Your Email" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" placeholder="Enter Your Password" required><br><br>
            <input type="submit" name="login" value="Login"><br><br>
            <label>Don't have an account? </label><a href="registration.php">Sign Up</a>
        </form>
    </div>

</body>

</html> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login System in PHP MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/ST-login.css">
    <style>

    </style>
</head>

<body>

    <div class="background-message">
        <a href="s-registration.php" class="btn btn-primary1">Sign Up</a>
        <p class="text-center">Don't have an account?</p>
    </div>
    <div class="registration-form">
        <div class="card">
            <div class="card-header">
                <h1>SIGN IN</h1>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="message-container">
                        <h4 class="alert alert-warning"><?= $_SESSION['message'] ?></h4>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>


                <form action="s-login.php" method="POST" class="body-reg">

                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" required class="form-control">
                    </div>
                    <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" required class="form-control">
                    </div>

                    <div class="mb-3 sign-up-buttons">
                        <a href="land.php" class=" nope">I DON'T WANT TO SIGN IN</a>

                        <input type="submit" name="login" class="btn btn-primary logbtn" value ="Submit">
                    </div>
                </form>



            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>