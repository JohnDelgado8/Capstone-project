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

// Check if user ID is provided in the URL query parameter
if(isset($_GET['userId'])) {
  // Retrieve user ID from the URL query parameter
  $userId = $_GET['userId'];

  // Query to select account details based on user ID
  $sql = "SELECT id, fullname, department, position, course, email FROM new_scheduling WHERE id = $userId";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Fetch account details and store it in an array
    $accountDetails = $result->fetch_assoc();

    // Encode the array as JSON and echo it
    echo json_encode($accountDetails);
  } else {
    // If no account found with the provided user ID, return an error message
    echo json_encode(["error" => "No account found with the provided user ID"]);
  }
} else {
  // If user ID is not provided in the URL query parameter, return an error message
  echo json_encode(["error" => "User ID is required"]);
}

$conn->close();
?>
