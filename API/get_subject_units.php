<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Initialize an empty response array
$response = array();

// Check if the subject parameter is set
if(isset($_GET['subject'])) {
    // Get the subject name from the request
    $subject = $_GET['subject'];

    // Query to retrieve units data for the specified subject from the database
    $sql = "SELECT units FROM new_curriculum WHERE Subject = '$subject'";
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch the units data
        $row = $result->fetch_assoc();

        // Include units in the response
        $response['units'] = $row['units'];
    } else {
        // If no rows are returned, set an error message in the response array
        $response['error'] = "No units data found for the specified subject";
    }
} else {
    // If subject parameter is not set, set an error message in the response array
    $response['error'] = "Subject parameter is missing";
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
