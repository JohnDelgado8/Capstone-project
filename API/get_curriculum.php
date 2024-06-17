<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'db.php';

// Check if department is provided
if(isset($_GET['department'])) {
    $department = $_GET['department'];

    // Query to retrieve curriculum data based on department
    $sql = "SELECT DISTINCT Year, Subject, user_id, course_code, checked, units
            FROM new_curriculum
            INNER JOIN new_scheduling ON new_curriculum.user_id = new_scheduling.id
            WHERE new_scheduling.department = '$department'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch curriculum data from the result
        $response = array();
        while ($row = $result->fetch_assoc()) {
            $response[] = array(
                'Year' => $row['Year'],
                'Subject' => $row['Subject'],
                'user_id' => $row['user_id'],
                'course_code' => $row['course_code'],
                'checked' => $row['checked'],
                'units' => $row['units']
            );
        }

        // Send JSON response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // If no curriculum data found for the department, return an error message
        $response = array(
            'error' => 'No curriculum data found for the department'
        );

        // Send JSON response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // If department is not provided in the request, return an error message
    $response = array(
        'error' => 'Department is required'
    );

    // Send JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
