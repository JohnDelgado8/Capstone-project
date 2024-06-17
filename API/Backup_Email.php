<?php

include "db.php";
require 'vendor/autoload.php';
require_once(__DIR__ . '/sendinblue/vendor/autoload.php');
session_start();
use Ifsnop\Mysqldump as IMysqldump;

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json');
    header("HTTP/1.1 200 OK");
    exit();
}
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    die(json_encode(['success' => false, 'message' => 'Database connection error']));
}

$data = json_decode(file_get_contents('php://input'), true);



$host = 'localhost';
$username = 'root';
$password = '';
$database = 'capstone';

try{
    $email = $_POST['email'];
    $dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$database", $username, $password);
    $outputFile = 'backup_' . date("Y-m-d") . '.sql';
    $dump->start($outputFile);

    $zip = new ZipArchive();
    $zipFileName = 'backup_' . date("Y-m-d") . '.zip';
    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        $zip->addFile($outputFile);
        $zip->close();
    } else {
        throw new Exception("Failed to create zip file");
    }
    $content = file_get_contents($zipFileName);

    $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
    $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
        new GuzzleHttp\Client(),
        $credentials
    );

    $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
        'subject' => 'Backup Data (.SQL)',
        'sender' => ['name' => 'Delgado Email', 'email' => 'djohnrodolfo@gmail.com'],
        'replyTo' => ['name' => 'Sendinblue', 'email' => 'no-reply@gmail.com'],
        'to' => [['email' => $email]],
        'htmlContent' => 'sql file', // message params
        'attachment' => [['content' => base64_encode($content), 'name' => $zipFileName]],

        'params' => ['bodyMessage' => "test"]
    ]);
    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);

    unlink($outputFile);
    unlink($zipFileName);
    exit;

}catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
$conn->close();
?>
