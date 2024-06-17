<?php
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Get the data sent from the client-side (if any, for example, if you need to filter or search)
$data = json_decode(file_get_contents("php://input"));

// Prepare the SQL statement to fetch specializations
$sql = "SELECT id, new_scheduling_id, specialization_name FROM specialization";

// You can modify the SQL statement here based on your specific needs, for example, adding WHERE clauses for filtering

// Execute the SQL statement
$result = $conn->query($sql);

// Prepare the response array
$response = array();

if ($result->num_rows > 0) {
    // Fetch rows from the result set
    while ($row = $result->fetch_assoc()) {
        // Add each row to the response array
        $response[] = $row;
    }
} else {
    // If no rows found, set a message in the response
    $response['message'] = "No specializations found";
}

// Close the database connection
$conn->close();

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
