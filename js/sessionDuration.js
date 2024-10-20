function calculateDuration() {
    // Get the start time and end time values
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;

    // Convert the time strings to Date objects
    const startDate = new Date("1970-01-01T" + startTime + "Z");
    const endDate = new Date("1970-01-01T" + endTime + "Z");

    // Calculate the duration in milliseconds
    let duration = endDate - startDate;

    // Check if the duration is negative (end time before start time)
    if (duration < 0) {
        alert("End time should be after start time.");
        return; // Exit the function
    }

    // Convert duration to hours
    duration = duration / (1000 * 60 * 60);

    // Update the duration input field value
    document.getElementById("duration").value = duration.toFixed(1);
}
