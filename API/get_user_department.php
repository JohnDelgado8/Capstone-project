<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Check if email address is provided
if(isset($_GET['email'])) {
    $email = $_GET['email'];

    // Query to retrieve user's department based on email address
    $sql = "SELECT department FROM new_scheduling WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user's department from the result
        $row = $result->fetch_assoc();
        $department = $row['department'];

        // Prepare response data
        $response = array(
            'department' => $department
        );

        // Send JSON response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // If no user found with the provided email address, return an error message
        $response = array(
            'error' => 'User not found'
        );

        // Send JSON response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // If email address is not provided in the request, return an error message
    $response = array(
        'error' => 'Email address is required'
    );

    // Send JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
