<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Online Bus Reservation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #f0f4f8;
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
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .links a:hover {
            color: #0056b3;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="card-header-edge">
            Login
        </div>
        <div class="card-body">
            <form id="login-frm" method="POST">
                <div class="form-group">
                    <label for="email">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">Login</button>
                </div>
            </form>
            <div class="links">
                <a href="sign_up.php">Sign Up</a> | <a href="index.php">Home</a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#login-frm').submit(function(e){
                e.preventDefault();
                $('#login-frm button').attr('disabled', true).text('Checking details...');

                $.ajax({
                    url: 'passenger_login_auth.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    error: function(err){
                        console.error(err);
                        alert('An error occurred. Please try again.');
                        $('#login-frm button').removeAttr('disabled').text('Login');
                    },
                    success: function(resp){
                        if(resp == 1){
                            location.replace('passenger_profile.php');
                        } else {
                            alert("Incorrect username or password.");
                            $('#login-frm button').removeAttr('disabled').text('Login');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>