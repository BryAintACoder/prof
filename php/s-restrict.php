<?php 

// Redirect to another page if the user is already authenticated
if(isset($_SESSION['authentication']) && $_SESSION['authentication'] === true) {
    header("Location: s-index.php");
    exit(0);
}  else if(isset($_SESSION['tutorauthentication']) && $_SESSION['tutorauthentication'] === true) {
    header("Location: t-index.php");
    exit();
} else if(isset($_SESSION['admin_authenticated']) && $_SESSION['admin_authenticated'] === true) {
    header("Location: ad-index.php");
    exit();
}

?>