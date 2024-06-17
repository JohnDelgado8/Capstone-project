<?php
// Enable CORS for all origins
header("Access-Control-Allow-Origin: *");

// Allow only specific methods for preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Length: 0");
    header("HTTP/1.1 204 No Content");
    exit;
}

// Include your database connection file
include 'db.php';

// Check if it's a PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get the PUT request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the necessary data is provided
    if (empty($data['id']) || empty($data['instructor']) || empty($data['block']) || empty($data['year']) || empty($data['type']) || empty($data['room']) || empty($data['time_from']) || empty($data['time_to'])) {
        header("HTTP/1.1 400 Bad Request");
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(array('error' => 'Missing required fields'));
        exit;
    }

    // Extract event details from the request body
    $id = $data['id'];
    $instructor = $data['instructor'];
    $block = $data['block'];
    $year = $data['year'];
    $type = $data['type'];
    $room = $data['room'];
    $time_from = $data['time_from'];
    $time_to = $data['time_to'];

    // Prepare and execute the SQL UPDATE query
    $sql = "UPDATE schedule SET instructor=?, block=?, year=?, type=?, room=?,  time_from=?, time_to=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $instructor, $block, $year, $type, $room, $time_from, $time_to, $id);
    $result = $stmt->execute();

    // Check if the update was successful
    if ($result) {
        // Send a success response
        echo json_encode(array('success' => true));
    } else {
        // Send an error response
        echo json_encode(array('success' => false, 'message' => 'Failed to update event details'));
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If it's not a PUT request, send an error response
    header("HTTP/1.1 405 Method Not Allowed");
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(array('error' => 'Method Not Allowed'));
}
?>
