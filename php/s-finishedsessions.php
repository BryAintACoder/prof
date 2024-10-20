<?php
echo "<script src='https://www.paypal.com/sdk/js?client-id=AU6AYP9LgxUcMt-MC3QjSq0ByXzxhDNXZCwVRNQ0fbPpr7avAKTncNpgsEIBdfODYUJ6BXqFXh8bGYIM&disable-funding=credit,card'></script>";


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
  font-size: 20px;
}
.degreeProgram{
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
  
  margin-left:1px; 
  margin-right:0px; 
  font-size: 15px;
  width: 100%;
}
.iconmode{
  width: 20px; /* Set a fixed width */
  height: 20px; /* Set a fixed height */
  margin: 0;
 
  object-fit: cover;
}
.subj{
  
  margin-left:1px; 
  margin-right:0px; 
  font-size: 15px;
  width: 100%;
  font-weight: 600;
}
.iconsubj{
  width: 19px; /* Set a fixed width */
  height: 20px; /* Set a fixed height */

  margin-bottom:0.5%;
  margin-right:0.5%;
  margin-left: 1%;
  object-fit: cover;
 
}
.bio{
 
  
  font-size: 15px;
  width: 100%;
  color: #666; /* Grey font color */
  font-style: italic; /* Italic font */
}
.btn-outline-custom1,
.btn-outline-custom2 {
    color: #0F422A;
    background-color: #ffffff;
    border-color: #0F422A;
    font-weight: bold;
    letter-spacing: 0.05em;
  
   width: 100%;
}

.btn-outline-custom1 {
    width: 100%;
}
  
.btn-outline-custom2 {
 width: 100%;
}
.rate-btn{

  width:100%;
  height:40px;


  font-size: 15px;
  font-weight: 300px;

}

.modal-content {
  border-radius: 15px; /* Rounded corners */
}

.rate {
    float: left;
    height: 46px;
    
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
    #comment {
  border: 2px solid #2D7A41; /* Set the border color */
  border-radius: 8px; /* Add border radius */
  display: flex;
  justify-content: flex-start;
  padding: 10px; /* Optional: adds padding inside the textarea */
  resize: none; /* Optional: disables resizing */
  width: 100%;
  height: 150px;
}

 .star {
      font-size: 30px;
      color: #ccc;
    }

    .star.filled {
      color: #ffc700;
    }



</style>";

// Retrieve logged-in student's studentID
$studentID = $_SESSION['auth_user']['user_id'];

// Query to fetch sessions for the logged-in student
$sql = "SELECT s.sessionID, DATE_FORMAT(s.sessionDate, '%M %e, %Y') AS formattedSessionDate, TIME_FORMAT(s.startTime, '%h:%i %p') AS formattedStartTime, TIME_FORMAT(s.endTime, '%h:%i %p') AS formattedEndTime, s.duration, s.subject, s.teachingMode, s.need, s.paymentStatus, s.status, 
        
        CONCAT(t.firstname, ' ', t.lastname) AS tutorFullName, t.ratePerHour, t.profilePicture
        FROM session s
        INNER JOIN tutor t ON s.tutorID = t.tutorID
        WHERE s.studentID = ? AND s.status = 'Finished' ";



$sql2 = "SELECT reviewID, studentID, sessionID, rating, comment, timestamp FROM review";





$result2 = $conn->query($sql2);



// Execute the query


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();


if (isset($_POST['submitReview'])) {
  // Get the form data
  $studentID = $_POST['studentID'];
  $sessionID = $_POST['sessionID'];
  $rating = $_POST['rating'];
  $comment = $_POST['comment'];
  $timestamp = date('Y-m-d H:i:s'); // current timestamp

  // Check if a review for this sessionID already exists
  $checkSql = "SELECT * FROM `review` WHERE `sessionID` = '$sessionID' AND `studentID` = '$studentID'";
  $checkResult = mysqli_query($conn, $checkSql);

  if (mysqli_num_rows($checkResult) > 0) {
      // Review already exists for this student and session
     
  } else {
      // Insert the data into the review table
      $sql = "INSERT INTO `review` (`studentID`, `sessionID`, `rating`, `comment`, `timestamp`) 
              VALUES ('$studentID', '$sessionID', '$rating', '$comment', '$timestamp')";

      if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Review submitted successfully!');</script>";
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
  }
}




// Check if the query was successful
if ($result) {
  // PayPal SDK script
  echo "<script src='https://www.paypal.com/sdk/js?client-id=sb&currency=PHP&disable-funding=credit,card'></script>";

  // Loop through the result set and display the data
  while ($row = mysqli_fetch_assoc($result)) {
    $sessionID = $row['sessionID'];

    $reviewCheckSql = "SELECT * FROM `review` WHERE `sessionID` = '$sessionID' AND `studentID` = '$studentID'";
    $reviewCheckResult = mysqli_query($conn, $reviewCheckSql);
    $reviewExists = mysqli_num_rows($reviewCheckResult) > 0;

    if ($reviewExists) {
      $reviewRow = mysqli_fetch_assoc($reviewCheckResult);
      $rating = $reviewRow['rating'];
      $comment = $reviewRow['comment'];


     
  }
    


    echo "

    <div class='col-md-12 mb-3' style='margin-left:0px; width:100% !important;'>
    <div class='card shadow custom-card' style='height: 100%; margin-top: 1%; '>
    <div class='card-body'>

     <table style = 'width: 100%; display: flex;'>
      <tbody style = 'width: 100%; display: flex;>
        <tr style = 'display:flex; width: 100%; '>
          <td style = 'width: 100%;' >
            <table style = 'width: 100%; height: 100%;'>
              <tbody style = 'width: 100%; '>
                <tr style = 'display:flex; width: 100%; '>
                  <td style = 'width: 100%;' >
                    <p style = 'font-weight: bold; font-size: 20px'>" . $row['tutorFullName'] . "</p>
                  </td>
                </tr>

                <tr style = 'display:flex; width: 100%;  ' >
                  <td style = 'margin: 0; padding: 0; width: 100%; '>
                    <div style='display:flex;  width: 100%; height: 100%; '>
                      <div style = 'margin: 0; padding: 0;'>
                        <img src='icons/mode.png' class='iconmode'/>
                      </div>

                      <div style='margin-left:10px; margin-right: 10px;'>
                        <p>" . $row['teachingMode'] . "</p>
                      </div>

                      <div>
                        <div style='border-left: 1px solid black; height: 80%; margin-left: 10px;'></div>
                      </div>

                      <div style='margin-left:10px; margin-right: 10px;'>
                        <p> " . $row["formattedSessionDate"] . " </p>
                      </div>

                      <div>
                         <div style='border-left: 1px solid black; height: 30px; '></div>
                      </div>

                      <div style='margin-left:10px; margin-right: 10px;'>
                        <p> " . $row["formattedStartTime"] .  " </p>
                      </div>

                      <div>
                         <div style='border-left: 1px solid black; height: 30px; '></div>
                      </div>

                      <div style='margin-left:10px; margin-right: 10px;'>
                        <p> " . $row["formattedEndTime"] .  " </p>
                      </div>

                    </div>
                  </td>
                </tr>

                <tr style = 'display:flex; width: 100%;  ' >
                  <td style = 'margin: 0; padding: 0; width: 100%; '>
                    <div style='display:flex;  width: 100%; height: 100%; '>
                      <div style = 'margin: 0; padding: 0;'>
                        <img src='icons/subj.png' class='iconsubj'/>
                      </div>

                      <div style='margin-left:10px; margin-right: 10px;'>
                        <p>" . $row['subject'] . "</p>
                      </div>

                    </div>
                  </td>
                </tr>

                <tr style = 'display:flex; width: 100%;  ' >
                  <td style = 'margin: 0; padding: 0; width: 100%; '>
                    <div style='display:flex;  width: 100%; height: 100%; '>

                      <div>
                        <p>Total Cost: ₱" . number_format($row['duration'] * $row['ratePerHour'], 2) ."</p>
                      </div>

                    </div>
                  </td>
                </tr>

                

              </tbody>
            </table>
          </td>
        </tr>

        <tr style = 'width: 40%; display: flex; justify-content: center;  flex: center; text-align: center; '>
          <td style = 'width: 100%;' >
           
              <table style = 'width: 100%;'>
              <tbody style = 'width: 100%; '>
                <tr style = 'width: 100%; '> 
                  <td style = 'width: 100%;'>
                    <p class = 'bio'>Status:</p style = 'width: 100%;'>
                  </td>
                </tr> 

                <tr>
                  <td>
                    <p class = 'bio'>" . $row['status'] ."</p>
                  </td>
                </tr> 
              </tbody>
              </table>
            
          </td>
         
        </tr>

        <tr style = 'width: 20%;  display: flex; justify-content: center;  flex: center; text-align: center; '>
          <td style = 'width: 100%;' >
           
              <table style = 'width: 100%;'>
              <tbody style = 'width: 100%; '>
                <tr style = 'width: 100%; '> 
                  <td style = 'width: 100%;'>";
                  if (!$reviewExists) {
                    echo "<button class='btn btn-outline-custom1' data-toggle='modal' data-target='#detailsModal'>Rate</button>";
                }
        
echo "                 

                    </td>
                </tr> 
                                            
                <tr style='width: 100%; '> 
                  <td style='width: 100%;'>
                      <div></div>
                  </td>
                </tr> 
                
                <tr>
                  <td>";

                  if ($reviewExists) {
                    echo "<button class='btn btn-outline-custom2' data-toggle='modal' data-target='#detailsModal2'>View Rating</button>";
                  }

echo "                      
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>


  </div>
  </div>
  </div>


  ";

    


    echo "

    
      <div class='modal fade' id='detailsModal' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='detailsModalLabel{$sessionID}'></h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
              <table>
                <tbody>
                  <tr>
                    <td>
                      <p style='font-weight: bold; font-size: 15px; display: flex; justify-content: start;'>" . $row['tutorFullName'] . "</p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p style='font-size: 15px; display: flex; justify-content: start;'>Subject: " . $row['subject'] . "</p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p style='font-weight: bold; font-size: 20px; display: flex; justify-content: start;'>Your Rating:</p>
                    </td>
                  </tr>

                  <form method='post' action=''>
                  <tr>
                    <td>
                      
                        <div class='rate'>
                          <input type='radio' id='star5' name='rating' value='5' required />
                          <label for='star5' title='5 stars'>5 stars</label>
                          <input type='radio' id='star4' name='rating' value='4' />
                          <label for='star4' title='4 stars'>4 stars</label>
                          <input type='radio' id='star3' name='rating' value='3' />
                          <label for='star3' title='3 stars'>3 stars</label>
                          <input type='radio' id='star2' name='rating' value='2' />
                          <label for='star2' title='2 stars'>2 stars</label>
                          <input type='radio' id='star1' name='rating' value='1' />
                          <label for='star1' title='1 star'>1 star</label>
                        </div>
                        
                        <input type='hidden' name='sessionID' value='{$sessionID}' />
                        <input type='hidden' name='studentID' value='{$studentID}' />
                        
                      
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <p style='font-weight: bold; font-size: 20px; display: flex; justify-content: start;'>Feedback:</p>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <textarea id='comment' name='comment' style=' display: flex; justify-content: start;' required></textarea>
                      <button type='submit' name='submitReview' class='btn btn-primary'>Submit Review</button>
                      
                    </td>
                  </tr>

                  </form>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
";





echo "
    <div class='modal fade' id='detailsModal2' tabindex='-1' role='dialog' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='detailsModalLabel{$sessionID}'></h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <table>
              <tbody>
                <tr>
                  <td>
                    <p style='font-weight: bold; font-size: 15px; display: flex; justify-content: start; margin: 0; color: #0F422A'>" . htmlspecialchars($row['tutorFullName']) . "</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style='font-size: 15px; display: flex; justify-content: start; color: #0F422A'>Subject: " . htmlspecialchars($row['subject']) . "</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style='font-weight: bold; font-size: 20px; display: flex; justify-content: start; margin:0; color: #0F422A'>Rating:</p>
                  </td>
                </tr>
                

                <tr>
                  <td>";

                    // Display stars based on the rating value
                    $totalStars = 5; // Total number of stars
                    for ($i = 1; $i <= $totalStars; $i++) {
                        if ($i <= $rating) {
                            echo "<span class='star filled'>★</span>"; // Filled star
                        } else {
                            echo "<span class='star'>★</span>"; // Empty star
                        }
                    }


                  echo"

                  </td>
                </tr>



                
                <tr>
                  <td>
                    <p style='font-weight: bold; font-size: 20px; display: flex; justify-content: start; margin:0; color: #0F422A'>Comment:</p>
                  </td>
                </tr>

                <tr>
                  <td>
                    <p style='font-size: 15px; display: flex; justify-content: start; color: #0F422A; text-align: justify;'> ". htmlspecialchars($comment) . "</p>

                   
                  </td>
                </tr>


              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
";




  }

} else {
  echo "Error: " . mysqli_error($conn);
}




// Close connection
mysqli_close($conn);
?>