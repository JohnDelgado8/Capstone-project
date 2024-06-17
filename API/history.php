<?php
header('Access-Control-Allow-Origin: http://localhost:9000');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data)) {
        $user_id = $data['id'];
        $details = json_encode($data); // Convert the edited fields to JSON format

        $sql = "INSERT INTO history_log (user_id, action, details) VALUES ('$user_id', 'User Update', '$details')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Edited details saved to history log successfully"]);
        } else {
            echo json_encode(["error" => "Error saving edited details to history log: " . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Invalid data provided"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>
