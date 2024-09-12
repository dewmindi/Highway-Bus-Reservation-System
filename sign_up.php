<!DOCTYPE html>
<html>
<head>
    <title>Sign Up | Online Bus Reservation</title>
    <style>
        body {
            background-image: url('./assets/img/roads.jpg');
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 300px;
            margin-top: 50px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .btn-block {
            width: 100%;
        }
        .form-group input {
            width: 100%;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #218838;
        }
        .links {
            padding:10px;
            display: flex;
            justify-content: space-between;
        }
        .links a {
            text-decoration: none;
        }
    </style>
</head>
<body id='login-body' class="bg-light">
    <!-- <div class="card col-md-4 offset-md-4 mt-4">
        <div class="card-header-edge text-white">
            <strong>Sign Up</strong>
        </div>
        <div class="card-body">
            <form id="sign-up-frm" method="POST" action="sign_up_auth.php">
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
                    <button type="submit" class="btn btn-success btn-block">Sign Up</button>
                </div>
            </form>
        </div>
    </div> -->

    <div class="container">
        <div class="card col-md-4 offset-md-4 mt-4">
            <div class="card-body">
            <form id="sign-up-frm" method="POST" action="sign_up_auth.php">
                    <p><b>Signup</b></p>
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
                    <div class="form-group text-right">
                        <button id="admin-login" class="btn btn-success btn-block" type="submit">Signup</button>
                        <br>
                        <div class="links">
                            <a id="new-account" href="passenger_login_form.php">Already Have an account</a>
                            <a href="index.php">Back to Home</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
