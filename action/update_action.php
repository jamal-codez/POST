<?php
session_start();
include ("../includes/connection.php");

$fname = $conn->real_escape_string($_POST['firstname']);
$lname = $conn->real_escape_string($_POST['lastname']);
$uname = $conn->real_escape_string($_POST['nn']);
$email = $conn->real_escape_string($_POST['email']);

$userId = $_SESSION['id'];

$imageData = null;
$imageMimeType = null;

if (isset($_FILES['image']['tmp_name']) || isset($_POST['webcam_image'])) {
    if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
        $imageMimeType = mime_content_type($_FILES['image']['tmp_name']);
    } elseif (isset($_POST['webcam_image'])) {
        $imageData = $_POST['webcam_image'];
        $imageMimeType = 'image/jpeg'; // Assuming webcam image is JPEG. Adjust as necessary.
    }
}

if ($imageData !== null) {
    // Update user bios with image
    $user_bios_sql = "UPDATE `users` SET `username` = ?, `email` = ?, `img` = ?, `img_mime_type` = ?, `firstname` = ?, `lastname` = ? WHERE `user_id` = ?";
    $stmt = $conn->prepare($user_bios_sql);
    if (!$stmt) {
        die('Error in SQL query: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssssi", $uname, $email, $imageData, $imageMimeType, $fname, $lname, $userId);
} else {
    // Update user bios without image
    $user_bios_sql = "UPDATE `users` SET `username` = ?, `email` = ?, `firstname` = ?, `lastname` = ? WHERE `user_id` = ?";
    $stmt = $conn->prepare($user_bios_sql);
    if (!$stmt) {
        die('Error in SQL query: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssi", $uname, $email, $fname, $lname, $userId);
}

// Execute the statement
$update_user_bios_r = $stmt->execute();

if (!$update_user_bios_r) {
    $_SESSION['suc'] = "Info Failed to Submit. Try Again: " . $stmt->error;
    header('Location: ../profile.php');
    exit;
}

$_SESSION['suc'] = "Bios Submitted Successfully";
header('Location: ../profile.php');
exit;
?>
