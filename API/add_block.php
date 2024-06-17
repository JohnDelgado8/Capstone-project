<?php
// Allow CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Get the data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

// Check if all required data is provided
if (!isset($data->email) || !isset($data->name)) {
    $response['success'] = false;
    $response['message'] = "Missing required data";
    echo json_encode($response);
    exit; // Terminate script execution
}

// Get the user's ID based on the email
$getUserIDQuery = "SELECT id FROM new_scheduling WHERE email = ?";
$stmtUserID = $conn->prepare($getUserIDQuery);
$stmtUserID->bind_param('s', $data->email);
$stmtUserID->execute();
$resultUserID = $stmtUserID->get_result();
$userRow = $resultUserID->fetch_assoc();
$userID = $userRow['id'];

// Prepare the SQL statement for adding school year
$sqlInsertSchoolYear = "INSERT INTO blocks (user_id, name ) VALUES (?, ?)";
$stmtInsertSchoolYear = $conn->prepare($sqlInsertSchoolYear);

// Bind parameters
$stmtInsertSchoolYear->bind_param('is', $userID, $data->name);

// Execute the statement
$response = array();

if ($stmtInsertSchoolYear->execute()) {
    $response['success'] = true;
    $response['message'] = "School year saved successfully!";
} else {
    $response['success'] = false;
    $response['message'] = "Error saving school year";
}

// Close the prepared statements
$stmtUserID->close();
$stmtInsertSchoolYear->close();

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
