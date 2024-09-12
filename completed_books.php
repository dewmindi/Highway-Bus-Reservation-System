<?php
session_start();
include 'header.php'; // Include the header to add the CSS and JS files
include 'db_connect.php'; // Include the database connection

// Get today's date
$today = date('Y-m-d H:i:s', strtotime('now'));

// Query to get completed bookings
$completed_bookings_query = "
    SELECT * FROM booked 
    WHERE booked_placed_at < '$today' 
    AND booked_for < '$today'
";

$completed_bookings = $conn->query($completed_bookings_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Bookings</title>
    <?php include 'header.php'; // Include the header to add the CSS and JS files ?>
    <style>
         body {
            font-family: 'Roboto', sans-serif;
        }
        .container {
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
        <h1>Completed Bookings</h1>
        <?php if ($completed_bookings->num_rows > 0): ?>
            <?php while ($row = $completed_bookings->fetch_assoc()): ?>
                <?php 
                    $booked_for = date('M d, Y h:i A', strtotime($row['booked_for']));
                    $booked_placed_at = date('M d, Y h:i A', strtotime($row['booked_placed_at']));
                ?>
                <div>
                    <div class="details">
                        <table>
                            <tr><th>Reference Number:</th><td><?php echo htmlspecialchars($row['ref_no']); ?></td></tr>
                            <tr><th>Name:</th><td><?php echo htmlspecialchars($row['name']); ?></td></tr>
                            <tr><th>Quantity:</th><td><?php echo htmlspecialchars($row['qty']); ?></td></tr>
                            <tr><th>Email:</th><td><?php echo htmlspecialchars($row['email']); ?></td></tr>
                            <tr><th>NIC:</th><td><?php echo htmlspecialchars($row['nic']); ?></td></tr>
                            <tr><th>Bus Number:</th><td><?php echo htmlspecialchars($row['bus_number']); ?></td></tr>
                            <tr><th>From Location:</th><td><?php echo htmlspecialchars($row['from_location']); ?></td></tr>
                            <tr><th>To Location:</th><td><?php echo htmlspecialchars($row['to_location']); ?></td></tr>
                            <tr><th>Booked For:</th><td><?php echo $booked_for; ?></td></tr>
                            <tr><th>Booked Placed At:</th><td><?php echo $booked_placed_at; ?></td></tr>
                        </table>
                    </div>
                </div>   
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-bookings">No completed bookings found.</div>
        <?php endif; ?>
    </div>
</body>
</html>
