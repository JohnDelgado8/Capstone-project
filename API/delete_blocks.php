<?php
// Allow CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond to preflight request
    http_response_code(204);
    exit;
}

// Get the data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

// Check if all required data is provided
if (!isset($data->id)) {
    $response['success'] = false;
    $response['message'] = "Missing required data";
    echo json_encode($response);
    exit; // Terminate script execution
}

// Prepare the SQL statement for block deletion
$sqlDeleteBlock = "DELETE FROM blocks WHERE id = ?";
$stmtDeleteBlock = $conn->prepare($sqlDeleteBlock);

// Check if the statement preparation was successful
if (!$stmtDeleteBlock) {
  $response['success'] = false;
  $response['message'] = "Failed to prepare statement: " . $conn->error;
  echo json_encode($response);
  exit;
}

// Bind parameter
$stmtDeleteBlock->bind_param('i', $data->id);

// Execute the statement
if ($stmtDeleteBlock->execute()) {
    $response['success'] = true;
    $response['message'] = "Block deleted successfully!";
} else {
    $response['success'] = false;
    $response['message'] = "Error deleting block";
}

// Close the prepared statement for block deletion
$stmtDeleteBlock->close();

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
