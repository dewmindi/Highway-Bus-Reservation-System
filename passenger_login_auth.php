<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    try {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, password FROM passengers WHERE username = ?");
        if ($stmt === false) {
            throw new Exception('Prepare statement failed: ' . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['login_passenger'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'passenger';// Store the username in the session
                echo 1; // Success
            } else {
                http_response_code(401);
                echo "Incorrect password."; // Incorrect password
            }
        } else {
            http_response_code(404);
            echo "Username not found."; // Username not found
        }
        
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo "Internal server error.";
    }
} else {
    http_response_code(405);
    echo "Invalid request method.";
}

$conn->close();
?>
