<?php
session_start();


include('php/s-auth.php');
include('connection/dbconfig.php'); // Include your database connection file
include('php/tutorname.php'); // Include your database connection file


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
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Navigation Items -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Find a Tutor</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="appointmentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Appointments
            </a>
            <div class="dropdown-menu" aria-labelledby="appointmentsDropdown">
              <a class="dropdown-item" href="#">Pending</a>
              <a class="dropdown-item" href="#">Accepted</a>
              <a class="dropdown-item" href="#">Declined</a>
              <a class="dropdown-item" href="#">Finished</a>
           </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Notifications</a>
          </li>
          <li class="nav-item dropdown user-dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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


      

        <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Request a Session with <?php echo htmlspecialchars($tutorName); ?></h4>
                </div>
                <div class="card-body">
                    <form method="post" action="s-sessionformcode.php">

                    <input type="hidden" name="tutorID" value="<?php echo $tutorID; ?>">
                        <div class="mb-3">
                            <h2></h2>
                        </div>
                        <div class="mb-3">
                            <label for="teachingMode">Lesson Type:</label>
                            <?php include("php/s-form.php"); ?>
                        </div>
                        <div class="mb-3">
                            <label for="subjectExpertise">Subject Expertise:</label>
                            <?php if($subjectCount === 1) { ?>
                                <input type="text" class="form-control" id="subjectExpertise" name="subjectExpertise" value="<?php echo $subjectExpertise; ?>" readonly>
                            <?php } else { ?>
                                <select class="form-control" id="subjectExpertise" name="subjectExpertise">
                                    <?php foreach($subjectArray as $subject) { ?>
                                        <option value="<?php echo $subject; ?>"><?php echo $subject; ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <p>Available Days & Time: <?php echo $availableDaysTime; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="sessionDate">Select Date:</label>
                            <input type="date" class="form-control" id="sessionDate" name="sessionDate">
                        </div>
                        <div class="mb-3">
                            <label for="startTime">Start Time:</label>
                            <input type="time" class="form-control" id="startTime" name="startTime" onchange="calculateDuration()">
                        </div>
                        <div class="mb-3">
                            <label for="endTime">End Time:</label>
                            <input type="time" class="form-control" id="endTime" name="endTime" onchange="calculateDuration()">
                        </div>
                        <div class="mb-3">
                            <label for="duration">Duration (hours):</label>
                            <input type="number" class="form-control" id="duration" name="duration" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="need">What do you need?</label>
                            <textarea class="form-control" id="need" name="need" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    

<!-- jQuery, Popper.js, and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="disableBackButton.js"></script>
<script src="js/sessionDuration.js"></script>

<script>
$(document).ready(function() {
$('.form-select').select2();
});
</script>


</body>
</html>



    

