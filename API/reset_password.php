<?php

header('Access-Control-Allow-Origin: http://localhost:9000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
session_start();
include "db.php"; // Include your database connection file

// Retrieve the provided email and new password from the request
$email = $_POST['email'];
$newPassword = $_POST['newPassword'];

// Update the password for the user associated with the provided email
$sql = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";

if ($conn->query($sql) === TRUE) {
    // Password reset successful
    echo json_encode(['success' => true]);
} else {
    // Password reset failed
    echo json_encode(['success' => false, 'message' => 'Failed to reset password']);
}

$conn->close();
?>
