<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Initialize the response array
$response = array();

// Get the data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

// Check if 'email' is set and not empty
if (isset($data->email) && !empty($data->email)) {
    // Get the user's ID based on the email
    $getUserIDQuery = "SELECT id FROM new_scheduling WHERE email = ?";
    $stmtUserID = $conn->prepare($getUserIDQuery);
    $stmtUserID->bind_param('s', $data->email);
    $stmtUserID->execute();
    $resultUserID = $stmtUserID->get_result();

    // Check if any rows were returned
    if ($resultUserID->num_rows > 0) {
        $userRow = $resultUserID->fetch_assoc();
        $userID = $userRow['id'];

        // Check if 'subjectname' is set and not empty
        if(isset($data->newEvent->subjectname) && !empty($data->newEvent->subjectname)) {
            // Format time_from and time_to as "HH:mm"
            $time_from = date('H:i', strtotime($data->newEvent->time_from));
            $time_to = date('H:i', strtotime($data->newEvent->time_to));

            // Prepare the SQL statement for event insertion
            $sql = "INSERT INTO schedule (new_scheduling_id, instructor, block, year, subjectname, course, type, day, room, time_from, time_to, school_year, semester, building, units) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($sql);

            $instructor = $data->newEvent->instructor->value;
            $subjectname = $data->newEvent->subjectname->value;
            $school_year = $data->newEvent->school_year;




            // Bind parameters
            $stmt->bind_param('isssssssssssssi', $userID, $instructor, $data->newEvent->block, $data->newEvent->year, $subjectname, $data->newEvent->course,  $data->newEvent->type, $data->newEvent->day, $data->newEvent->room, $time_from, $time_to, $school_year, $data->newEvent->semester,  $data->newEvent->building, $data->newEvent->units );

            // Execute the statement
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Event inserted successfully";
            } else {
                $response['success'] = false;
                $response['message'] = "Error inserting event";
            }
        } else {
            // Handle the case where 'subjectname' is not provided or empty
            $response['success'] = false;
            $response['message'] = "Subject name is required";
        }
    } else {
        // Handle the case where user ID is not found
        $response['success'] = false;
        $response['message'] = "User not found";
    }
} else {
    // Handle the case where email is not provided or empty
    $response['success'] = false;
    $response['message'] = "Email is required";
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
