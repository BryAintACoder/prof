<?php 
session_start();
// Retrieve tutor information based on the query parameter
if(isset($_GET['tutor'])) {
    $tutorName = $_GET['tutor'];
  
    // Retrieve tutor's teaching mode from the database
    $sql = "SELECT teachingMode FROM tutor WHERE CONCAT(firstName, ' ', lastName) = '$tutorName'";
    $result = mysqli_query($conn, $sql);
  
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $teachingMode = $row['teachingMode'];
    }
  }

?>