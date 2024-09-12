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
                    <div class="seat">1</div>
                    <div class="seat occuipied">2</div>
                    <div class="seat occuipied">3</div>
                    <div class="seat">4</div>
                    </div>
                    <div class="row">
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat occuipied"></div>
                    <div class="seat"></div>
                    </div>
                    <div class="row">
                    <div class="seat occuipied"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    </div>
                    <div class="row">
                    <div class="seat"></div>
                    <div class="seat occuipied"></div>
                    <div class="seat"></div>
                    <div class="seat occuipied"></div>
                    </div>
                    <div class="row">
                    <div class="seat"></div>
                    <div class="seat occuipied"></div>
                    <div class="seat occuipied"></div>
                    <div class="seat"></div>
                    </div>
                    <div class="row">
                    <div class="seat"></div>
                    <div class="seat occuipied"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    </div>    
                    <p class="text">
                    You Have Selected <span id="count">0</span> seats for Rs <span id="total">0</span>
                    </p>
                </div>    
            </div>
        </div>
    </form>
</div>
<script>
        const container = document.querySelector('.seatContainer');
        const seats = document.querySelectorAll('.row .seat:not(.occuipied');
        const count = document.getElementById('count');
        const total = document.getElementById('total');
        //const busSelect = document.getElementById('bus');

        //let ticketPrice = busSelect.value;
        container.addEventListener('click', (e) => {
        if (e.target.classList.contains('seat') && !e.target.classList.contains('occupied')) {
        e.target.classList.toggle('selected');}
        // updateSelectedCount()
        });
    </script>
<script>
function getValue() {
    let quantity = document.getElementById("qty");
    let qtyValue = parseInt(quantity.value); // Convert input value to integer

    let ticketPrice = document.getElementById("price_per_ticket").innerText; // Get text content of price per ticket
    ticketPrice = parseFloat(ticketPrice); // Convert price to integer (or parseFloat() for decimal values)

    let totalPrice = document.getElementById("total_price");
    totalPrice.innerText = (qtyValue * ticketPrice).toFixed(2);; // Calculate total price and update element
}


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