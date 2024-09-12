<?php
// PHP code can be added here if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment successful</title>
    <style>
        /* CSS Code */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            width: 100%;
            height: 100vh;
            background: #FAF9F6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .popup {
            width: 400px;
            background: #fff;
            border-radius: 6px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            padding: 0 50px 50px;
            color: #333;
        }
        .popup img {
            width: 100px;
            margin-top: -50px;
            border-radius: 70%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        .popup h2 {
            font-size: 50px;
            font-weight: 500;
            margin: 30px 0 10px;
            font-style: normal;
        }
        .popup button {
            width: 100%;
            margin-top: 50px;
            padding: 10px 0;
            background: #3aa313;
            color: #fff;
            border: 0;
            outline: none;
            font-size: 20px;
            border-radius: 15px;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
  <div class="container">
    <div class="popup">
        <img src="./assets/img/tick.jpg" alt="Success">
        <h2>Thank You!</h2>
        <br>
        <p>Your reservation has been successfully placed.</p>
        <br>
        <h5>Check your e-mail for reservation details.</h5>
        <button type="button" onclick="window.location.href='bookings_ongoing.php';">OK</button>
    </div>
  </div>
</body>
</html>

<?php
// End of PHP script
?>
