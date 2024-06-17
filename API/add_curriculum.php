<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Initialize an empty response array
$response = array();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $year = $_POST['year'];
    $subject = $_POST['subject'];
    $courseCode = $_POST['courseCode'];
    $units = $_POST['units'];
    $selectedSchoolYear = $_POST['selectedSchoolYear'];
    $semesterModel = $_POST['semesterModel'];
    $selectedCourse = $_POST['selectedCourse'];

    // Get the user's email from the session or wherever it's stored
    // For demonstration purposes, let's assume it's passed in as a parameter
    $userEmail = $_POST['user_email']; // Adjust this according to your actual implementation

    // Retrieve the user ID based on the user's email
    $getUserIDQuery = "SELECT id FROM new_scheduling WHERE email = ?";
    $stmtUserID = $conn->prepare($getUserIDQuery);
    $stmtUserID->bind_param('s', $userEmail);
    $stmtUserID->execute();
    $resultUserID = $stmtUserID->get_result();

    // Check if user ID retrieval was successful
    if ($resultUserID->num_rows > 0) {
        $row = $resultUserID->fetch_assoc();
        $userId = $row['id'];

        // Insert data into the database along with the user ID
        $insertQuery = "INSERT INTO new_curriculum (Year, Subject, course_name, course_code, units, user_id, school_year, semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->bind_param('ssssiiss', $year, $subject, $selectedCourse, $courseCode, $units, $userId, $selectedSchoolYear, $semesterModel);

        if ($stmtInsert->execute()) {
            $response['success'] = true;
        } else {
            $response['error'] = "Error inserting data into the database: " . $conn->error;
        }
    } else {
        $response['error'] = "User not found";
    }
} else {
    $response['error'] = "Invalid request method";
}

// Send the JSON response back to the client
echo json_encode($response);

// Close the database connection
$conn->close();
?>
