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

// Query to fetch data from the database
$sql = "SELECT id, fullname, department, position, course, email, password, status FROM new_scheduling";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Fetch the data and store it in an array
  $rows = [];
  while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
  }

  // Encode the array as JSON and echo it
  echo json_encode($rows);

} else {
  echo json_encode(["error" => "No data found"]);
}
;


$conn->close();
?>
