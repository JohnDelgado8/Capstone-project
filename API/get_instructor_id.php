<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Initialize an empty response array
$response = array();

// Get the email parameter from the request
$requestedEmail = $_GET['email'];

// Query to retrieve instructor information based on email
$sql = "SELECT id, fullname, position FROM new_scheduling WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $requestedEmail);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Fetch the first row to get the user information
    $row = $result->fetch_assoc();
    $instructorFullName = $row['fullname'];

    // Query to retrieve schedule data for the specific instructor
    $sql = "SELECT id, instructor, year, subjectname, type, room, day, time_from, time_to, new_scheduling_id FROM schedule WHERE instructor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $instructorFullName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Loop through each row and store data in the response array
        while ($row = $result->fetch_assoc()) {
            // Include time_from and time_to in the response
            $response[] = array(
                'id' => $row['id'],
                'instructor' => $row['instructor'],
                'year' => $row['year'],
                'subjectname' => isset($row['subjectname']) ? $row['subjectname'] : null,
                'type' => $row['type'],
                'room' => $row['room'],
                'day' => $row['day'],
                'time_from' => isset($row['time_from']) ? $row['time_from'] : null,
                'time_to' => isset($row['time_to']) ? $row['time_to'] : null,
                'new_scheduling_id' => isset($row['new_scheduling_id']) ? $row['new_scheduling_id'] : null
            );
        }
    } else {
        // If no rows are returned, set an error message in the response array
        $response['error'] = "No schedule data found for instructor: $instructorFullName";
    }
} else {
    // If no rows are returned for the provided email, set an error message in the response array
    $response['error'] = "No user found for email: $requestedEmail";
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$stmt->close();
$conn->close();
?>
