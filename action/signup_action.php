<?php session_start();

include ("../includes/connection.php");


    $fname = $conn->real_escape_string($_POST['firstname']);
    $lname = $conn->real_escape_string($_POST['lastname']);
    $uname = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password1']);
    $password1 = $conn->real_escape_string($_POST['password2']);
    $gender = $conn->real_escape_string($_POST['gender']);

    // if ($password != $password1) {
    //     $_SESSION['sign_error'] = "Password Mismatch";
    //     header('Location: ../sign_up.php');
    //     exit;
    // }

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
        $imageMimeType = mime_content_type($_FILES['image']['tmp_name']);
    } elseif (isset($_POST['webcam_image'])) {
        $imageData = $_POST['webcam_image'];
    } else {
        $imageData = null;
    }

    

    $check_duplicate_sql = "SELECT * FROM `users` WHERE `username` = ? OR `email` = ?";
    $check_stmt = $conn->prepare($check_duplicate_sql);
    $check_stmt->bind_param("ss", $uname, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    if ($check_result->num_rows > 0) {
        $_SESSION['sign_error'] = "Username or Email Already Exists. Try Again";
        header('Location: ../sign_up.php');
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $user_bios_sql = "INSERT INTO `users`(`username`, `email`, `password`, `img`,`img_mime_type`, `firstname`, `lastname`, `gender`) VALUES (?, ?, ?, ?, ?,?, ?, ?)";
    $stmt = $conn->prepare($user_bios_sql);
    if (!$stmt) {
        die('Error in SQL query: ' . $conn->error);
    }

    $stmt->bind_param("ssssssss", $uname, $email, $hashed_password, $imageData,$imageMimeType, $fname, $lname, $gender);
    $insert_user_bios_r = $stmt->execute();

    if (!$insert_user_bios_r) {
        $_SESSION['sign_error'] = "Info Failed to Submit. Try Again: " . $stmt->error;
        header('Location: ../sign_up.php');
        exit;
    }

    $_SESSION['succ'] = "Bios Submitted Successfully";
    header('Location: ../index.php');
    exit;

?>