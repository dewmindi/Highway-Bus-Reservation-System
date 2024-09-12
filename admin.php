
<!DOCTYPE html>
<html>
	<head>
		<?php include('header.php') ?>
        <?php 
        // session_start();
        // if(isset($_SESSION['login_id'])){
        //     header('Location:home.php');
        // }
        ?>
		<title>Admin Login |Online Bus Reservation</title>
	</head>
    <style>
        body {
            background-image: url(./assets/img/roads.jpg) ;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background */
            color: #333;
            /* background-position: center; */
            background-repeat: no-repeat;
            /* background-size: stretch; */
        }
    </style>

	    <body id='login-body' class="bg-light">
    		<div class="card col-md-4 offset-md-4 mt-4">
                <div class="card-header-edge text-white">
                    <strong>Login</strong>
                </div>
                <div class="card-body">
                     <form id="login-frm">
                         <!-- <p><b>Admin Login Panel</b></p>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="username" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>  -->
                        <div class="form-group text-right">
                            <button id="admin-login" class="btn btn-success btn-block" name="submit">Login as Admin</button>
							<br>
							<!-- <a href="./index.php">Back to Home</a> -->
                        </div>
                        <div class="form-group text-right">
                            <button id="passenger-login" class="btn btn-success btn-block" name="submit">Login as Passenger</button>
							<br>
							<a href="./index.php">Back to Home</a>
                        </div>
                        
                    </form>
                </div>
            </div>

		</body>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('admin-login').addEventListener('click', function() {
                window.location.href = 'admin_login_form.php'; // Change this to the correct URL for the admin login page
            });
            document.getElementById('passenger-login').addEventListener('click', function() {
                window.location.href = 'passenger_login_form.php'; // Change this to the correct URL for the passenger login page
            });

            $('#login-frm').submit(function(e){
                e.preventDefault()
                $('#login-frm button').attr('disable',true)
                $('#login-frm button').html('Checking details...')

                $.ajax({
                    url:'./login_auth.php',
                    method:'POST',
                    data:$(this).serialize(),
                    error:err=>{
                        console.log(err)
                        alert('An error occurred');
                        $('#login-frm button').removeAttr('disable')
                        $('#login-frm button').html('Login')
                    },
                    success:function(resp){
                        if(resp == 1){
                            location.replace('index.php?page=home')
                        }else{
                            alert("Incorrect username or password.")
                            $('#login-frm button').removeAttr('disable')
                            $('#login-frm button').html('Login')
                        }
                    }
                })

            })
        });
    </script>
</html>