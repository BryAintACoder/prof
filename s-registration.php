<?php
session_start();

include ('php/s-restrict.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/s-registration.css">
</head>
<body>
    
    <div class="background-message">
    <a href="s-login.php" class="btn btn-primary1">Sign In</a>
   
    </div>


            <div class="registration-form">
            <div class="card">
            <div class="card-header">
            <h1>SIGN UP AS STUDENT</h1>
            </div>
            

            <div class="card-body">
            <?php if(isset($_SESSION['message'])): ?>
            <div class="message-container">
            <h4 class="alert alert-warning"><?= $_SESSION['message'] ?></h4>
            </div>
            <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

                        <form action="s-registercode.php" method="POST" class="body-reg">

                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" name="firstname" required placeholder="Enter First Name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" name="lastname" required placeholder="Enter Last Name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>School Email Address</label>
                                <input type="email" name="email" required placeholder="Enter Email Address" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Degree Program / Level of Highschool</label>
                                <select name="degreeProgram" required class="form-select">
                                    <option value="">Select Degree Program</option>
                                    <option value="BS in Information Technology">BS in Information Technology</option>
                                    <option value="BS n Business Administration">BS in Business Administration</option>
                                    <option value="High School">High School</option>
                                    <option value="Senior High School">Senior High School</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Year</label>
                                <input type="text" name="year" required placeholder="Enter Year" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" required placeholder="Enter Password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" required placeholder="Confirm Password" class="form-control">
                            </div>
                            
                            <div class="mb-3 sign-up-buttons">
                            <a href="land.php" class=" nope">I DON'T WANT TO SIGN UP</a>
                            <button type="submit" name="register_btn" class="btn btn-primary regbtn">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>