<?php

header('Access-Control-Allow-Origin: http://localhost:9000');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

header("Content-Type: application/json");

$department = $_GET['department'];

// Fetch courses based on the selected department
$stmt = $conn->prepare("SELECT course FROM department_courses WHERE department = ?");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row['course'];
}
$stmt->close();

echo json_encode(["courses" => $courses]);

?>
