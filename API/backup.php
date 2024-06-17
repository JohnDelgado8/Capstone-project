<?php

include "db.php";
require 'vendor/autoload.php';
session_start();
use Ifsnop\Mysqldump as IMysqldump;

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
    die(json_encode(['success' => false, 'message' => 'Database connection error']));
}

$data = json_decode(file_get_contents('php://input'), true);

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'capstone';
try{
    $dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$database", $username, $password);
    $outputFile = 'backup_' . date("Y-m-d") . '.sql';
    $dump->start($outputFile);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $outputFile . '"');

    $content = file_get_contents($outputFile);
    $response = ['status' => 'success', 'content' => $content];
    echo json_encode($response);
    // Delete the file from the local storage
    unlink($outputFile);
    exit;

}catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
$conn->close();
?>
