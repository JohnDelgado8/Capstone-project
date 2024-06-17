<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php'; // Make sure to adjust the path to your database connection file

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the 'email' parameter is provided
    if (!isset($_GET['email'])) {
        // If 'email' parameter is not provided, return an error response
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Email parameter is missing'));
        exit();
    }

    // Retrieve the department of the user who logged in using their email
    $email = $_GET['email'];

    // Prepare the SQL query to retrieve the department of the user
    $getUserDepartmentQuery = "SELECT department FROM new_scheduling WHERE email = ?";
    $stmt = $conn->prepare($getUserDepartmentQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($department);
    $stmt->fetch();
    $stmt->close();

    if (!$department) {
        // If user's department is not found, return an error response
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'User department not found'));
        exit();
    }

    // Prepare the SQL query to retrieve courses based on the user's department
    $getCoursesQuery = "SELECT courses_id, course_name, course_department FROM courses WHERE course_department = ?";
    $stmt = $conn->prepare($getCoursesQuery);
    $stmt->bind_param('s', $department);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data
    $coursesData = array();
    while ($row = $result->fetch_assoc()) {
        $coursesData[] = $row;
    }

    // Set the appropriate headers
    header('Content-Type: application/json');

    // Output the courses data as JSON
    echo json_encode($coursesData);
} else {
    // If the request method is not GET, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
