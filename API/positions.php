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

// Query to fetch positions from the database
$sql = "SELECT DISTINCT position FROM new_scheduling";
$result = $conn->query($sql);

$positions = array(); // Array to store positions

if ($result->num_rows > 0) {
  // Fetch positions and store them in the array
  while ($row = $result->fetch_assoc()) {
    $positions[] = $row['position'];
  }
}

// Echo JSON response
echo json_encode($positions);

$conn->close();
?>
