<?php

header('Access-Control-Allow-Origin: http://localhost:9000');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

header("Content-Type: application/json");

// Check if data is received properly
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
  // Handle case where data is not received properly
  echo json_encode(["success" => false, "message" => "Data is not received properly"]);
  exit;
}

// Ensure required fields are present
$requiredFields = ['fullname', 'department', 'position', 'email', 'password'];
foreach ($requiredFields as $field) {
  if (!isset($data[$field]) || empty($data[$field])) {
    // Handle case where required field is missing or empty
    echo json_encode(["success" => false, "message" => "Required field '$field' is missing or empty"]);
    exit;
  }
}

$fullname = $data['fullname'];
$department = $data['department'];
$position = $data['position'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

// Additional field for course
$course = ($position === "Instructor" && isset($data['course'])) ? $data['course'] : null;

$stmt = $conn->prepare("INSERT INTO new_scheduling (fullname, department, position, email, password, course) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $fullname, $department, $position, $email, $password, $course);

try {
  // Execute the SQL statement
  $stmt->execute();

  // Check if the user was successfully registered
  if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true, "message" => "User registered successfully"]);
  } else {
    echo json_encode(["success" => false, "message" => "User registration failed"]);
  }
} catch (mysqli_sql_exception $e) {
  // Handle SQL exception
  echo json_encode(["success" => false, "message" => "Error registering user: " . $e->getMessage()]);
}

// Close the statement and database connection
$stmt->close();
$conn->close();

?>
