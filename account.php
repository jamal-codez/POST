<?php

session_start();
include_once 'head_sid_nav.php';
// Include your database connection file
// include "./includes/connection.php";
// if (!isset($_SESSION['loggedInUser'])) {
//     FlashMessage::redirect('index.php'); exit;
// }

// Assuming the logged-in user's ID is stored in the session
$userId = $_SESSION['id'];

// Fetch user information
$stmtUser = $conn->prepare("SELECT username, img, img_mime_type FROM users WHERE user_id = ?");
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$userResult = $stmtUser->get_result();
$user = $userResult->fetch_assoc();
$stmtUser->close();

// Fetch the number of followers and following
$stmtFollowers = $conn->prepare("SELECT COUNT(*) AS followers FROM follows WHERE following_id  = ?");
$stmtFollowers->bind_param("i", $userId);
$stmtFollowers->execute();
$followersResult = $stmtFollowers->get_result();
$followersCount = $followersResult->fetch_assoc()['followers'];
$stmtFollowers->close();

$stmtFollowing = $conn->prepare("SELECT COUNT(*) AS following FROM follows WHERE follower_id = ?");
$stmtFollowing->bind_param("i", $userId);
$stmtFollowing->execute();
$followingResult = $stmtFollowing->get_result();
$followingCount = $followingResult->fetch_assoc()['following'];
$stmtFollowing->close();

// Fetch all posts from the database along with their like counts
$stmtPosts = $conn->prepare("SELECT P.post_id, P.content, P.batch, P.image_base64, P.created_at, P.image_mime_type, COUNT(L.like_id) AS like_count
                             FROM posts P
                             LEFT JOIN likes L ON P.post_id = L.post_id
                             WHERE P.user_id = ?
                             GROUP BY P.post_id
                             ORDER BY P.created_at DESC");
$stmtPosts->bind_param("i", $userId);
$stmtPosts->execute();
$postsResult = $stmtPosts->get_result();
$posts = $postsResult->fetch_all(MYSQLI_ASSOC);
$numPosts = $postsResult->num_rows;
$stmtPosts->close();

$groupedPosts = [];
foreach ($posts as $post) {
    $batch = $post['batch'];
    if ($batch === null) {
        $groupedPosts[] = [$post];
    } else {
        $groupedPosts[$batch][] = $post;
    }
}

// Sort groups by created_at
usort($groupedPosts, function($a, $b) {
    return strtotime($b[0]['created_at']) - strtotime($a[0]['created_at']);
});

?>

<main id="main" class="main">

<div class="pagetitle d-flex">
    <div>
        <h1>ACCOUNT</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="feeds.php">Home</a></li>
            </ol>
        </nav>
    </div>
    <!--<div style="margin-left:auto;">-->
    
    <!--<a href="search.php"><button class="btn btn-primary" data-target="#new-task-modal" data-toggle="modal" style="height:40px;">search users</button></a>-->
</div>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row justify-content-center">
        <!-- User Info Column -->
        <div class="col-lg-3 col-md-4 col-sm-12 text-center">
            <img src="data:<?php echo $user['img_mime_type']; ?>;base64,<?php echo $user['img']; ?>" class="img-fluid rounded-circle mb-3" alt="Profile Image" style="width: 150px; height: 150px; object-fit: cover;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($user['username']); ?></h5>
                    <p class="card-text">Followers: <?php echo $followersCount; ?></p>
                    <p class="card-text">Following: <?php echo $followingCount; ?></p>
                    <p class="card-text">Posts: <?php echo $numPosts; ?></p>
                </div>
            </div>
        </div>

        <!-- Posts Column -->
        <div class="col-lg-8 col-md-8 col-sm-12">
            <?php foreach ($groupedPosts as $batchPosts): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <?php if (count($batchPosts) > 1): ?>
                    <div class="post-content mb-3">
                        <!-- Carousel for multiple posts -->
                        <br>
                        <div id="carousel-<?php echo $batchPosts[0]['batch']; ?>" class="carousel slide" data-bs-ride="carousel">
                            <br>
                            <div class="carousel-inner">
                                <?php foreach ($batchPosts as $index => $post): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <?php if ($post['image_base64']): ?>
                                    <img src="data:<?php echo $post['image_mime_type']; ?>;base64,<?php echo $post['image_base64']; ?>" class="d-block w-100 img-fluid" alt="Post Image" style="height: 500px;">
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $batchPosts[0]['batch']; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $batchPosts[0]['batch']; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <p class="card-text mt-2" style="font-size:20px; font-weight: 900; text-align: center;"><?php echo $batchPosts[0]['content']; ?></p>
                        <p class="text-muted"><?php echo $batchPosts[0]['created_at']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-primary like-btn" style="background-color: blue;color:white;">
                                LIKES <span class="like-count"><?php echo $post['like_count']; ?></span>
                            </button>
                            <button class="btn btn-outline-primary del-btn" style="background-color: red;color:white;" data-post-id="<?php echo $batchPosts[0]['post_id']; ?>">
                                DELETE 
                            </button>
                        </div>
                    </div>
                    <?php else: ?>
                    <!-- Single post -->
                    <div class="post-content mb-3">
                        <br>
                        <?php if ($batchPosts[0]['image_base64']): ?>
                        <img src="data:<?php echo $batchPosts[0]['image_mime_type']; ?>;base64,<?php echo $batchPosts[0]['image_base64']; ?>" class="img-fluid" alt="Post Image">
                        <?php endif; ?>
                        <p class="card-text mt-2" style="font-size:20px; font-weight: 900; text-align: center;"><?php echo $batchPosts[0]['content']; ?></p>
                        <p class="text-muted"><?php echo $batchPosts[0]['created_at']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-primary like-btn" style="background-color: blue;color:white;">
                                LIKES <span class="like-count"><?php echo $post['like_count']; ?></span>
                            </button>
                            <button class="btn btn-outline-primary del-btn" style="background-color: red;color:white;" data-post-id="<?php echo $batchPosts[0]['post_id']; ?>">
                                DELETE 
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
</main>

<?php
include 'footer.php';
?>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const deleteButtons = document.querySelectorAll('.del-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const postCard = this.closest('.card');
            
            fetch('action/del_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ post_id: postId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    postCard.style.display = 'none';
                } else {
                    console.error('Failed to delete the post.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>

<style>
.card-img-top {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
}

.card-text {
    font-size: 1rem;
    font-weight: 400;
}

.post-content img {
    width: 100%;
    height: auto;
    max-height: 600px;
    object-fit: cover;
}
</style>
