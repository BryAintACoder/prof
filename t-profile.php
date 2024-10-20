<?php
session_start();
include('php/t-auth.php');
include('connection/dbconfig.php');

// Fetch the profile picture and full name of the tutor
$tutorID = $_SESSION['auth_tutor']['tutor_id'];
$query = "SELECT profilePicture, firstName, lastName FROM tutor WHERE tutorID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tutorID);
$stmt->execute();
$stmt->bind_result($profilePicture, $firstName, $lastName);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Your Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <a class="nav-link" href="t-dashboard.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="appointmentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Appointments
                    </a>
                    <div class="dropdown-menu" aria-labelledby="appointmentsDropdown">
                        <a class="dropdown-item" href="t-approved.php">Accepted</a>
                        <a class="dropdown-item" href="t-declined.php">Declined</a>
                        <a class="dropdown-item" href="t-finished.php">Finished</a>
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
                        <!-- Display only Profile Picture -->
                        <img src="img/<?php echo $profilePicture; ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
                        </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="t-profile.php">Edit Profile</a>
                        <a class="dropdown-item" href="t-logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Content area for profile setup -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Edit Your Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="t-profilecode.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3 text-center">
                                <img id="profilePicturePreview" src="img/<?php echo $profilePicture; ?>" alt="Profile Picture Preview" class="rounded-circle" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="mb-3">
                                <label>Profile Picture</label>
                                <input type="file" name="profilePicture" accept="image/jpeg, image/png" class="form-control-file" id="profilePictureInput">
                            </div>
                            <!-- Additional fields for profile -->
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" name="firstName" required value="<?php echo $firstName; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" name="lastName" required value="<?php echo $lastName; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Teaching Mode</label>
                                <select name="teachingMode" class="form-control" required>
                                    <option value="" selected disabled>Select Preferred Mode</option>
                                    <option value="Online">Online</option>
                                    <option value="School">School</option>
                                    <option value="Online & School">Online & School</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Rate Per Hour</label>
                                <input type="number" name="ratePerHour" required class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Bio</label>
                                <textarea name="bio" required class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="updateProfile" class="btn btn-primary">Save Changes</button>
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
</body>
</html>
