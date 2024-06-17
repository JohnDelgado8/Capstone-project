<?php
// Enable CORS for all origins
header("Access-Control-Allow-Origin: *");

// Allow only specific methods for preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Length: 0");
    header("HTTP/1.1 204 No Content");
    exit;
}

// Include your database connection file
include 'db.php';

// Check if it's a DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the event ID from the query parameters
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id === null) {
        header("HTTP/1.1 400 Bad Request");
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(array('error' => 'Missing event ID'));
        exit;
    }

    // Prepare and execute the SQL DELETE query
    $sql = "DELETE FROM schedule WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    // Check if the deletion was successful
    if ($result) {
        // Send a success response
        echo json_encode(array('success' => true));
    } else {
        // Send an error response
        header("HTTP/1.1 500 Internal Server Error");
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(array('success' => false, 'message' => 'Failed to delete event'));
        error_log("Failed to execute DELETE query: " . $stmt->error);
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If it's not a DELETE request, send an error response
    header("HTTP/1.1 405 Method Not Allowed");
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(array('error' => 'Method Not Allowed'));
    error_log("Received request with method other than DELETE: " . $_SERVER['REQUEST_METHOD']);
}
?>
