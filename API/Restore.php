<?php

include "db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json');
    header("HTTP/1.1 200 OK");
    exit();
}

if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    die(json_encode(['status' => 'fail', 'message' => 'Database connection error']));
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_FILES['sql_file'])) {
    $fileData = $_FILES['sql_file'];

    if ($fileData['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $fileData['tmp_name'];
        $sqlCommands = file_get_contents($tmpFilePath);

        $mysqli = new mysqli('localhost', 'root', '', 'new_test');

        if ($mysqli->connect_error) {
            http_response_code(500); // Internal Server Error
            die(json_encode(['status' => 'fail', 'message' => 'Connection failed: ' . $mysqli->connect_error]));
        }

        if ($mysqli->multi_query($sqlCommands)) {
            $response = ['status' => 'success', 'message' => 'SQL data restored successfully.'];
        } else {
            http_response_code(500); // Internal Server Error
            $response = ['status' => 'fail', 'message' => 'Error restoring SQL data: ' . $mysqli->error];
        }

        $mysqli->close();
    } else {
        http_response_code(400); // Bad Request
        $response = ['status' => 'fail', 'message' => 'File upload error: ' . $fileData['error']];
    }
} else {
    http_response_code(400); // Bad Request
    $response = ['status' => 'fail', 'message' => 'No file uploaded.'];
}

echo json_encode($response);
$conn->close();
exit;
?>
