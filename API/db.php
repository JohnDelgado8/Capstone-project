<?php
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS,");
header("Access-Control-Allow-Headers: Content-Type");


$conn = new mysqli("localhost", "id22073801_john", "Stiflertastic08!", "id22073801_capstone");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
