<?php
// Include database connection
include "db.php";

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header('Access-Control-Allow-Origin: http://localhost:9000');
  header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Access-Control-Allow-Credentials: true');
  exit;
}

// Assuming you receive the data in the request body for PUT requests
$input = json_decode(file_get_contents('php://input'), true);

// Assuming you receive the email and updatedData in the request body
// Assuming you receive the originalEmail and updatedData in the request body
$originalEmail = isset($input['originalEmail']) ? $input['originalEmail'] : null;
$updatedData = isset($input['updatedData']) ? $input['updatedData'] : null;

// Check if the originalEmail and updatedData are provided
if ($originalEmail && $updatedData) {
  // Construct the SQL UPDATE query
  $updateQuery = "UPDATE new_scheduling SET ";

  // Build the SET clause dynamically based on the keys in $updatedData
  $setClauses = [];
  foreach ($updatedData as $key => $value) {
    // Ensure the key is a valid column in your table to prevent SQL injection
    $validColumns = ['fullname', 'department', 'position', 'email']; // Add other valid columns
    if (in_array($key, $validColumns)) {
      $setClauses[] = "$key = ?";
    }
  }

  // Check if there are valid columns to update
  if (!empty($setClauses)) {
    $updateQuery .= implode(', ', $setClauses);
    $updateQuery .= " WHERE email = ?";

    // Prepare and execute the UPDATE query
    $stmtUpdate = $conn->prepare($updateQuery);

    // Dynamically bind parameters based on the values in $updatedData
    $paramTypes = str_repeat('s', count($validColumns)) . 's'; // Assuming all values are strings
    $paramValues = array_map(function ($key) use ($updatedData) {
      return $updatedData[$key];
    }, $validColumns);
    $paramValues[] = $originalEmail; // Use the originalEmail for WHERE clause

    $stmtUpdate->bind_param($paramTypes, ...$paramValues);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Send a success response
    echo json_encode(["message" => "User data updated successfully"]);
  } else {
    // Invalid columns in $updatedData
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(["error" => "Invalid columns in updatedData"]);
  }
} else {
  // Invalid request data
  header("HTTP/1.1 400 Bad Request");
  echo json_encode(["error" => "Invalid request data"]);
}

// Close the database connection
$conn->close();

?>
