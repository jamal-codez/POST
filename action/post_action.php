<?php
session_start();
include "../includes/connection.php"; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['loggedInUser'])) {
    header('Location: ../index.php');
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the logged-in user's ID
    $userId = $_SESSION['id'];

    $sql = "SELECT MAX(batch) AS highest_id FROM posts";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
    $batch_id = $row['highest_id']+1;

    // // Get the comments and images from the form
    if(isset($_POST['comment'])){
        $comment = $_POST['comment'];
    }else{
        $comment = null;
    }
    if(isset($_POST['images'])){
        $web_img = $_POST['images'];
        $webcount = count($web_img);
        for ($i = 0; $i < $webcount; $i++) {
            $web_i=$web_img[$i];
            $mime="image/jpeg";

            if ($webcount > 1){
                $stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_base64, image_mime_type, batch) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isssi", $userId, $comment, $web_i, $mime, $batch_id);
            }else{
                $stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_base64, image_mime_type) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $userId, $comment, $web_i, $mime);
            }

            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
    
            $stmt->close();
        }
    }

    // Redirect to a success page (or the dashboard)
    header('Location: ../feeds.php');
    exit;
}

$conn->close();
?>
