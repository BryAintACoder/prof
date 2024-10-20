<?php
// Include database connection
include('connection/dbconfig.php');
$con = mysqli_connect("localhost","root","","feutordb");

// SQL query to fetch subjects
$query = "SELECT * FROM subjects";
$query_run = mysqli_query($con,$query);
if(mysqli_num_rows($query_run) > 0) {
    foreach($query_run as $row) {
        ?>
        <option value="<?php echo $row['subject_name']; ?>"><?php echo $row['subject_name']; ?></option>
        <?php
    }
} else {
    echo "No Record Found";
}
?>
