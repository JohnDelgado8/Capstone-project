<?php
// Allow requests from the specified origin
header('Access-Control-Allow-Origin: http://localhost:9000');
// Allow credentials (cookies, authorization headers, etc.)
header("Access-Control-Allow-Credentials: true");
// Specify allowed request methods
header("Access-Control-Allow-Methods: GET");
// Specify allowed request headers
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Construct the SQL query to select all history logs
    $sql = "SELECT * FROM history_log";

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch all history logs and store them in an array
        $historyLogs = [];
        while ($row = $result->fetch_assoc()) {
            // Append each row to the historyLogs array
            $historyLogs[] = [
                "id" => $row["id"],
                "user_id" => $row["user_id"],
                "action" => $row["action"],
                "details" => $row["details"],
                "timestamp" => $row["timestamp"]
            ];
        }

        // Encode the array as JSON and echo it
        echo json_encode($historyLogs);
    } else {
        // If no history logs found, return an empty array
        echo json_encode([]);
    }
} else {
    // If request method is not GET, return error message
    echo json_encode(["error" => "Invalid request method"]);
}

// Close database connection
$conn->close();
?>
