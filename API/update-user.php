<?php
// Tells the browser to allow code from the specified origin to access
header('Access-Control-Allow-Origin: http://localhost:9000');
// Tells browsers whether to expose the response to the frontend JavaScript code when the request's credentials mode (Request.credentials) is include
header("Access-Control-Allow-Credentials: true");
// Specifies one or more methods allowed when accessing a resource in response to a preflight request
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
// Used in response to a preflight request which includes the Access-Control-Request-Headers to indicate which HTTP headers can be used during the actual request
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  // Decode the JSON data sent in the request body
  $data = json_decode(file_get_contents("php://input"), true);

  // Check if data is not empty and contains required fields
  if (!empty($data) && isset($data['id'])) {
    // Extract user details from the data
    $userId = $data['id'];
    $fullname = $data['fullname'];
    $department = $data['department'];
    $position = $data['position'];
    $course = isset($data['course']) ? $data['course'] : null; // Course is optional
    $email = $data['email'];

    // Construct the SQL query to update user details
    $sql = "UPDATE new_scheduling SET fullname='$fullname', department='$department', position='$position', course='$course', email='$email' WHERE id=$userId";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
      // If update successful, return success message
      echo json_encode(["message" => "User details updated successfully"]);
    } else {
      // If update failed, return error message
      echo json_encode(["error" => "Error updating user details: " . $conn->error]);
    }
  } else {
    // If data is empty or required fields are missing, return error message
    echo json_encode(["error" => "Invalid data provided"]);
  }
} else {
  // If request method is not PUT, return error message
  echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>
