<?php
session_start();

include('php/ad-restrict.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<style>
    body{
        background-color: #D9D9D9;
    }
    img {
      display: block;
      margin: 0 auto;
      margin-top:4%;
    }
    h4{
        text-align: center;
        font-size:50px;
    }
    
</style>
<body>
    
  

            <?php
                    // Your message code
                    if(isset($_SESSION['message']))
                    {
                        echo '<h4 class="alert alert-warning">'.$_SESSION['message'].'</h4>';
                        unset($_SESSION['message']);
                    } // Your message code
                ?>

                        <img src = icons/adminlogo.png width="600" height="600" >
                        <h4>FEUTOR ADMIN CENTER</h4>
                    
                  

                        <div style="display: flex; justify-content: center; align-items: center; height: 22vh;">
                        <form action="ad-logincode.php" method="POST" style="text-align: center;">
    <div class="mb-3">
        <input type="text" class="form-control" name="username" placeholder="Enter your Username" style="width: 300px;">
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" name="password" placeholder="Enter Password" style="width: 300px;">
    </div>
    <div class="mb-3">
        <button type="submit" name="login_button" class="btn btn-primary" style="margin-top: 5%;width: 50%; background-color: #1D5512; color: white; border-radius: 30px;">Login</button>
    </div>
</form>

</div>


                 
         

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
