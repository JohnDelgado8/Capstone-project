<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Initialize an empty response array
$response = array();

// Query to retrieve room data from the database
$sql = "SELECT type, room_number, availability_start, availability_end, building, days FROM room";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Loop through each row and store data in the response array
    while ($row = $result->fetch_assoc()) {
        // Include type, room_number, availability_start, availability_end, and days in the response
        $response[] = array(
            'type' => $row['type'],
            'room_number' => $row['room_number'],
            'availability_start' => $row['availability_start'],
            'availability_end' => $row['availability_end'],
            'building' => $row['building'],
            'days' => $row['days']
        );
    }
} else {
    // If no rows are returned, set an error message in the response array
    $response['error'] = "No room data found";
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
