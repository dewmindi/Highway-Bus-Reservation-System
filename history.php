<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View History</title>
    <?php include 'header.php'; // Include the header to add the CSS and JS files ?>
    <style>
        .container-fluid {
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-body {
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }

        .booking-details {
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }

        .booking-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .booking-details th,
        .booking-details td {
            padding: 10px;
            text-align: left;
        }

        .booking-details th {
            width: 150px;
            font-weight: bold;
            color: #0056b3;
        }

        .booking-details td {
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include 'passenger_navbar.php'; // Include the navigation bar ?>

    <section id="" class="d-flex align-items-center">
        <main id="main">
            <div class="container-fluid">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <?php if (isset($_SESSION['login_id'])): ?>
                                <button class="float-right btn btn-primary btn-sm" type="button" id="new_schedule">Add New <i class="fa fa-plus"></i></button>
                            <?php endif; ?> -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="card col-md-12">
                            <div class="card-body">
                                <h1>BOOKING HISTORY</h1>
                                
                                <div class="booking-details">
                                    <table>
                                        <tr>
                                            <th>Reference Number</th>
                                            <td>202206248407</td>
                                        </tr>
                                        <tr>
                                            <th>From</th>
                                            <td>Mathara</td>
                                        </tr>
                                        <tr>
                                            <th>To</th>
                                            <td>Makumbura</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>2024-06-10</td>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <td>2</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="booking-details">
                                    <table>
                                        <tr>
                                            <th>Reference Number</th>
                                            <td>2202206252673</td>
                                        </tr>
                                        <tr>
                                            <th>From</th>
                                            <td>Makumbura</td>
                                        </tr>
                                        <tr>
                                            <th>To</th>
                                            <td>Kadawatha</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>2024-06-5</td>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <td>1</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="booking-details">
                                    <table>
                                        <tr>
                                            <th>Reference Number</th>
                                            <td>202206252209</td>
                                        </tr>
                                        <tr>
                                            <th>From</th>
                                            <td>Pettah</td>
                                        </tr>
                                        <tr>
                                            <th>To</th>
                                            <td>Kandy</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>2024-06-1</td>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <td>4</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
</body>

</html>