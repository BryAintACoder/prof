<?php
echo "<style type='text/css'>
      
      .profile-picture {
        margin: %;
        max-width: 200px;
        max-height: 200px;
        width: 160px; /* Set a fixed width */
        height: 160px; /* Set a fixed height */
        object-fit: cover; /* Maintain aspect ratio and cover the container */
      }
      .tutorName{
        position:absolute; 
        top:8%; 
        left:18.5%; 
        margin-left:0px; 
        margin-right:0px; 
        font-size: 20px;
      }
      .degreeProgram{
        position:absolute; 
        top:25%; 
        left:17%; 
        margin-left:0px; 
        margin-right:0px; 
        font-size: 15px;
        width: 100%;
      }
      .icongrad{
        width: 33px; /* Set a fixed width */
        height: 20px; /* Set a fixed height */
        position:relative; 
        margin-bottom:0.5%;
        margin-left: 1%;
      }
      .mode{
        position:absolute; 
        top:37%; 
        left:17.7%; 
        margin-left:1px; 
        margin-right:0px; 
        font-size: 15px;
        width: 100%;
      }
      .iconmode{
        width: 20px; /* Set a fixed width */
        height: 20px; /* Set a fixed height */
        position:relative; 
        margin-bottom:0.5%;
        margin-right:0.5%;
        margin-left: 1%;
        object-fit: cover;
      }
      .subj{
        position:absolute; 
        top:49%; 
        left:17.7%; 
        margin-left:1px; 
        margin-right:0px; 
        font-size: 15px;
        width: 100%;
        font-weight: 600;

      }
      .iconsubj{
        width: 19px; /* Set a fixed width */
        height: 20px; /* Set a fixed height */
        position:relative; 
        margin-bottom:0.5%;
        margin-right:0.5%;
        margin-left: 1%;
        object-fit: cover;
      }
      .bio{
        position: absolute;
        top: 65%;
        left: 19%;
        margin-left: 1px;
        margin-right: 0px;
        font-size: 15px;
        width: 58%;
        color: #666; /* Grey font color */
        font-style: italic; /* Italic font */
      }
      .btn-outline-success{
        color: #0F422A;
        background-color: #ffffff;
        border-color: #0F422A;
        font-weight: bold;
        letter-spacing: 0.05em;
      
        bottom:30%;
       left:80%;
       width:200px;
       height:40px;
       position: absolute;
       z-index: 2;
   
      }
   
      .duration{
        bottom:59%;
        left:83%;
        width:200px;
        height:40px;
        position: absolute;
        font-size: 20px;
        font-weight: 300px;

      }
      
      </style>";

// Retrieve logged-in tutor's tutorID
$tutorID = $_SESSION['auth_tutor']['tutor_id'];
// Query to fetch sessions for the logged-in tutor with student names
$sql = "SELECT s.sessionID, DATE_FORMAT(s.sessionDate, '%M %e, %Y') AS formattedSessionDate, TIME_FORMAT(s.startTime, '%h:%i %p') AS formattedStartTime, TIME_FORMAT(s.endTime, '%h:%i %p') AS formattedEndTime, s.duration, s.subject, s.teachingMode, s.need, s.paymentStatus, s.status, 
CONCAT(st.firstname, ' ', st.lastname) AS studentFullName, st.degreeProgram, st.year, t.ratePerHour
FROM session s
INNER JOIN student st ON s.studentID = st.studentID
INNER JOIN tutor t ON s.tutorID = t.tutorID
WHERE s.tutorID = ? AND s.status = 'Pending'
ORDER BY s.sessionID DESC"; // Order by session ID in descending order
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tutorID);
$stmt->execute();
$result = $stmt->get_result();

// Check if the prepare statement was successful
if (!$stmt) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $tutorID);
$stmt->execute();

// Check if the execute statement was successful
if ($stmt->error) {
    die("Execute failed: " . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();

// Check if the query was successful
if ($result) {
    // Loop through the result set and display the data
    while ($row = mysqli_fetch_assoc($result)) {
        $sessionID = $row['sessionID'];
        echo "<div class='col-md-12 mb-3' style = 'margin-left:120px; width:100% !important;'>";
        echo "<div class='card shadow custom-card' style='height: 200px; margin-top: 1%;'>";
        echo "<div class='card-body'>";
        // Display tutor information
        echo "<h4 class='tutorName'>" . $row['studentFullName']  ."</h4>";
        echo "<p class='card-text'><img src='icons/default.jpeg' alt='Profile Picture' class='profile-picture'></p>";
        echo "<p class='degreeProgram'>" . "<img src = 'icons/grad.png' class = 'icongrad'/>" . $row["degreeProgram"] . " - " . $row['year'] ."</p>";
        echo "<p class='mode'>" . "<img src = 'icons/mode.png' class = 'iconmode'/>"  . $row['teachingMode'] . "  ". "<strong>|</strong>" . "  ". $row["formattedSessionDate"] .  "  ". "<strong>|</strong>" . "  " .   $row["formattedStartTime"] ." - ".   $row["formattedEndTime"] ."</p>";
        echo "<p class='subj'> " . "<img src = 'icons/subj.png' class = 'iconsubj'/>"  . $row['subject'] . "</p>";
        echo "<p class='bio'>" . substr($row['need'], 0, 155) . (strlen($row['need']) > 75 ? '...' : '') . "</p>";

        // Calculate total cost
        $totalCost = $row['duration'] * $row['ratePerHour'];

        // Check if duration has a decimal value
        if ((float)$row['duration'] == (int)$row['duration']) {
            // Display duration without decimal value
            echo "<p class='duration'>" . (int)$row['duration'] . "hrs". " = ₱" . number_format($totalCost, 2) . "</p>";
        } else {
            // Display duration with decimal value
            echo "<p class='duration'>" . $row['duration'] . "hrs</p>";
        }

        echo "<a href='t-sessiondetails.php?sessionID=" . $sessionID . "'>
        <button class='btn btn-outline-success'>View More Details</button>
        </a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
