<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header("Access-Control-Allow-Origin: http://localhost:9000");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type");
  exit;
}

include "db.php";

// Check if the account ID is provided in the request
if (isset($_GET['id'])) {
  $accountId = $_GET['id'];

  // Fetch user information before deletion
  $stmtFetch = $conn->prepare("SELECT email FROM new_scheduling WHERE id = ?");
  $stmtFetch->bind_param("i", $accountId);
  $stmtFetch->execute();
  $stmtFetch->bind_result($email);
  $stmtFetch->fetch();
  $stmtFetch->close();

  // Use prepared statement to avoid SQL injection
  $stmtDelete = $conn->prepare("DELETE FROM new_scheduling WHERE id = ?");
  $stmtDelete->bind_param("i", $accountId);

  if ($stmtDelete->execute()) {
    // Log the action to history_log table
    $action = "Deleted User";
    $sqlHistory = "INSERT INTO history_log (action, email, timestamp) VALUES (?, ?, CURRENT_TIMESTAMP)";
    $stmtHistory = $conn->prepare($sqlHistory);
    $stmtHistory->bind_param("ss", $action, $email);
    $stmtHistory->execute();
    $stmtHistory->close();

    // Return a success message or status code
    echo json_encode(["success" => true]);
  } else {
    // Return an error message or status code
    echo json_encode(["error" => "Error deleting account"]);
  }

  $stmtDelete->close();
} else {
  // Return an error message if no account ID is provided
  echo json_encode(["error" => "No account ID provided"]);
}

$conn->close();
?>
