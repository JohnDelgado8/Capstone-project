<?php
// Allow CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Get the data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

// Check if all required data is provided
if (!isset($data->email) || !isset($data->select_year) || !isset($data->specialization_name) ) {
    $response['success'] = false;
    $response['message'] = "Missing required data";
    echo json_encode($response);
    exit; // Terminate script execution
}

// Get the user's ID based on the email
$getUserIDQuery = "SELECT id FROM new_scheduling WHERE email = ?";
$stmtUserID = $conn->prepare($getUserIDQuery);
$stmtUserID->bind_param('s', $data->email);
$stmtUserID->execute();
$resultUserID = $stmtUserID->get_result();

// Check if user exists
if ($resultUserID->num_rows > 0) {
    $userRow = $resultUserID->fetch_assoc();
    $userID = $userRow['id'];

    // Prepare the SQL statement for specialization insertion
    $sqlInsertSpecialization = "INSERT INTO specialization (new_scheduling_id, select_year, specialization_name) VALUES (?, ?, ?)";
    $stmtInsertSpecialization = $conn->prepare($sqlInsertSpecialization);

    // Bind parameters
    $stmtInsertSpecialization->bind_param('iss', $userID, $data->select_year, $data->specialization_name);

    // Execute the statement
    $response = array();

    if ($stmtInsertSpecialization->execute()) {
        $response['success'] = true;
        $response['message'] = "Specialization saved successfully!";
        $response['userID'] = $userID; // Include user ID in the response
    } else {
        $response['success'] = false;
        $response['message'] = "Error saving specialization";
    }

    // Close the prepared statement for specialization insertion
    $stmtInsertSpecialization->close();
} else {
    $response['success'] = false;
    $response['message'] = "User not found";
}

// Close the prepared statement for user ID
$stmtUserID->close();

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
