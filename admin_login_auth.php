<?php
session_start();
include 'db_connect.php';// Ensure the correct path to your DB connection script

$username = $_POST['username'];
$password = $_POST['password'];

// Escape inputs to prevent SQL injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['login_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = 'admin'; // Set the role to 'admin'
    echo 1;
} else {
    echo 0;
}
?>
