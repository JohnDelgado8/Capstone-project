<?php
include "db.php";

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Start session
session_start();

// Get the OTP from the request body
$requestBody = file_get_contents('php://input');
$requestData = json_decode($requestBody);

if(isset($requestData->otp) && isset($requestData->email)) {
    $email = $requestData->email; // Get the user's email from the request

    // Query to retrieve Userid based on email from new_scheduling table
    $sqlEmail = "SELECT * FROM new_scheduling WHERE email = ?";
    $stmtEmail = $conn->prepare($sqlEmail);
    $stmtEmail->bind_param("s", $email);
    $stmtEmail->execute();
    $resultEmail = $stmtEmail->get_result();

    if ($resultEmail->num_rows > 0) {
        // Fetch Userid
        $rowEmail = $resultEmail->fetch_assoc();
        $userid = $rowEmail["id"];



        // Prepare and execute query to fetch OTP from otp_table based on the Userid
        $sqlOTP = "SELECT * FROM otp_table WHERE Userid = ?";
        $stmtOTP = $conn->prepare($sqlOTP);
        $stmtOTP->bind_param("i", $userid); // Assuming Userid is an integer
        $stmtOTP->execute();
        $resultOTP = $stmtOTP->get_result();
        if ($resultOTP->num_rows > 0) {
            $rowOTP = $resultOTP->fetch_assoc();
            $storedOTP = $rowOTP["Otp_Code"];
            $expiration = strtotime($rowOTP["expiration"]);
            $current_time = time();
            // echo json_encode([
            //                   'Current' => $current_time,
            //                   'Expiration' => $expiration,
            //                 ]);

            // // Check if expiration time has passed
            if ($expiration < $current_time) {
                echo json_encode(['success' => false, 'message' => 'OTP has expired']);
                exit;
              } else {
                $enteredOTP = $requestData->otp;

                // Verify the entered OTP against the stored OTP
                if ((int)$enteredOTP === $storedOTP) {
                    // OTP verification successful
                    echo json_encode(['success' => true]);
                } else {
                    // Invalid OTP
                    echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
                }
            }
        } else {
            // Close the result set and statement for the OTP query
            $resultOTP->close();
            $stmtOTP->close();

            // OTP not found for the specified Userid
            echo json_encode(['data' => $email, 'message' => 'OTP not found for the user']);
        }
    } else {
        // Email not found in new_scheduling table
        echo json_encode(['success' => false, 'message' => 'Email not found']);
    }
} else {
    // OTP or email not received
    echo json_encode(['success' => false, 'message' => 'OTP or email not provided']);
}

// Close database connection
$conn->close();
?>
