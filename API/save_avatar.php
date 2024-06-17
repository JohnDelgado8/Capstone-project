<?php
// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header('Access-Control-Allow-Origin: http://localhost:9000');
  header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Access-Control-Allow-Credentials: true');
  exit;
}

// Include database connection
include "db.php";

// Handle file upload
if (isset($_FILES['avatar']) && isset($_POST['email'])) {
  $email = $_POST['email'];
  $avatarData = $_FILES['avatar'];

  // Specify the upload directory
  $uploadDir = 'uploads/';
  $avatarPath = $uploadDir . basename($avatarData['name']);

  // Move the uploaded file to the specified directory
  if (!move_uploaded_file($avatarData['tmp_name'], $avatarPath)) {
    // Handle file moving error
    echo json_encode(array('error' => 'Failed to move uploaded file'));
    exit;
  }

  // Update the user's avatar path in the database
  $sql = "UPDATE new_scheduling SET avatar = ? WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $avatarPath, $email);
  if ($stmt->execute()) {
    // Avatar path updated successfully
    echo json_encode(array('success' => true, 'avatar_path' => $avatarPath));
  } else {
    // Error updating avatar path
    echo json_encode(array('error' => 'Failed to update avatar path'));
  }
  $stmt->close();
} else {
  // No avatar file or email received
  header("HTTP/1.1 400 Bad Request");
  echo json_encode(array('error' => 'No avatar file or email received'));
}

// Close the database connection
$conn->close();
?>
