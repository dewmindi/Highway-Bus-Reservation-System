<?php
session_start();
include('db_connect.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM schedule_list WHERE id = " . $_GET['id'])->fetch_array();
    foreach ($qry as $k => $val) {
        $meta[$k] = $val;
    }
    $price_per_ticket = $meta['price'];
    $bus = $conn->query("SELECT * FROM bus WHERE id = " . $meta['bus_id'])->fetch_array();
    $from_location = $conn->query("SELECT id, Concat(terminal_name, city, state) AS location FROM location WHERE id =" . $meta['from_location'])->fetch_array();
    $to_location = $conn->query("SELECT id, Concat(terminal_name, city, state) AS location FROM location WHERE id =" . $meta['to_location'])->fetch_array();
    $count = $conn->query("SELECT SUM(qty) AS sum FROM booked WHERE schedule_id =" . $meta['id'])->fetch_array()['sum'];
}

if (isset($_GET['bid'])) {
    $booked = $conn->query("SELECT * FROM booked WHERE id=" . $_GET['bid'])->fetch_array();
    foreach ($booked as $k => $val) {
        $bmeta[$k] = $val;
    }
}

$bus_number = $bus['bus_number']; // Get bus number from the query
$schedule_query = $conn->query("SELECT id FROM schedule_list WHERE bus_id = (SELECT id FROM bus WHERE bus_number = '$bus_number')")->fetch_array();
$schedule_id = $schedule_query['id'];

// Fetch seat availability based on the current bus's schedule_id
$seats = $conn->query("SELECT * FROM $bus_number WHERE schedule_id = " . $schedule_id)->fetch_all(MYSQLI_ASSOC);
$seat_availability = [];
foreach ($seats as $seat) {
    $seat_availability[$seat['seat_id']] = $seat['availability'];
}
?>

<style>
    * {
        box-sizing: border-box;
    }

    .seat {
        background-color: #444451;
        height: 19px;
        width: 19px;
        margin: 3px;
        margin-right: 5px;
        margin-bottom: 40px;
        margin-left: 10px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .showcase{

    }

    .lastSeat{
        background-color: #444451;
        height: 12px;
        width: 15px;
        margin: 3px;
        margin-right: 10px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px; 
    }

    .row {
        display: flex;
    }

    .seat.selected {
        background-color: #FFA500;
    }

    .seat.occuipied {
        background-color:  #FF0000;
    }

    .seat:nth-of-type(2) {
        margin-right: 20px;
    }

    .seat:not(.occuipied):hover {
        cursor: pointer;
        transform: scale(1.5);
    }

    .showcase .seat:not(.occuipied):hover {
        cursor: default;
        transform: scale(1);
    }

    .showcase {
    list-style: none;
    justify-content: flex-start; /* Align items to the left */
    margin-bottom: 20px; /* Add some space between the legends and the seat selection */
    padding-left: 0; /* Remove default padding */
    margin-left: 0;
    }

    .showcase li {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
    margin-right: 0; /* Space between each legend item */
    }

    .showcase .seat {
    margin: 0 5px 0 0; /* Adjust the margin to space items correctly */
    }

    p.text {
        margin: 5px 0;
    }

    p.text span {
        color: #6feaf6;
    }

    .bus-name label {
        font-weight: bold;
        margin-right: 10px;
    }

    .container {
        max-width: 100%;
        margin-top: 20px;
    }

    .screen {
        background-color: #fff;
        height: 20px;
        margin: 10px 0;
        width: 100%;
        border-radius: 5px;
    }
</style>

<div class="container-fluid">
    <form id="manage_book">
        <div class="row" method="post" action="checkout.php">
            <!-- Reservation Details -->
            <div class="col-md-8">
                <p><b>Bus:</b> <?php echo $bus['bus_number'] . ' | ' . $bus['name'] ?></p>
                <p><b>From:</b> <?php echo $from_location['location'] ?></p>
                <p><b>To:</b> <?php echo $to_location['location'] ?></p>
                <p><b>Departure Time</b>: <?php echo date('M d,Y h:i A', strtotime($meta['departure_time'])) ?></p>
                <p><b>Estimated Time of Arrival:</b> <?php echo date('M d,Y h:i A', strtotime($meta['eta'])) ?></p>
                <?php if ($count < $meta['availability']): ?>
                <input type="hidden" class="form-control" id="sid" name="sid" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
                <input type="hidden" class="form-control" id="bid" name="bid" value='<?php echo isset($_GET['bid']) ? $_GET['bid'] : '' ?>' required="">
                <input type="hidden" class="form-control" id="bus_number" name="bus_number" value='<?php echo $bus['bus_number'] ?>' required="">
                <input type="hidden" class="form-control" id="bus_name" name="bus_name" value='<?php echo $bus['name'] ?>' required="">
                <input type="hidden" class="form-control" id="from_location" name="from_location" value='<?php echo $from_location['location'] ?>' required="">
                <input type="hidden" class="form-control" id="to_location" name="to_location" value='<?php echo $to_location['location'] ?>' required="">
                <input type="hidden" class="form-control" id="booked_for" name="booked_for" value='<?php echo date('Y-m-d H:i:s', strtotime($meta['departure_time'])) ?>' required="">
            
                <div class="form-group mb-2">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($bmeta['name']) ? $bmeta['name'] : '' ?>">
                </div>
                <div class="form-group mb-2">
                    <label for="qty" class="control-label">Quantity</label>
                    <input type="number" maxlength="4" class="form-control text-right" id="qty" name="qty" value="<?php echo isset($bmeta['qty']) ? $bmeta['qty'] : '' ?>" onInput="getValue()">
                </div>
                <div class="form-group mb-2">
                    <label for="email" class="control-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($bmeta['email']) ? $bmeta['email'] : '' ?>">
                </div>
                <div class="form-group mb-2">
                    <label for="nic" class="control-label">NIC</label>
                    <input type="varchar" maxlength="8" class="form-control text-right" id="nic" name="nic" value="<?php echo isset($bmeta['nic']) ? $bmeta['nic'] : '' ?>">
                </div>
                <div class="form-group mb-2">
                    <p><b>Price per Ticket:</b> Rs <span id="price_per_ticket"><?php echo $meta['price'] ?></span></p>
                    <p><b>Total Price:</b> Rs <span id="total_price"> 0.00</span></p>
                </div>
                <?php else: ?>
                <p style="font-weight: bold; text-align: center;">SORRY, NO AVAILABLE SEATS</p>
                <style>
                    .uni_modal .modal-footer {
                        display: none;
                    }
                </style>
                <?php endif; ?>
            </div>
            <!-- Bus Seat Selection -->
            <div class="col-md-4">
                <!-- Add your bus seat selection UI here -->
                <ul class="showcase">
                    <li>
                        <div class="seat"></div>
                        <small>N/A</small>
                    </li>
                    <li>
                        <div class="seat selected"></div>
                        <small>Selected</small>
                    </li>
                    <li>
                        <div class="seat occuipied"></div>
                        <small>Booked</small>
                    </li>
                </ul>

                <div class="seatContainer">
                    <div class="row">
                        <?php for ($i = 1; $i <= 24; $i++): ?>
                            <div class="seat <?php echo isset($seat_availability[$i]) && $seat_availability[$i] == 0 ? 'seat occuipied' : ''; ?>" id="<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <!-- <div class="row">
                    <div class="seat"></div>
                    <div class="seat occuipied"></div>
                    <div class="seat"></div>
                    <div class="seat"></div> 
                    </div>     -->
                    <!-- <p class="text">
                    You Have Selected <span id="count">0</span> seats for Rs <span id="total">0</span>
                    </p> -->
                </div>    
            </div>
        </div>
    </form>
</div>
    <!--price based on seat selection -->
    <!-- <script>
        const container = document.querySelector('.seatContainer');
        const seats = document.querySelectorAll('.row .seat:not(.occuipied)');
        const qtyInput = document.getElementById('quantity');
        const displayQty = document.getElementById('display_quantity');
        const pricePerTicketElem = document.getElementById('price_per_ticket');
        const totalPriceElem = document.getElementById('total_price');

        let selectedSeatsCount = 0;

        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('seat') && !e.target.classList.contains('occuipied')) {
                e.target.classList.toggle('selected');
                updateTotalPrice();
            }
        });
    function updateTotalPrice() {
        const selectedSeats = document.querySelectorAll('.row .seat.selected');
        const selectedCount = selectedSeats.length-1;
        const pricePerTicket = parseFloat(pricePerTicketElem.innerText);
        const totalPrice = (selectedCount * pricePerTicket).toFixed(2);

        totalPriceElem.innerText = totalPrice;
        qtyInput.value = selectedCount; // Update quantity input with selected count
        displayQty.innerText = selectedCount; // Update display quantity
    }
        
    </script> -->
    <script>
    const container = document.querySelector('.seatContainer');
    const seats = document.querySelectorAll('.row .seat:not(.occuipied)');
    const qtyInput = document.getElementById('qty');
    const pricePerTicketElem = document.getElementById('price_per_ticket');
    const totalPriceElem = document.getElementById('total_price');

    // Listen for clicks on the seat container
    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('seat') && !e.target.classList.contains('occuipied')) {
            e.target.classList.toggle('selected');
            updateTotalPriceAndQty();  // Update total price and quantity
        }
    });

    function updateTotalPriceAndQty() {
        const selectedSeats = document.querySelectorAll('.row .seat.selected');
        const selectedCount = selectedSeats.length-1;
        const pricePerTicket = parseFloat(pricePerTicketElem.innerText);
        const totalPrice = (selectedCount * pricePerTicket).toFixed(2);

        totalPriceElem.innerText = totalPrice;
        qtyInput.value = selectedCount;
    }
</script>
    <script>
    $('#manage_book').submit(function(e) {
        e.preventDefault();
        let selectedSeats = [];
        $('.seat.selected').each(function() {
            selectedSeats.push($(this).attr('id'));
        });
        $('<input>').attr({
            type: 'hidden',
            id: 'selected_seats',
            name: 'selected_seats',
            value: selectedSeats.join(',')
        }).appendTo('#manage_book');
        start_load();
        $.ajax({
            url: './book_now.php',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err);
                end_load();
                alert_toast('An error occurred', 'danger');
            },
            success: function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == 1) {
                    end_load();
                    //$('.modal').modal('hide');
                    //alert_toast('Data successfully saved', 'success');
                    //$('#book_modal .modal-body').html('<div class="text-center"><p>Your seat reservation has been made. Thank You. <br><strong><h3>' + resp.ref + '</h3></strong></p><small>Reference Number</small><br/><small>Copy or Capture your Reference number</small></div>');
                    //$('#book_modal').modal('show');
                    let totalPrice = $('#total_price').text();
                    window.location.href = './checkout.php?total_price=' + encodeURIComponent(totalPrice);
                    //window.location.href = './checkout.php?booking_id=' + encodeURIComponent(resp.booking_id) + '&total_price=' + encodeURIComponent($('#total_price').text());
                    
                }
            }
        });
    });
    $('.datetimepicker').datetimepicker({
        format: 'Y/m/d H:i',
        startDate: '+3d'
    });
</script>


<!-- <script>
    $('#manage_book').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: './book_now.php',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err);
                end_load();
                alert_toast('An error occurred', 'danger');
            },
            success: function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == 1) {
                    end_load();
                    window.location.href = './booking_details.php?bus_number=' + encodeURIComponent(resp.bus_number) + '&from=' + encodeURIComponent(resp.from) + '&to=' + encodeURIComponent(resp.to);
                }
            }
        });
    });
</script> -->