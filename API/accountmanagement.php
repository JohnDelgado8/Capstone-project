<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header('Access-Control-Allow-Origin: http://localhost:9000');
  header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Access-Control-Allow-Credentials: true');
  exit;
}

include "db.php";

// Assuming you pass the email as a query parameter
$email = isset($_GET['email']) ? $_GET['email'] : null;

if ($email) {
  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare("SELECT id, fullname, department, position,  avatar, email, password, status FROM new_scheduling WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
  } else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["error" => "User not found"]);
  }

  $stmt->close();
} else {
  header("HTTP/1.1 400 Bad Request");
  echo json_encode(["error" => "Username not provided"]);
}

$conn->close();
?>
