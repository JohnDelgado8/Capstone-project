<?php

include "db.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Access-Control-Max-Age: 86400'); // 1 day
  header("HTTP/1.1 200 OK");
  exit();
}

// Check for database connection error
if ($conn->connect_error) {
  http_response_code(500); // Internal Server Error
  die(json_encode(['success' => false, 'message' => 'Database connection error']));
}

$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'];
$password = $data['password'];



$sql = sprintf("SELECT * FROM new_scheduling WHERE email = '%s'", $conn->real_escape_string($email));

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $hashedPasswordFromDB = $row['password'];
  $status = $row['status'];
  $position = $row['position'];
  $department = $row['department'];
  $course = $row['course'];



  if (password_verify($password, $hashedPasswordFromDB)) {
    if ($status === 'active') {
      $_SESSION['user'] = $email;
      $_SESSION['position'] = $position;
      $_SESSION['course'] = $course;
      // Insert login record into history log


      echo json_encode(['success' => true, 'position' => $position, 'department' => $department, 'course' => $course]);
    } else {

      echo json_encode(['success' => false, 'message' => 'Inactive user']);
    }
  } else {

    echo json_encode(['success' => false, 'message' => 'Wrong password']);
  }
} else {

  echo json_encode(['success' => false, 'message' => 'User not found']);
}


// Handle session appropriately for your application needs

$conn->close();
?>
