<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Seats</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #242333;
            display: flex;
            flex-direction: column;
            color: white;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .seat {
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

        .seat.selected{
            background-color: #6feaf6;
        }

        .seat.occuipied {
            background-color: #fff;
        }

        .seat:nth-of-type(2){
            margin-right: 35px;
        }

        .seat:not(.occuipied):hover{
            cursor: pointer;
            transform: scale(1.5); 
        }

        .showcase .seat:not(.occuipied):hover{
            cursor: default;
            transform: scale(1);
        }

        .showcase{
            display: flex;
            list-style: none;
            justify-content: space-between;
        }

        .showcase li{
            display: flex;
            align-items: center;
            margin: 0 10px;
        }

        p.text{
            margin: 5px 0;
        }

        p.text span {
            color: #6feaf6;
        }

    </style> 
</head>
<body>
    <div class="bus-name">
        <label> Pick bus</label>
        <select id="bus">
            <option value="40">Bus 1</option>
            <option value="60">Bus 2</option>
            <option value="75">Bus 3</option>
            <option value="25">Bus 4</option>
        </select>
    </div>
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

    <div class="container">
        <div class="screen"></div>
        <div class="row">
            <div class="seat"></div>
            <div class="seat occuipied"></div>
            <div class="seat occuipied"></div>
            <div class="seat"></div>
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
        <div class="row">
            <div class="seat occuipied"></div>
            <div class="seat "></div>
            <div class="seat occuipied"></div>
            <div class="seat"></div>
        </div>
        <div class="row">
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat occuipied"></div>
            <div class="seat occuipied"></div>
        </div>
        <div class="row">
            <div class="seat occuipied"></div>
            <div class="seat occuipied"></div>
            <div class="seat"></div>
            <div class="seat"></div>
        </div>
        <div class="row">
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
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
            <div class="seat occuipied"></div>
        </div>
    </div>
    <p class="text">
        You Have Selected <span id="count">0</span> seats for Rs <span id="total">0</span>
    </p>

    

    <script>
        const container = document.querySelector('.container');
        const seats = document.querySelectorAll('.row .seat:not(.occuipied');
        const count = document.getElementById('count');
        const total = document.getElementById('total');
        const busSelect = document.getElementById('bus');

        let ticketPrice = busSelect.value;

        container.addEventListener('click', (e) => {
            console.log('Noo');
        if (e.target.classList.contains('seat') && !e.target.classList.contains('occupied')) {
        e.target.classList.toggle('selected');}
        // updateSelectedCount()
        });
    </script>
</body>
</html>