<?php
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request to retrieve total instructor count
    $courses = ['Animation', 'Information Technology', 'Digital Marketing', 'Brand Management', 'Criminal Investigation', 'Forensic Science', 'Public Policy', 'Human Resource Management', 'Financial Management', 'MicroCredit', 'TVL Track', 'General Academic Strand'];

    // Prepare the SQL query to retrieve total instructor count for each course
    $getTotalInstructorCountQuery = "SELECT new_scheduling.course, COUNT(DISTINCT new_scheduling.id) AS totalInstructorCount
        FROM new_scheduling
        WHERE new_scheduling.course IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        GROUP BY new_scheduling.course";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($getTotalInstructorCountQuery);
    $stmt->bind_param('ssssssssssss', ...$courses);

    // Execute the query
    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Error executing the query'));
        exit();
    }

    // Get the result set
    $result = $stmt->get_result();

    // Fetch the data
    $instructorData = array();
    while ($row = $result->fetch_assoc()) {
        $instructorData[] = $row;
    }

    // Set the appropriate headers
    header('Content-Type: application/json');

    // Output the instructor data as JSON
    echo json_encode($instructorData);
} else {
    // If the request method is not GET, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
