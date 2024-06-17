<?php
include 'db.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if(isset($data['subject']) && isset($data['year']) && isset($data['course_code']) && isset($data['checked'])) {
        $subject = $data['subject'];
        $year = $data['year'];
        $course_code = $data['course_code'];
        $checked = $data['checked'];
         // Retrieve the checkbox state

        // Check if a record with the same subject, year, and course code exists
        $stmt_check = $conn->prepare("SELECT * FROM new_curriculum WHERE Subject = ? AND Year = ? AND course_code = ?");
        $stmt_check->bind_param("sis", $subject, $year, $course_code);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if($result_check->num_rows === 1) {
            // Record exists, update the checked field
            $stmt_update = $conn->prepare("UPDATE new_curriculum SET checked = ? WHERE Subject = ? AND Year = ? AND course_code = ?");
            $stmt_update->bind_param("isss", $checked, $subject, $year, $course_code);
            $stmt_update->execute();
            $stmt_update->close();
        } elseif ($result_check->num_rows === 0) {
            // Record does not exist, insert a new record
            $stmt_insert = $conn->prepare("INSERT INTO new_curriculum (Subject, Year, course_code, checked, semester) VALUES (?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("sisii", $subject, $year, $course_code, $checked, $semester);
            $stmt_insert->execute();
            $stmt_insert->close();
        } else {
            // More than one record exists (this should not happen)
            $response['error'] = "Multiple records found for the same subject, year, and course code combination.";
        }

        // Close statement
        $stmt_check->close();

        // Set success message in the response array
        $response['success'] = "Checkbox data updated successfully";
    } else {
        $response['error'] = "Subject, year, course code, or checkbox state not provided";
    }
} else {
    $response['error'] = "Method not allowed";
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();


