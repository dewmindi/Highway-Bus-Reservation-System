<?php
session_start();
include 'header.php'; // Include the header to add the CSS and JS files
include 'db_connect.php'; // Include the database connection

// Ensure a reference number is provided
if (isset($_GET['ref_no'])) {
    // Sanitize the input to prevent XSS attacks
    $ref_no = htmlspecialchars($_GET['ref_no']);

    try {
        // Prepare and execute a SQL query to select booking details including schedule information
        $stmt = $pdo->prepare("
            SELECT 
                b.ref_no, 
                b.name, 
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
            WHERE b.ref_no = ?
        ");
        $stmt->execute([$ref_no]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if booking exists
        if ($booking) {
            $departure_location = $booking['from_terminal'] . '' . $booking['from_city'] . '' . $booking['from_state'];
            $arrival_location = $booking['to_terminal'] . ' ' . $booking['to_city'] . '' . $booking['to_state'];
            $date = date('M d, Y h:i A', strtotime($booking['departure_time']));
            $name = htmlspecialchars($booking['name']);
            $reference_no = htmlspecialchars($booking['ref_no']);
        } else {
            $error = 'Booking not found.';
        }
    } catch (PDOException $e) {
        // Handle database errors
        $error = 'Error retrieving booking details: ' . $e->getMessage();
    }
} else {
    $error = 'Please enter a reference number to view booking details.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <?php include 'header.php'; // Include the header to add the CSS and JS files ?>
    <style>
        .container-fluid {
            padding: 20px;
        }

        h1 {
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .no-bookings {
            text-align: center;
            margin-top: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label, input, button {
            margin-bottom: 10px;
        }

        input, button {
            
            padding: 10px;
        }
        button {
            width: 200px;
            padding: 10px;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        .details {
            width: 100%;
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            padding: 10px;
            text-align: left;
        }

        .details th {
            width: 150px;
            font-weight: bold;
            color: #0056b3;
        }

        .details td {
            color: #333;
        }
        
        
    </style>
</head>

<body>
    <?php include 'passenger_navbar.php'; // Include the navigation bar ?>

    <div class="container">
        <h1>Your Booking Details</h1>
        <form id="form" method="get" action="booking_details.php">
            <label for="ref_no">Enter Reference Number:</label>
            <input type="text" id="ref_no" name="ref_no" required>
            <button type="submit">View Booking</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="no-bookings"><?php echo $error; ?></div>
        <?php elseif (isset($booking)): ?>
            <table class="details">
                <tr><th>Reference Number: <br></th><td><?php echo $reference_no; ?></td></tr>
                <tr><th>Passenger: <br></th><td><?php echo $name; ?></td></tr>
                <!-- <tr><th>Passenger: <br></th><td><?php echo $qty; ?></td></tr> -->
                <tr><th>Departure Location: <br></th><td><?php echo $departure_location; ?></td></tr>
                <tr><th>Arrival Location: <br></th><td><?php echo $arrival_location; ?></td></tr>
                <tr><th>Date: <br></th><td><?php echo $date; ?></td></tr>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>