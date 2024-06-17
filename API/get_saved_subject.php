<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Get the selected subject from the request
$response = array();

// Insert the selected subject into the database
$sql = "SELECT Distinct subjectName FROM schedule";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Loop through each row and store room numbers in the response array
  while ($row = $result->fetch_assoc()) {
      $response[] = array(
          'subject' => $row['subjectName']
      );
  }
} else {
  // If no rows are returned, set an empty response array
  $response = array();
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
