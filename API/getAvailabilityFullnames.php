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

    // Retrieve the department of the program head who logged in using their email
    $email = $_GET['email'];

    // Prepare the SQL query to retrieve the department of the program head
    $getUserDepartmentQuery = "SELECT department FROM new_scheduling WHERE email = ?";
    $stmt = $conn->prepare($getUserDepartmentQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($department);
    $stmt->fetch();
    $stmt->close();

    if (!$department) {
        // If program head's department is not found, return an error response
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Program head department not found'));
        exit();
    }

    // Prepare the SQL query to retrieve instructors' full names and availability days based on the program head's department
    $getInstructorsAndAvailabilityQuery = "
        SELECT ns.fullname, GROUP_CONCAT(CONCAT(a.DAY, ':', a.time_from, '-', a.time_to)) AS availability_days
        FROM new_scheduling ns
        LEFT JOIN availability a ON ns.id = a.new_scheduling_id
        WHERE ns.department = ? AND ns.position = 'Instructor'
        GROUP BY ns.fullname
    ";
    $stmt = $conn->prepare($getInstructorsAndAvailabilityQuery);
    $stmt->bind_param('s', $department);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data
    $instructorsData = array();
    while ($row = $result->fetch_assoc()) {
        $fullname = $row['fullname'];
        $availabilityDays = $row['availability_days'] ? explode(',', $row['availability_days']) : [];
        $instructorsData[] = array(
            'fullname' => $fullname,
            'availability_days' => $availabilityDays
        );
    }

    // Set the appropriate headers
    header('Content-Type: application/json');

    // Output the instructors' full names and availability days as JSON
    echo json_encode($instructorsData);
} else {
    // If the request method is not GET, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
