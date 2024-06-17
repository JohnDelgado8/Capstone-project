<?php
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Get the data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

// Get the user's ID based on the email
$getUserIDQuery = "SELECT id FROM new_scheduling WHERE email = ?";
$stmtUserID = $conn->prepare($getUserIDQuery);
$stmtUserID->bind_param('s', $data->email);
$stmtUserID->execute();
$resultUserID = $stmtUserID->get_result();
$userRow = $resultUserID->fetch_assoc();
$userID = $userRow['id'];

// Prepare the SQL statement for availability insertion
$sql = "INSERT INTO availability (new_scheduling_id, day, time_from, time_to) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
// Bind parameters
$stmt->bind_param('isss', $userID, $data->selectedDay, $data->selectedTimeAM, $data->selectedTimePM);

// Execute the statement
$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Data inserted successfully";
    $response['userID'] = $userID; // Include user ID in the response
} else {
    $response['success'] = false;
    $response['message'] = "Error inserting data";
}

// Close the prepared statement for user ID
$stmtUserID->close();

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
