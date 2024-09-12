<?php
session_start();
include 'header.php'; // Include the header to add the CSS and JS files
include 'db_connect.php'; // Include the database connection

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    try {
        // Prepare and execute a SQL query to select all booking details for the logged-in user
        $stmt = $pdo->prepare("
            SELECT 
                b.ref_no, 
                b.name,
                b.booked_placed_at, 
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
            WHERE b.booking_username = ?
            ORDER BY b.booked_placed_at DESC
        ");
        $stmt->execute([$username]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are any bookings
        if (!$bookings) {
            $error = 'No bookings found for your account.';
        }
    } catch (PDOException $e) {
        // Handle database errors
        $error = 'Error retrieving booking details: ' . $e->getMessage();
    }
} else {
    $error = 'You must be logged in to view your bookings.';
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
        .container {
            padding: 20px;
            color: grey;
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
        .cancel-button {
            margin-top: 10px;
            
            
        }

        .cancel-button button {
            
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .cancel-button button:hover {
            background-color: #c82333;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .modal-content h2 {
            margin: 0 0 20px 0;
            color: #007bff;
            font-weight: bold;
            text-align: center;
        }

        .modal-buttons {
            display: flex;
            
        }

        .modal-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-buttons .yes-button {
            background-color: #007bff;
            color: #007bff;
            color: white;
            margin-left: 100px;
        }

        .modal-buttons .no-button {
            background-color: #dc3545;
            color: white;
            margin-left: 100px;
            margin-right: 50px;
        }

        .loading-spinner {
            display: none;
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 60px;
            height: 60px;
            animation: spin 10s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        function showCancelModal(ref_no) {
            var modal = document.getElementById('cancelModal');
            var yesButton = document.getElementById('yesCancelButton');

            yesButton.onclick = function() {
                cancelBooking(ref_no);
            };

            modal.style.display = 'block';
        }

        function cancelBooking(ref_no) {
            var modalContent = document.querySelector('.modal-content');
            var loadingSpinner = document.getElementById('loadingSpinner');

            modalContent.style.display = 'none';
            loadingSpinner.style.display = 'block';

            setTimeout(function() {
                fetch('cancel_booking.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ref_no: ref_no }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'canceled.php?ref_no=' + ref_no;
                    } else {
                        alert('Failed to cancel booking: ' + data.error);
                        modalContent.style.display = 'block';
                        loadingSpinner.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while cancelling the booking.');
                    modalContent.style.display = 'block';
                    loadingSpinner.style.display = 'none';
                });
            },1000); // Adjust this value for longer loading time
        }

        function closeModal() {
            var modal = document.getElementById('cancelModal');
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('cancelModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <?php include 'passenger_navbar.php'; // Include the navigation bar ?>

    <div class="container">
        <h1>Your Booking Details</h1>
        <?php if (isset($error)): ?>
            <div class="no-bookings"><?php echo $error; ?></div>
        <?php elseif (isset($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
                <?php 
                    $departure_location = $booking['from_terminal'] . ' ' . $booking['from_city'] . ' ' . $booking['from_state'];
                    $arrival_location = $booking['to_terminal'] . ' ' . $booking['to_city'] . ' ' . $booking['to_state'];
                    $date = date('M d, Y h:i A', strtotime($booking['departure_time']));
                    $name = htmlspecialchars($booking['name']);
                    $reference_no = htmlspecialchars($booking['ref_no']);
                    $booked_at = date('M d, Y h:i A', strtotime($booking['booked_placed_at']));
                ?>
                <div class="details" style="display:flex">
                    <table>
                        <tr><th>Reference Number:</th><td><?php echo $reference_no; ?></td></tr>
                        <tr><th>Passenger:</th><td><?php echo $name; ?></td></tr>
                        <tr><th>Departure Location:</th><td><?php echo $departure_location; ?></td></tr>
                        <tr><th>Arrival Location:</th><td><?php echo $arrival_location; ?></td></tr>
                        <tr><th>Reserved For:</th><td><?php echo $date; ?></td></tr>
                        <tr><th>Booked At:</th><td><?php echo $booked_at; ?></td></tr>
                    </table>
                    <div class="cancel-button">
                        <button class="btn btn-sm btn-info mr-2 text-white" onclick="showCancelModal('<?php echo $reference_no; ?>')">Cancel</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

        <!-- Cancel Modal -->
        <div id="cancelModal" class="modal">
        <div class="modal-content">
            <h2>Are you sure?</h2>
            <h5 style="text-align:center">You'll recieve 50% from the payment</h5>
            <div class="modal-buttons">
                <button class="yes-button" id="yesCancelButton">Yes</button>
                <button class="no-button" onclick="closeModal()">No</button>
            </div>
        </div>
        <div id="loadingSpinner" class="loading-spinner"></div>
    </div>
</body>

</html>
