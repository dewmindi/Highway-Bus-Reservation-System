<?php
session_start();
include 'header.php';
include 'db_connect.php'; // Include the database connection

// Retrieve the logged-in username from the session
$username = $_SESSION['username'];

// Query to fetch all canceled bookings by the logged-in user
$query = "SELECT * FROM canceled WHERE username = ? ORDER BY booked_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$canceledBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Canceled</title>
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

        .no-bookings {
            text-align: center;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>

<body>
<?php include 'passenger_navbar.php'; // Include the navigation bar ?>
    <div class="container">
        <h1>Booking Canceled</h1>
        <?php if (!empty($canceledBookings)) : ?>
            <?php foreach ($canceledBookings as $booking) : ?>
                <div class="details">
                    <table>
                        <tr><th>Reference Number:</th><td><?php echo htmlspecialchars($booking['ref_no']); ?></td></tr>
                        <tr><th>Passenger:</th><td><?php echo htmlspecialchars($booking['name']); ?></td></tr>
                        <tr><th>Departure Location:</th><td><?php echo htmlspecialchars($booking['departure_location']); ?></td></tr>
                        <tr><th>Arrival Location:</th><td><?php echo htmlspecialchars($booking['arrival_location']); ?></td></tr>
                        <tr><th>Reserved For:</th><td><?php echo date('M d, Y h:i A', strtotime($booking['date'])); ?></td></tr>
                        <tr><th>Booked At:</th><td><?php echo date('M d, Y h:i A', strtotime($booking['booked_at'])); ?></td></tr>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-bookings">
                <p>No canceled bookings found.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
