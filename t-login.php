<?php
session_start();
include ('php/t-restrict.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tutor Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/ST-login.css">
</head>
<body>
    
    <div class="background-message">
        <a href="t-registration.php" class="btn btn-primary1">Sign Up</a>
    </div>
    <div class="registration-form">
        <div class="card">
            <div class="card-header">
                <h1>SIGN IN</h1>
            </div>
            <div class="card-body">
            <?php if(isset($_SESSION['message'])): ?>
    <div class="message-container">
        <h4 class="alert alert-warning"><?= $_SESSION['message'] ?></h4>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>


                <form action="t-logincode.php" method="POST" class="body-reg">

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
                        <button type="submit" name="login_button" class="btn btn-primary logbtn">Submit</button>
                    </div>
                </form>

               

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
