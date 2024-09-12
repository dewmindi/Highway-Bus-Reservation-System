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
    <title>Admin Login | Online Bus Reservation</title>
    <style>
        body {
            background-image: url('./assets/img/roads.jpg');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body id='login-body' class="bg-light">
    <div class="card col-md-4 offset-md-4 mt-4">
        <div class="card-header-edge text-white">
            <strong>Login</strong>
        </div>
        <div class="card-body">
            <form id="login-frm">
                <p><b>Admin Login Panel</b></p>
                <div class="form-group">
                    <label>Username</label>
                    <input type="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div> 
                <div class="form-group text-right">
                    <button id="admin-login" class="btn btn-success btn-block" type="submit">Login as Admin</button>
                    <br>
                    <a href="./index.php">Back to Home</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function(){
    $('#login-frm').submit(function(e){
        e.preventDefault();
        $('#login-frm button').attr('disabled', true).text('Checking details...');

        $.ajax({
            url: 'login_auth.php',
            method: 'POST',
            data: $(this).serialize(),
            error: function(err){
                console.error(err);
                alert('An error occurred. Please try again.');
                $('#login-frm button').removeAttr('disabled').text('Login as Admin');
            },
            success: function(resp){
                console.log('Response from server:', resp);
                if(resp == 1){
                    location.replace('admin_profile.php');
                } else {
                    alert("Incorrect username or password.");
                    $('#login-frm button').removeAttr('disabled').text('Login as Admin');
                }
            }
        });
    });
});

    </script>
</body>
</html>
