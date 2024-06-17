<?php

header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request to retrieve availability data
    $email = $_GET['email'];

    // Prepare the SQL query to retrieve availability data
    $getAvailabilityQuery = "SELECT id, new_scheduling_id, DAY, TIME_FROM, TIME_TO FROM availability WHERE new_scheduling_id = (SELECT id FROM new_scheduling WHERE email = ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($getAvailabilityQuery);
    $stmt->bind_param('s', $email);

    // Execute the query
    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Error executing the query'));
        exit();
    }

    // Get the result set
    $result = $stmt->get_result();

    // Fetch the data
    $availabilityData = array();
    while ($row = $result->fetch_assoc()) {
        $availabilityData[] = $row;
    }

    // Set the appropriate headers
    header('Content-Type: application/json');

    // Output the availability data as JSON
    echo json_encode($availabilityData);
} else {
    // If the request method is not GET, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
