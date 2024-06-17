<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header("Access-Control-Allow-Origin: http://localhost:9000");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type");
  exit;
}

include "db.php";

// Validate and sanitize user input
$userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);

if ($userId === false || $status === null) {
  echo json_encode(["error" => "Invalid input"]);
  exit;
}

// Get the current status and email of the user before the update
$sqlGetUser = "SELECT status, email FROM new_scheduling WHERE id = $userId";
$resultGetUser = $conn->query($sqlGetUser);

if ($resultGetUser && $resultGetUser->num_rows > 0) {
  $row = $resultGetUser->fetch_assoc();
  $currentStatus = $row['status'];
  $email = $row['email'];
} else {
  echo json_encode(["error" => "Error fetching current status"]);
  exit;
}

// Update the user status in the database
$sqlUpdateStatus = "UPDATE new_scheduling SET status = '$status' WHERE id = $userId";
$resultUpdateStatus = $conn->query($sqlUpdateStatus);

if ($resultUpdateStatus) {
  // Log the status change in the history log table
  $action = ($status === 'active') ? 'Activated' : 'Deactivated';
  $timestamp = date('Y-m-d H:i:s');

  $sqlLog = "INSERT INTO history_log (action, email, timestamp) VALUES ('$action', '$email', '$timestamp')";
  $resultLog = $conn->query($sqlLog);

  if ($resultLog) {
    echo json_encode(["message" => "Status updated successfully"]);
  } else {
    echo json_encode(["error" => "Error logging status change"]);
  }
} else {
  echo json_encode(["error" => "Error updating status"]);
}

$conn->close();
?>
