<?php


// Redirect to login page if the tutor user is not authenticated
if(!isset($_SESSION['tutorauthentication']) || $_SESSION['tutorauthentication'] !== true) {
    header("Location: t-login.php");
    exit();
} elseif(isset($_SESSION['authentication']) && $_SESSION['authentication'] === true) {
    header("Location: s-index.php");
    exit();
} else if(isset($_SESSION['admin_authentication']) && $_SESSION['admin_authentication'] === true) {
    header("Location: ad-index.php");
    exit();}

// Set tutor first name for use in the t-index.php page
$tutor_firstname = isset($_SESSION['auth_tutor']['tutor_fullname']) ? $_SESSION['auth_tutor']['tutor_fullname'] : '';
$tutorID = isset($_SESSION['auth_tutor']['tutor_id']) ? $_SESSION['auth_tutor']['tutor_id'] : 'Tutor ID not found';
  
?>
