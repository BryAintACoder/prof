<?php
session_start();


include('php/s-auth.php');
include('connection/dbconfig.php'); // Include your database connection file



?>

<!DOCTYPE html>
<html>

<head>
    <title>FEUTOR</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">

</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-green bg-green">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#">FEUTOR</a>
            <!-- Toggler Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navigation Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="s-index.php">Find a Tutor</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="appointmentsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Appointments
                        </a>
                        <div class="dropdown-menu" aria-labelledby="appointmentsDropdown">
                            <a class="dropdown-item" href="s-pending.php">Pending</a>
                            <a class="dropdown-item" href="s-waitingforpayment.php">Waiting for Payment</a>
                            <a class="dropdown-item" href="s-approved.php">Accepted</a>
                            <a class="dropdown-item" href="s-declined.php">Declined</a>
                            <a class="dropdown-item" href="s-finished.php">Finished</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notifications</a>
                    </li>
                    <li class="nav-item dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $user_firstname; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="s-logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  <div class="card" style="width: 23rem; height: 30%; position: absolute; margin-left: 5%; margin-top: 6%; border: 0.5px solid #ccc !important;">
    <div class="card-body shadow">
      <h5 class="card-title">What would you like to learn?</h5>
      <div class="mb-3">
          <select name="subjectExpertise[]" required class="form-select" multiple required placeholder = "Ex: Programming">
          <option value="" disabled>Select Subject Expertise</option>
              <?php include ('php/t-subj.php');?>
          </select>
      </div>

      <h5 class="card-title">Lesson Location</h5>
      <div class="container">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="inSchoolCheckbox" name="inSchoolCheckbox">
                    <label class="form-check-label" for="inSchoolCheckbox">In School</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="onlineCheckbox" name="onlineCheckbox">
                    <label class="form-check-label" for="onlineCheckbox">Online</label>
                </div>
            </div>
        </div>
    </div>

    

  </div>



  <!-- Content area to display tutor data -->
  <div class="container mt-3" style = "margin-top:2.3% !important; margin-right: 10%;">
  <h1 class = "s-header">Find tutors for private lessons.</h1>
    <div class="row justify-content-center">
      <?php  include('php/tutorselection.php'); ?>
    </div>
  </div>

  <!-- jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.form-select').select2();
        });
    </script>


    
</body>
</html>
