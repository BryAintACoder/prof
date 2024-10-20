<?php


// Redirect to admin dashboard if admin user is authenticated
if(isset($_SESSION['admin_authentication']) && $_SESSION['admin_authentication'] === true) {
    header("Location: ad-index.php");
    exit();
}   else if(isset($_SESSION['tutorauthentication']) && $_SESSION['tutorauthentication'] === true) {
    header("Location: t-index.php");
    exit();
} elseif(isset($_SESSION['authentication']) && $_SESSION['authentication'] === true) {
    header("Location: s-index.php");
    exit();
} 
?>