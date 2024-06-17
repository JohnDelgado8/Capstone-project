<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the 'email' parameter is provided
    if (!isset($_GET['email'])) {
        // If 'email' parameter is not provided, return an error response
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Email parameter is missing'));
        exit();
    }

    // Handle GET request to retrieve curriculum data
    $email = $_GET['email'];

    // Prepare the SQL query to retrieve curriculum data
    $getCurriculumQuery = "SELECT user_id, Year, Subject, course_name, course_code, units, checked, semester, school_year FROM new_curriculum WHERE user_id = (SELECT id FROM new_scheduling WHERE email = ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($getCurriculumQuery);
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
    $curriculumData = array();
    while ($row = $result->fetch_assoc()) {
        $curriculumData[] = $row;
    }

    // Set the appropriate headers
    header('Content-Type: application/json');

    // Output the curriculum data as JSON
    echo json_encode($curriculumData);
} else {
    // If the request method is not GET, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
