<!DOCTYPE html>
<html>
<head>
    <?php include('header.php'); ?>
    <?php 
    session_start();
    if(isset($_SESSION['login_id'])){
        header('Location: home.php');
        exit();
    }
    ?>
    <title>Passenger Login | Online Bus Reservation</title>
    <style>
        body {
            background-image: url('./assets/img/roads.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .card {
            margin-top: 50px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-block {
            width: 100%;
        }
        .links {
            display: flex;
            justify-content: space-between;
        }
        .links a {
            text-decoration: none;
        }
    </style>
</head>
<body id="login-body" class="bg-light">
    <div class="container">
        <div class="card col-md-4 offset-md-4 mt-4">
            <div class="card-body">
                <form id="login-frm">
                    <p><b>Passenger Login Panel</b></p>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div> 
                    <div class="form-group text-right">
                        <button id="admin-login" class="btn btn-success btn-block" type="submit">Login</button>
                        <br>
                        <div class="links">
                            <a id="new-account" href="sign_up.php">Create an account</a>
                            <a href="index.php">Back to Home</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
