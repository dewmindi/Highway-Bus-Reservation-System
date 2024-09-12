<?php
$conn= new mysqli('localhost','root','','obrsphp');
$host = 'localhost'; 
$dbname = 'obrsphp';
$username = 'root';
$password = ''; 
if (!$conn)
{
    error_reporting(0);
    die("Could not connect to mysql".mysqli_error($conn));
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Database connection failed: " . $e->getMessage();
    die(); // Stop execution
}

?>