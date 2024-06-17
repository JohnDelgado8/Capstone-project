<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Initialize an empty response array
$response = array();

// Query to retrieve saved days data from the database
$sql = "SELECT day, time_from, time_to, instructor FROM schedule";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Loop through each row and store days and times in the response array
    while ($row = $result->fetch_assoc()) {
        $response[] = array(
            'day' => $row['day'],
            'time_from' => $row['time_from'],
            'time_to' => $row['time_to'],
            'instructor' => $row['instructor']
        );
    }
} else {
    // If no rows are returned, set an error message in the response array
    $response['error'] = "No saved days found";
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
