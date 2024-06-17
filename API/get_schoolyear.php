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

    // Handle GET request to retrieve user_id based on email
    $email = $_GET['email'];

    // Prepare the SQL query to retrieve user_id based on email
    $getUserIdQuery = "SELECT id FROM new_scheduling WHERE email = ?";

    // Use prepared statements to prevent SQL injection
    $stmtUserId = $conn->prepare($getUserIdQuery);
    $stmtUserId->bind_param('s', $email);

    // Execute the query to get user_id
    $stmtUserId->execute();

    // Check for errors
    if ($stmtUserId->error) {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Error executing the query to get user_id'));
        exit();
    }

    // Get the user_id result
    $resultUserId = $stmtUserId->get_result();

    // Fetch the user_id
    $rowUserId = $resultUserId->fetch_assoc();
    $user_id = $rowUserId['id'];

    // Prepare the SQL query to retrieve school years based on user_id
    $getSchoolYearsQuery = "SELECT year FROM school_years WHERE user_id = ?";

    // Use prepared statements to prevent SQL injection
    $stmtSchoolYears = $conn->prepare($getSchoolYearsQuery);
    $stmtSchoolYears->bind_param('i', $user_id);

    // Execute the query
    $stmtSchoolYears->execute();

    // Check for errors
    if ($stmtSchoolYears->error) {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Error executing the query to get school years'));
        exit();
    }

    // Get the result set
    $resultSchoolYears = $stmtSchoolYears->get_result();

    // Fetch the school years
    $schoolYears = array();
    while ($row = $resultSchoolYears->fetch_assoc()) {
        $schoolYears[] = $row['year'];
    }

    // Set the appropriate headers
    header('Content-Type: application/json');

    // Output the school years as JSON
    echo json_encode($schoolYears);
} else {
    // If the request method is not GET, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
