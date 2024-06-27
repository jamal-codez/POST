<?php
session_start();
include_once '../includes/connection.php'; // Adjust the path as necessary

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);
$followingId = $data['user_id'];

if ($userId == $followingId) {
    echo json_encode(['success' => false, 'message' => 'You cannot follow yourself']);
    exit;
}

// Check if the user is already following
$stmtCheck = $conn->prepare("SELECT * FROM follows WHERE follower_id = ? AND following_id = ?");
$stmtCheck->bind_param("ii", $userId, $followingId);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows > 0) {
    // Unfollow user
    $stmtUnfollow = $conn->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
    $stmtUnfollow->bind_param("ii", $userId, $followingId);
    $stmtUnfollow->execute();
    $stmtUnfollow->close();
    echo json_encode(['success' => true, 'followed' => false]);
} else {
    // Follow user
    $stmtFollow = $conn->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
    $stmtFollow->bind_param("ii", $userId, $followingId);
    $stmtFollow->execute();
    $stmtFollow->close();
    echo json_encode(['success' => true, 'followed' => true]);
}

$stmtCheck->close();
?>
