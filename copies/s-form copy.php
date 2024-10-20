<?php
session_start();
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

    $sql = "SELECT tutorID, subjectExpertise, availableDaysTime FROM tutor WHERE CONCAT(firstName, ' ', lastName) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tutorName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tutorID = $row['tutorID']; // Get the tutorID
        $subjectExpertise = $row['subjectExpertise'];
        $availableDaysTime = $row['availableDaysTime'];

        // Check if the tutor has multiple subject expertise
        $subjectArray = explode(",", $subjectExpertise);
        $subjectCount = count($subjectArray);

        // Display tutor information
        echo "<input type='hidden' name='tutorID' value='" . $tutorID . "'>"; // Hidden input field for tutorID

        echo "<p>Subject Expertise: " . $subjectExpertise . "</p>";
        echo "<p>Available Days & Time: " . $availableDaysTime . "</p>";

        // Now, you can include the code to display the teaching mode as per your requirement
    }
    
}
?>