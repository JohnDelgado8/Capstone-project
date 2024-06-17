<?php
include "db.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Access-Control-Max-Age: 86400'); // 1 day
  header("HTTP/1.1 200 OK");
  exit();
}

require_once(__DIR__ . '/sendinblue/vendor/autoload.php');


$requestBody = file_get_contents('php://input');

// I-decode ang JSON na request body upang makuha ang data
$requestData = json_decode($requestBody);

// Check if email is provided in the POST request
if (!isset($requestData->email) || empty($requestData->email)) {
  http_response_code(400); // Bad Request
  echo json_encode(['error' => 'Email address is missing']);
  exit;
}
$email = $requestData->email;

$otp = mt_rand(100000, 999999);

$firstQuery = "SELECT * FROM new_scheduling WHERE email = '$email'";
$firstresult = $conn->query($firstQuery);
if($firstresult){
    if ($firstresult->num_rows > 0) {
        $row = $firstresult->fetch_assoc();
        $userid = $row['id'];

        // Second Query verify if the otp_table meron data ng user
        $secondQuery = "SELECT * FROM otp_table WHERE Userid = $userid";
        $secondResult = $conn->query($secondQuery);

        if ($secondResult) {
          if ($secondResult->num_rows > 0) {
              // Update the table if a record already exists
              $updateQuery = "UPDATE otp_table SET Otp_Code = ? WHERE Userid = ?";
              $stmt = $conn->prepare($updateQuery);
              $stmt->bind_param("ii", $otp, $userid);
              $stmt->execute();

              if ($stmt->affected_rows > 0) {
                  echo json_encode(['success' => true, 'message' => 'OTP record updated successfully']);
              } else {
                  echo json_encode(['success' => false, 'message' => 'Error updating OTP record']);
              }
          } else {
              // Insert a new OTP record
              date_default_timezone_set('Asia/Singapore');
              $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));
              $insertQuery = "INSERT INTO otp_table (Userid, Otp_Code, expiration) VALUES (?, ?, ?)";
              $stmt = $conn->prepare($insertQuery);
              $stmt->bind_param("iss", $userid, $otp, $expiration);
              $stmt->execute();

              if ($stmt->affected_rows > 0) {
                  echo json_encode(['success' => true, 'message' => 'New OTP record inserted successfully']);
              } else {
                  echo json_encode(['success' => false, 'message' => 'Error inserting new OTP record']);
              }
          }
      } else {
          echo json_encode(['success' => false, 'message' => 'Error executing second query']);
      }

    }
}else{
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
$apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
    new GuzzleHttp\Client(),
    $credentials
);

$sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
    'subject' => 'Verification Code',
    'sender' => ['name' => 'Delgado Email', 'email' => 'djohnrodolfo@gmail.com'],
    'replyTo' => ['name' => 'Sendinblue', 'email' => 'no-reply@gmail.com'],
    'to' => [['name' => 'Test Recipient', 'email' => $email]],
    'htmlContent' => 'Your OTP is: ' . $otp, // Include OTP in the email content

    'params' => ['bodyMessage' => "test"]
]);
$result = $apiInstance->sendTransacEmail($sendSmtpEmail);

?>
