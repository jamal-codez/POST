<?php
ob_start();
session_start();
include "../includes/connection.php";

if (mysqli_connect_error()) {
    exit('Failed to connect to the database: ' . mysqli_connect_errno());
}

// Prepare your SQL and prevent injection
if ($stmt = $conn->prepare('SELECT user_id, password FROM users WHERE username = ?')) {

    // Binding of parameters
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $pass=$_POST['password'];

    // Store the results
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($pass, $password)) {

            session_regenerate_id();
                $_SESSION['loggedInUser'] = true;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                // $_SESSION['role'] = $role;
                header('Location: ../feeds.php');
                exit;
        } else {
            // Display message for incorrect Password
            $_SESSION['feed'] = 'Incorrect Password!';
            // echo 'Incorrect Password!';
            header('refresh:2;url=../index.php');
            exit;
        }
    } else {
        // Display message for incorrect Username
        // echo 'Incorrect Username!';
        $_SESSION['feed'] = 'Incorrect Username!';
        header('refresh:2;url=../index.php');
        exit;
    }

    $stmt->close();
}
ob_end_flush();

// Close the database connection
mysqli_close($conn);
?>
