<?php
session_start();

include('connection/dbconfig.php');
if (!isset($_SESSION['temp_user'])) {
    header("Location: s-login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp'];
    $stored_otp = $_SESSION['temp_user']['otp'];
    $user_id = $_SESSION['temp_user']['studentID'];

    $sql = "SELECT * FROM student WHERE studentID=? AND otp=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $user_otp);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $otp_expiry = strtotime($data['otp_expiry']);
        if ($otp_expiry >= time()) {
            // Set authentication session variables
            $_SESSION['authentication'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $data['studentID'],
                'user_fullname' => $data['firstname'] . ' ' . $data['lastname'],
                'user_email' => $data['email'],
            ];
            // Optionally unset temp_user
            unset($_SESSION['temp_user']);
            header("Location: s-index.php");
            exit();
        } else {
            echo "<script>
                    alert('OTP has expired. Please try again.');
                    window.location.href = 's-login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid OTP. Please try again.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            display: flex;
            background-color: #0F422A;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        table {
            width: 50%;
            height: 40%;
            background-color: white;
            border-radius: 15px;
            border: none;
            border-collapse: collapse;
        }

        tbody {
            width: 100%;
            height: 100%;
            border: none;
        }

        .two-step {
            border: none;
            margin-top: 1.5%;
            width: 100%;
            color: #0F422A;
            display: flex;
            justify-content: center;


        }

        .email-text {
            border: none;
            font-size: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .stud-email {
            border: none;
            color: #0F422A;
            font-weight: bold;

            width: 100%;
            display: flex;
            justify-content: center;

        }

        .form-otp {
            display: flex;
            justify-content: center;
            margin-top: 3%;
        }

        .enter-otp {
            display: flex;
            justify-content: center;
        }

        .input-otp {
            display: flex;
            justify-content: center;
            margin-top: 3%;
        }

        input[name="otp"] {
            width: 500px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 2px solid #ccc;
            transition: border-color 0.3s ease;
        }

        input[name="otp"]:focus {
            outline: none;
            border-color: #4CAF50;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #F4CC1D;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s ease-in-out;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td class="two-step">
                    <h1>Two-Step Verification</h1>
                </td>

                <td class="email-text">
                    <p>Enter the 6 Digit OTP Code that has been sent to your email address: </p>
                </td>

                <td class="stud-email">
                    <?php echo $_SESSION['email']; ?>
                </td>

                <td class="form-otp">
                    <form method="post" action="otp_verification.php">

                        <table>
                            <tbody>
                                <tr>
                                    <td class="enter-otp">
                                        <label style="font-weight: bold; font-size: 20px;" for="otp">Enter OTP
                                            Code:</label>
                                    </td>

                                    <td class="input-otp">
                                        <input type="number" name="otp" pattern="\d{6}" placeholder="Six-Digit OTP"
                                            required>
                                    </td>

                                    <td class="two-step">
                                        <button type="submit">Verify OTP</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>