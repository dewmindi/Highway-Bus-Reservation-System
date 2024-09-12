<?php
session_start();
include 'db_connect.php'; // Include the database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

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

        // Insert into canceled table
        $stmt = $pdo->prepare("
            INSERT INTO canceled (ref_no, name, departure_location, arrival_location, date, booked_at, username)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$ref_no, $name, $departure_location, $arrival_location, $formatted_date, $formatted_booked_at, $username]);

        // Delete from booked table
        $stmt = $pdo->prepare("DELETE FROM booked WHERE ref_no = ?");
        $stmt->execute([$ref_no]);

        // Commit transaction
        $pdo->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback transaction
        $pdo->rollBack();

        // Log the error to a file or display it for debugging purposes
        error_log($e->getMessage(), 3, 'error_log.txt'); // Log error to a file

        echo json_encode(['success' => false, 'message' => 'Failed to cancel the booking.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
