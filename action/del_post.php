<?php

session_start();
include "../includes/connection.php";
 // Include your database connection file

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['id'];
$postId = json_decode(file_get_contents('php://input'), true)['post_id'];

$stmt1 = $conn->prepare(" SELECT batch FROM posts WHERE post_id = ? ");
$stmt1->bind_param("i",$postId);
$stmt1->execute();
$result = $stmt1->get_result();
$bb = $result->fetch_assoc()['batch'];

if ($bb != null){
    $stmt = $conn->prepare(" DELETE FROM posts WHERE batch = ? ");
    $stmt->bind_param("i",$bb);
    $stmt->execute();
    echo json_encode(['success' => true]);
}else{
    $stmt = $conn->prepare(" DELETE FROM posts WHERE post_id = ? ");
    $stmt->bind_param("i",$postId);
    $stmt->execute();
    echo json_encode(['success' => true]);
}


// Check if the user already liked the post
// $stmt = $conn->prepare("SELECT * FROM Likes WHERE user_id = ? AND post_id = ?");
// $stmt->bind_param("ii", $userId, $postId);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     // User already liked the post, remove the like
//     $stmt = $conn->prepare("DELETE FROM Likes WHERE user_id = ? AND post_id = ?");
//     $stmt->bind_param("ii", $userId, $postId);
//     $stmt->execute();
//     // echo json_encode([ 'success' => true, 'unlike' => true]);
// } else {
//     // User has not liked the post, add the like
//     $stmt = $conn->prepare("INSERT INTO Likes (user_id, post_id) VALUES (?, ?)");
//     $stmt->bind_param("ii", $userId, $postId);
//     $stmt->execute();
//     // echo json_encode([ 'success' => true, 'like' => true]);
// }

// // Get the updated like count
// $stmt = $conn->prepare("SELECT COUNT(*) AS like_count FROM Likes WHERE post_id = ?");
// $stmt->bind_param("i", $postId);
// $stmt->execute();
// $result = $stmt->get_result();
// $likeCount = $result->fetch_assoc()['like_count'];

// echo json_encode(['success' => true, 'like_count' => $likeCount]);

?>
