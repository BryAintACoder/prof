<?php

// Assuming you have fetched the tutor's teachingMode from the database
$tutorTeachingMode = "Online"; // Replace this with the actual value from the database

// Function to check if a teaching mode is selected
function isTeachingModeSelected($selectedMode, $tutorTeachingMode)
{
    return $selectedMode === $tutorTeachingMode ? "checked" : "";
}

if ($teachingMode === 'Online') {
    echo "<input type='hidden' name='teachingMode' value='Online'>";
    echo "<p id='online'>Online</p>";
} elseif ($teachingMode === 'School') {
    echo "<input type='hidden' name='teachingMode' value='School'>";
    echo "<p id='school'>In School</p>";
} else { // Online & School
    echo "<input type='radio' id='online' name='teachingMode' value='Online'>";
    echo "<label for='online'>Online</label>";
    echo "<input type='radio' id='school' name='teachingMode' value='School'>";
    echo "<label for='school'>In School</label>";
}

// Retrieve tutor information based on the query parameter
if (isset($_GET['tutor'])) {
    $tutorName = $_GET['tutor'];

    // Query to fetch tutor's basic information from the tutor table
    $sql = "SELECT tutorID, subjectExpertise FROM tutor WHERE CONCAT(firstName, ' ', lastName) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tutorName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tutorID = $row['tutorID']; // Get the tutorID
        $subjectExpertise = $row['subjectExpertise'];

        // Display subject expertise (if needed)
        $subjectArray = explode(",", $subjectExpertise);
        $subjectCount = count($subjectArray);

        // Display tutor information
        echo "<input type='hidden' name='tutorID' value='" . $tutorID . "'>"; // Hidden input field for tutorID
        
        // Now, retrieve tutor availability from the TutorAvailability table
        $sqlAvailability = "SELECT day_of_week, start_time, end_time 
                            FROM TutorAvailability 
                            WHERE tutor_id = ?";
        $stmtAvailability = $conn->prepare($sqlAvailability);
        $stmtAvailability->bind_param("i", $tutorID);
        $stmtAvailability->execute();
        $resultAvailability = $stmtAvailability->get_result();

        // Check if availability records exist
        $availableDays = [];
        if ($resultAvailability && $resultAvailability->num_rows > 0) {
            echo "<p>Available Days & Times:</p>";
            echo "<ul>";
            
            // Loop through and display the tutor's available days and times
            while ($availabilityRow = $resultAvailability->fetch_assoc()) {
                $dayOfWeek = $availabilityRow['day_of_week'];
                $startTime = date("h:i A", strtotime($availabilityRow['start_time']));
                $endTime = date("h:i A", strtotime($availabilityRow['end_time']));
                echo "<li>" . $dayOfWeek . ": " . $startTime . " - " . $endTime . "</li>";

                // Store available days for use in JavaScript
                $availableDays[] = $dayOfWeek; 
            }

            echo "</ul>";
        } else {
            echo "<p>No availability information found for this tutor.</p>";
        }
    } else {
        echo "<p>Tutor not found.</p>";
    }
}
?>
