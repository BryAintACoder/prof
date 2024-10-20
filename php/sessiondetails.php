

<?php
      
      echo "<style type='text/css'>

     

      .back-arrow {
        position: absolute;
        top: 29%; /* Adjust the distance from the top */
        right:18.2%; /* Adjust the distance from the left */
        color: #000; /* Adjust the color of the text and arrow */
        cursor: pointer;
    }
    
    .back-arrow .arrow {
        margin-right: 5px; /* Adjust the distance between the arrow and text */
    }
    
    .back-arrow .text {
        font-size: 16px; /* Adjust the font size of the text */
        font-weight: bold;
    }


    .profile-picture-container {
    position: absolute;
}

.profile-picture {
    max-width: 200px;
    max-height: 200px;
    width: 160px;
    height: 160px;
    object-fit: cover;
    margin-left:60%;
    border: 1px solid black;
}
      .studentName{
        position:absolute; 
        top:12.5%; 
        left:35.6%; 
        margin-left:0px; 
        margin-right:0px; 
        font-size: 20px;
        font-weight: bold;
        color:#0F422A;
      }
      .degreeProgram{
        position:absolute; 
        top:16%; 
        left:35.6%; 
        margin-left:0px; 
        margin-right:0px; 
        font-size: 15px;
        width: 100%;
      }
      .mode{
        position:absolute; 
        top:19%; 
        left:32.3%; 
        margin-left:1px; 
        margin-right:0px; 
        font-size: 15px;
        width: 100%;
      }
      .iconmode{
        width: 20px; /* Set a fixed width */
        height: 20px; /* Set a fixed height */
        position:relative; 
        margin-bottom:0.2%;
        margin-right:0.2%;
        margin-left: 3.1%;
        object-fit: cover;
      }
      .subj{
        position:absolute; 
        top:22%; 
        left:32.3%; 
        margin-left:1px; 
        margin-right:0px; 
        font-size: 15px;
        width: 100%;

      }
      .iconsubj{
        width: 19px; /* Set a fixed width */
        height: 20px; /* Set a fixed height */
        position:relative; 
        margin-bottom:0.2%;
        margin-right:0.2%;
        margin-left: 3.2%;
        object-fit: cover;
      }
      .time{
        position:absolute; 
        top:25%; 
        left:32.3%; 
        margin-left:1px; 
        margin-right:0px; 
        font-size: 15px;
        width: 100%;
        
      }
      .icontime{
        width: 19px; /* Set a fixed width */
        height: 20px; /* Set a fixed height */
        position:relative; 
        margin-bottom:0.2%;
        margin-right:0.2%;
        margin-left: 3.2%;
        object-fit: cover;
      }
      .need{
        position: absolute;
        top: 35%; /* Adjust the top position to align with the bottom of the time section */
        left: 36%;
        font-size: 15px;
        width: 45.5%;
        font-style: italic; /* Italic font */
        text-align: justify;
      }
      .line1{
        margin-top: 3%;
        width:70%;
        margin-left:28%;
      }
      .line2{
        margin-top: 14.5%;
        width:70%;
        margin-left:28%;5
        font-size: 15px;
      }
      .line3{
        margin-top: 9.2%;
        width:70%;
        margin-left:28%;
        font-size: 15px;
      }
    .status{
        position: absolute;
        top: 12.5%; 
        right: 18.2%; 
        font-weight:bold;
      }
    .duration{
        position: absolute;
        top: 16%; 
        right: 18.2%;
        font-weight:bold;
      }
      .buttons-container {
        display: inline-block;
        margin-top: 5%; 
        margin-left: 46%;
        
    }
    .button-container1,
    .button-container2 {
    display: inline-block;
    margin-right: 10px; /* Adjust the right margin as needed */
    border-radius: 50px;
    }
/* Adjust the width of the button containers as per your design */
    .button-container1 {
    width: 300px;
    }
    .button-container2 {
    width: 120px;
    }

    .buttonM {
      background-color: white; 
      color: black; 
      border: 1px solid #008ae6;
      width:160px;
      padding:5.9px;
      border-radius:4px;
      position: absolute;
      top: 20%; /* Adjust the distance from the top */
      right:18.2%;
      background-image: url('icons/mail.png');
    background-size: auto 100%; /* Adjust the size of the background image */
    background-position: 20px center; /* Position the background image */
    background-repeat: no-repeat; 
    padding-left: 43px;
    }
    
    .buttonM:hover {
      background-color: #008ae6;
      color: white;
    }
      </style>";

// Check if the session ID is provided in the URL
if (isset($_GET['sessionID'])) {
    // Get the session ID from the URL
    $sessionID = $_GET['sessionID'];
    // Retrieve logged-in tutor's tutorID
    $tutorID = $_SESSION['auth_tutor']['tutor_id'];
    // Prepare and execute a query to fetch session details
    $sql = "SELECT s.*, DATE_FORMAT(s.sessionDate, '%M %e, %Y') AS formattedSessionDate, TIME_FORMAT(s.startTime, '%h:%i %p') AS formattedStartTime, TIME_FORMAT(s.endTime, '%h:%i %p') AS formattedEndTime, CONCAT(st.firstname, ' ', st.lastname) AS studentName, st.degreeProgram, st.year, t.ratePerHour 
    FROM session s 
    INNER JOIN student st ON s.studentID = st.studentID 
    INNER JOIN tutor t ON s.tutorID = t.tutorID
    WHERE s.sessionID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sessionID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Fetch session details
        $session = $result->fetch_assoc();
        $totalCost = $session['duration'] * $session['ratePerHour'];
        
        
        
        // Display session details
        echo "<div class='container'>";
  
        echo "<hr class='line1'>";
        echo "<div class='profile-picture-container'>";
        echo "<img src='icons/default.jpeg' alt='Profile Picture' class='profile-picture'>";
        echo "</div>";
        echo "<p class='studentName'>"  . $session['studentName'] . "</p>";
        echo "<p class='degreeProgram'>" . $session['degreeProgram'] .  " - " . $session['year'] . "</p>";
        echo "<p class='mode'>" . "<img src = 'icons/mode.png' class = 'iconmode'/>" . $session['teachingMode'] ."</p>"; 
        echo "<p class='subj'> "."<img src = 'icons/subj.png' class = 'iconsubj'/>"  . $session['subject'] . "</p>";
        echo "<p class='time'>"."<img src = 'icons/time.png' class = 'icontime'/>". $session["formattedSessionDate"] .  " ". "<strong>|</strong>" . "  " .   $session["formattedStartTime"] ." - ".   $session["formattedEndTime"] . " ". "<strong>|</strong>" . "  " . (int)$session['duration'] . "hrs" . "</p>";
        echo "<hr class='line2'>";
        echo "<p class='need'>Need: <br/> " . $session['need'] . "</p>";
        echo "<hr class='line3'>";
        echo "<p class='status'> Status: ". $session['status'] . "</p>";

      echo "<button class='button buttonM'>Message</button>";

       //  Check if duration has a decimal value
         if ((float)$session['duration'] == (int)$session['duration']) {
          //  Display duration without decimal value
          echo "<p class='duration'>" . "Total Price: ₱" . number_format($totalCost, 2) . "</p>";
        } else {
           //  Display duration with decimal value
           echo "<p class='duration'>" . $session['duration'] . "hrs</p>";
       }

    

      echo"<div class='buttons-container'>
    <div class='button-container1'>
    <a href='php/acceptsession.php?sessionID=" . $sessionID . "'>
    <button class='btn btn-outline-success'>Accept & Ask for Payment</button>
    </a>
    </div>
    <div class='button-container2'>
    <a href='php/declinedsession.php?sessionID=" . $sessionID . "'
    <button class='btn btn-outline-danger'>Decline</button>
    </a>
    </div>
</div>";


        // Display other session details as needed
        echo "</div>";

        // Close database connection
        $stmt->close();
        $conn->close();
    } else {
        // Display an error message if the session ID is not found
        echo "Session not found.";
    }
} else {
    // Display an error message if the session ID is not provided in the URL
    echo "Session ID not provided.";
}
?>
