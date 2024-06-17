<?php

// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Initialize the response array
$response = array();

// Get the data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

// Check if 'email' and 'newPassword' are set and not empty
if (isset($data->email) && !empty($data->email) && isset($data->newPassword) && !empty($data->newPassword)) {
    // Get the email and new password from the request data
    $email = $data->email;
    $newPassword = $data->newPassword;

    // Retrieve the user's ID based on the email
    $getUserIDQuery = "SELECT id FROM new_scheduling WHERE email = ?";
    $stmtUserID = $conn->prepare($getUserIDQuery);
    $stmtUserID->bind_param('s', $email);
    $stmtUserID->execute();
    $resultUserID = $stmtUserID->get_result();

    // Check if any rows were returned
    if ($resultUserID->num_rows > 0) {
        // Fetch the user's ID
        $userRow = $resultUserID->fetch_assoc();
        $userID = $userRow['id'];

        // Update the user's password
        $updatePasswordQuery = "UPDATE new_scheduling SET password = ? WHERE id = ?";
        $stmtUpdatePassword = $conn->prepare($updatePasswordQuery);

        // Hash the new password before updating
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Bind parameters and execute the update query
        $stmtUpdatePassword->bind_param('si', $hashedPassword, $userID);
        if ($stmtUpdatePassword->execute()) {
            // Password update successful
            $response['success'] = true;
            $response['message'] = "Password updated successfully";
        } else {
            // Password update failed
            $response['success'] = false;
            $response['message'] = "Failed to update password";
        }
    } else {
        // Handle the case where user with the provided email is not found
        $response['success'] = false;
        $response['message'] = "User with the provided email not found";
    }
} else {
    // Handle the case where 'email' or 'newPassword' is not provided or empty
    $response['success'] = false;
    $response['message'] = "Email and new password are required";
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
