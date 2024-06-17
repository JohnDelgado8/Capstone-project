<?php
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request to retrieve instructor data for Animation and Information Technology
    $courses = ['Animation', 'Information Technology'];

    // Prepare the SQL query to retrieve instructor data for specified courses
    $getInstructorDataQuery = "SELECT fullname AS name, course FROM new_scheduling WHERE course IN (?, ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($getInstructorDataQuery);
    $stmt->bind_param('ss', ...$courses);

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
    $instructorData = array();
    while ($row = $result->fetch_assoc()) {
        $instructorData[] = $row;
    }

    // Set the appropriate headers
    header('Content-Type: application/json');

    // Output the instructor data as JSON
    echo json_encode($instructorData);
} else {
    // If the request method is not GET, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
