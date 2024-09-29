<?php
session_start();
include 'header.php'; // Include the header to add the CSS and JS files
include 'db_connect.php'; // Include the database connection

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];;
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
            color: black;
            font-family: 'Roboto', sans-serif;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
        }

        .modal-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-buttons .yes-button {
            background-color: #28a745;
            color: white;
        }

        .modal-buttons .no-button {
            background-color: #dc3545;
            color: white;
        }

        .loading-spinner {
            display: none;
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
            margin: 0 auto;
        }
        .modal-content.success-content {
    background-color: #d4edda;
    color: green;
    border: 1px solid #c3e6cb;
}

.modal-content.success-content h4 {
    margin: 0;
    color: black;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}

.loading-spinner {
    display: none;
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #007bff; /* Adjust color to match your design */
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


    
    </style>
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
                        <button class="btn btn-sm btn-info mr-2 text-white" onclick="showCancelModal('<?php echo $reference_no; ?>', '<?php echo $name; ?>', '<?php echo $departure_location; ?>', '<?php echo $arrival_location; ?>', '<?php echo $date; ?>', '<?php echo $booked_at; ?>')">Cancel</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="cancelModal" class="modal">
    <div id="confirmationContent" class="modal-content">
        <h2 style="text-align:center; font-weight: bold;">Are you sure?</h2>
        <h4 style="text-align:center">You'll be refunded 50% from the payment</h4>
        <div class="modal-buttons">
            <button class="yes-button" id="yesCancelButton">Yes</button>
            <button class="no-button" onclick="closeModal()">No</button>
        </div>
    </div>
    <div id="successContent" class="modal-content" style="display: none;">
        <h4 style="text-align:center">Successfully Cancelled</h4>
    </div>
    <div id="loadingSpinner" class="loading-spinner"></div>
</div>

<!-- 
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <h4 style="text-align:center">"Sucessfully Cancelled"</h4>
        </div>
        <div id="loadingSpinner" class="loading-spinner"></div>
    </div> -->
    

    <script>
       function showCancelModal(ref_no, name, departure_location, arrival_location, date, booked_at) {
    var modal = document.getElementById('cancelModal');
    var yesButton = document.getElementById('yesCancelButton');

    yesButton.onclick = function() {
        cancelBooking(ref_no, name, departure_location, arrival_location, date, booked_at);
    };

    modal.style.display = 'block';
}

function cancelBooking(ref_no, name, departure_location, arrival_location, date, booked_at) {
    var modalContent = document.querySelector('.modal-content');
    var loadingSpinner = document.getElementById('loadingSpinner');

    modalContent.style.display = 'none';
    loadingSpinner.style.display = 'block';
    setTimeout(function() {
            fetch('cancel_booking_latest.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                ref_no: ref_no,
                name: name,
                departure_location: departure_location,
                arrival_location: arrival_location,
                date: date,
                booked_at: booked_at,
                username: '<?php echo $_SESSION['username']; ?>', // Pass the logged-in username
            }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var params = new URLSearchParams();
                    params.append('ref_no', ref_no);
                    params.append('name', name);
                    params.append('departure_location', departure_location);
                    params.append('arrival_location', arrival_location);
                    params.append('date', date);
                    params.append('booked_at', booked_at);
                    alert('Canceled Successfully', 'success');
                    window.location.href = 'bookings_ongoing.php?' + params.toString();
                } else {
                    alert('Failed to cancel the booking.'+ data.message);
                    closeModal();
                }
            })
            .catch((error) => {
                alert('Error:' + error.message);
                closeModal();
            });
            }, 3000); // Adjust the time as needed (3000ms = 3s)
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

// Function to handle cancellation
function handleCancellation() {
    // Hide the confirmation content
    document.getElementById('confirmationContent').style.display = 'none';
    
    // Show the success content
    document.getElementById('successContent').style.display = 'block';
    
    // Optionally hide the loading spinner after a short delay
    setTimeout(() => {
        document.getElementById('loadingSpinner').style.display = 'none';
    }, 1000); // Adjust the delay as needed
}

// Attach event listener to the Yes button
document.getElementById('yesCancelButton').addEventListener('click', () => {
    // Show the loading spinner
    document.getElementById('loadingSpinner').style.display = 'block';
    
    // Simulate a cancellation process (e.g., API call)
    setTimeout(() => {
        handleCancellation();
    }, 2000); // Adjust the delay as needed to simulate cancellation time
});

// Function to close the modal
function closeModal() {
    document.getElementById('cancelModal').style.display = 'none';
}


    </script>
</body>

</html>