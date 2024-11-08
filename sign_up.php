<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input data
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // Input validation
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            throw new Exception('All fields are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match.');
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT id FROM passengers WHERE username = ? OR email = ?");
        if ($stmt === false) {
            throw new Exception('Prepare statement failed: ' . $conn->error);
        }
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            throw new Exception('Username or email already exists.');
        }

        $stmt->close();

        // Insert new passenger into the database
        $stmt = $conn->prepare("INSERT INTO passengers (username, email, password) VALUES (?, ?, ?)");
        if ($stmt === false) {
            throw new Exception('Prepare statement failed: ' . $conn->error);
        }

        $stmt->bind_param("sss", $username, $email, $hashed_password);
        if ($stmt->execute()) {
            // Store user details in session
            $_SESSION['login_passenger'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'passenger';

            // Registration successful, send response
            echo 1; // success
        } else {
            throw new Exception('Error during registration: ' . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        http_response_code(400);
        echo $e->getMessage();
    }

    $conn->close();
    exit; // End the script after handling POST request
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Online Bus Reservation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background:  #f0f4f8;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background-color: #fff;
            padding: 30px;
            width: 380px;
            border-radius: 15px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.4s ease-in-out, box-shadow 0.4s ease;
            border-top: 6px solid #007bff;
            animation: slideIn 0.8s ease;
            position: relative;
            overflow: hidden;
        }
        .card:before {
            content: '';
            position: absolute;
            height: 300%;
            width: 300%;
            background: linear-gradient(135deg, #007bff, #6f42c1);
            top: -150%;
            left: -150%;
            z-index: -1;
            transition: 0.6s;
        }
        .card:hover:before {
            top: 0;
            left: 0;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.25);
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card-header-edge {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
            color: #495057;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ced4da;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.4s, box-shadow 0.4s;
            background-color: #f9f9f9;
        }
        .form-group input:focus {
            border-color: #007bff;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.25);
            background-color: white;
        }
        .form-group button {
            width: 100%;
            padding: 14px;
            background-image: linear-gradient(to right, #28a745, #218838);
            border: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            cursor: pointer;
            transition: background-position 0.4s, box-shadow 0.3s ease-in-out;
            background-size: 200%;
            background-position: right;
        }
        .form-group button:hover {
            background-position: left;
            box-shadow: 0px 12px 24px rgba(40, 167, 69, 0.3);
        }
        .form-group button:active {
            transform: scale(0.98);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="card-header-edge">
            Sign Up
        </div>
        <div class="card-body">
            <form id="sign-up-frm" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">Sign Up</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#sign-up-frm').submit(function(e){
                e.preventDefault();
                $('button').attr('disabled', true).text('Submitting...');
                
                $.ajax({
                    url: 'sign_up.php', // Same file for handling form submission
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response){
                        if (response == 1) {
                            // alert('Sign up successful. Redirecting to login page...');
                            window.location.replace('passenger_new_login_form.php');
                        } else {
                            alert(response); // Display error message
                            $('button').removeAttr('disabled').text('Sign Up');
                        }
                    },
                    error: function(){
                        alert('An error occurred. Please try again.');
                        $('button').removeAttr('disabled').text('Sign Up');
                    }
                });
            });
        });
    </script>
</body>
</html>