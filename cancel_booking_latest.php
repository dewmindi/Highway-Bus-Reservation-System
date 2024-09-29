<?php
session_start();
require 'vendor/autoload.php';

use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;

include 'db_connect.php'; // Include the database connection

header('Content-Type: application/json');

// For debugging: enable error reporting (remove in production)
ini_set('display_errors', 0);  // Set to 1 for development or 0 for production
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if json_decode failed
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
        exit;
    }

    $ref_no = $data['ref_no'];
    $name = $data['name'];
    $departure_location = $data['departure_location'];
    $arrival_location = $data['arrival_location'];
    $date = $data['date'];
    $booked_at = $data['booked_at'];
    $username = $data['username'];

    try {

        // Debugging: Log input values
        error_log("Date: " . $date . "\n", 3, 'error_log.txt');
        error_log("Booked At: " . $booked_at . "\n", 3, 'error_log.txt');

        // Convert date to the correct format using strtotime
        $formatted_date = date('Y-m-d H:i:s', strtotime($date));
        $formatted_booked_at = date('Y-m-d H:i:s', strtotime($booked_at));

        // Debugging: Log formatted date values
        error_log("Formatted Date: " . $formatted_date . "\n", 3, 'error_log.txt');
        error_log("Formatted Booked At: " . $formatted_booked_at . "\n", 3, 'error_log.txt');
        
        // Begin transaction
        $pdo->beginTransaction();

        // Fetch the email associated with the booking reference number
        $stmt = $pdo->prepare("SELECT email FROM booked WHERE ref_no = ?");
        $stmt->execute([$ref_no]);
        $booking_info = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $booking_info['email'];

        if (!$email) {
            throw new Exception('Email not found for the given reference number');
        }

        // Insert into canceled table
        $stmt = $pdo->prepare("
            INSERT INTO canceled (ref_no, name, departure_location, arrival_location, date, booked_at, username)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$ref_no, $name, $departure_location, $arrival_location, $formatted_date, $formatted_booked_at, $username]);

        // Delete from booked table
        $stmt = $pdo->prepare("DELETE FROM booked WHERE ref_no = ?");
        $stmt->execute([$ref_no]);

        // $update_seat_sql = "UPDATE $bus_number SET availability = 1 WHERE seat_id = ?";
        // $stmt = $pdo->prepare($update_seat_sql);
        // $stmt->execute([$seat_id]);

        // Commit transaction
        $pdo->commit();

        // Sendinblue email sending
        $apiKey = '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'; // Replace with your actual Sendinblue API key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
        $apiInstance = new TransactionalEmailsApi(new GuzzleHttp\Client(), $config);

        $emailContent = new SendSmtpEmail([
            'subject' => 'Booking Cancellation',
            'sender' => ['name' => 'SLTB', 'email' => 'sltb@gmail.com'],
            'to' => [['email' => $email, 'name' => $name]],
            'htmlContent' => '
            <html><body>
                <h1>Booking Cancellation</h1>
                <div style="display:flex"> 
                    <p>Your booking reference number is:</p>
                    <p style="font-weight: bold">'.$ref_no.'</p>
                </div>
                <div style="display:flex"> 
                    <p>Passenger Name: </p>
                    <p style="font-weight: bold">'.$name.'</p>
                </div>
            </body></html>',
            'textContent' => 'Booking Cancelled - Your booking reference number is '.$ref_no
        ]);

        try {
            $result = $apiInstance->sendTransacEmail($emailContent);
            echo json_encode(['success' => true, 'email_status' => 'Email sent successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => true, 'email_status' => 'Email sending failed: ' . $e->getMessage()]);
        }

    } catch (Exception $e) {
        // Rollback transaction in case of error
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>