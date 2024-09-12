<?php
session_start();
include 'db_connect.php'; // Include the database connection

if (isset($_POST['date']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $date = $_POST['date'];

    try {
        // Prepare and execute a SQL query to select booking details for the logged-in user and selected date
        $stmt = $pdo->prepare("
            SELECT 
                b.ref_no, 
                b.name, 
                b.qty, 
                s.departure_time, 
                l_from.terminal_name AS from_terminal, 
                l_from.city AS from_city, 
                l_from.state AS from_state, 
                l_to.terminal_name AS to_terminal, 
                l_to.city AS to_city, 
                l_to.state AS to_state 
            FROM booked b
            INNER JOIN schedule_list s ON b.schedule_id = s.id
            INNER JOIN location l_from ON s.from_location = l_from.id
            INNER JOIN location l_to ON s.to_location = l_to.id
            WHERE b.booking_username = ? AND DATE(s.departure_time) = ?
            ORDER BY s.departure_time DESC
        ");
        $stmt->execute([$username, $date]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are any bookings
        if ($bookings) {
            foreach ($bookings as $booking) {
                $departure_location = $booking['from_terminal'] . ' ' . $booking['from_city'] . ' ' . $booking['from_state'];
                $arrival_location = $booking['to_terminal'] . ' ' . $booking['to_city'] . ' ' . $booking['to_state'];
                $date = date('M d, Y h:i A', strtotime($booking['departure_time']));
                $name = htmlspecialchars($booking['name']);
                $qty = htmlspecialchars($booking['qty']);
                $reference_no = htmlspecialchars($booking['ref_no']);
                
                echo "
                <div class='details'>
                    <table>
                        <tr><th>Reference Number:</th><td>$reference_no</td></tr>
                        <tr><th>Passenger:</th><td>$name</td></tr>
                        <tr><th>Reserved No of Seats:</th><td>$qty</td></tr>
                        <tr><th>Departure Location:</th><td>$departure_location</td></tr>
                        <tr><th>Arrival Location:</th><td>$arrival_location</td></tr>
                        <tr><th>Date:</th><td>$date</td></tr>
                    </table>
                </div>
                ";
            }
        } else {
            echo '<div class="no-bookings">No bookings found for the selected date.</div>';
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo '<div class="no-bookings">Error retrieving bookings: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="no-bookings">Invalid request.</div>';
}
?>
