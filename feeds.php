<?php
session_start();
include_once 'head_sid_nav.php';


// Get the logged-in user's ID
$loggedInUserId = $_SESSION['id'];

// Fetch posts from the database for the logged-in user and those they are following
$stmt = $conn->prepare("SELECT P.post_id, P.content, P.batch, P.created_at, P.image_base64, P.image_mime_type, U.username,
                       (SELECT COUNT(*) FROM likes L WHERE L.post_id = P.post_id) AS like_count
                       FROM posts P
                       JOIN users U ON P.user_id = U.user_id
                       WHERE P.user_id = ? OR P.user_id IN (
                           SELECT following_id FROM follows WHERE follower_id = ?
                       )
                       ORDER BY P.created_at DESC");
$stmt->bind_param("ii", $loggedInUserId, $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Group posts by batch, treating NULL batches individually
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
            <h1>POST FEEDS</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <!--<div style="margin-left:auto;">-->
        <!--    <a href="post.php"><button class="btn btn-primary" data-target="#new-task-modal" data-toggle="modal" style="height:40px;"> Make a Post</button></a>-->
        <!--    <a href="search.php"><button class="btn btn-primary" data-target="#new-task-modal" data-toggle="modal" style="height:40px;">Follow Users</button></a>-->
        <!--</div>-->
    </div>
    <!-- End Page Title -->
    <section class="section dashboard">
        <div class="row justify-content-center">
            <!-- Posts Column -->
            <div class="col-lg-8">
                <?php foreach ($groupedPosts as $batchPosts): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <?php if (count($batchPosts) > 1): ?>
                        <div class="post-content mb-3">
                            <!-- Carousel for multiple posts -->
                            <div id="carousel-<?php echo $batchPosts[0]['batch']; ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="user-info">
                                    <h5 class="card-title"><?php echo htmlspecialchars($batchPosts[0]['username']); ?></h5>
                                </div>
                                <div class="carousel-inner">
                                    <?php foreach ($batchPosts as $index => $post): ?>
                                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                        <?php if ($post['image_base64']): ?>
                                        <img src="data:<?php echo $post['image_mime_type']; ?>;base64,<?php echo $post['image_base64']; ?>" class="d-block w-100" alt="Post Image" style="height: 500px;width: 600px;">
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
                                <span><?php echo $batchPosts[0]['username']; ?></span>
                                <?php 
                                    $stmtCheckFollow = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                                    $stmtCheckFollow->bind_param("ii", $loggedInUserId, $batchPosts[0]['post_id']);
                                    $stmtCheckFollow->execute();
                                    $isFollowing = $stmtCheckFollow->get_result()->num_rows > 0;
                                    $stmtCheckFollow->close();
                                ?>
                                <button id="lk-btn" class="btn btn-outline-primary like-btn <?php echo $isFollowing ? 'unlike' : 'like'; ?>" data-post-id="<?php echo $batchPosts[0]['post_id']; ?>">
                                <?php echo $isFollowing ? 'Unlike ' : 'Like '; ?><span class="like-count"><?php echo $batchPosts[0]['like_count']; ?></span>
                                </button>
                            </div>
                        </div>
                        <?php else: ?>
                        <!-- Single post -->
                        <div class="post-content mb-3">
                            <div class="user-info">
                                <h5 class="card-title"><?php echo $batchPosts[0]['username']; ?></h5>
                            </div>
                            <?php if ($batchPosts[0]['image_base64']): ?>
                            <img src="data:<?php echo $batchPosts[0]['image_mime_type']; ?>;base64,<?php echo $batchPosts[0]['image_base64']; ?>" alt="Post Image">
                            <?php endif; ?>
                            <p class="card-text mt-2" style="font-size:20px; font-weight: 900; text-align: center;"><?php echo $batchPosts[0]['content']; ?></p>
                            <p class="text-muted"><?php echo $batchPosts[0]['created_at']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span><?php echo $batchPosts[0]['username']; ?></span>
                                <?php 
                                    $stmtCheckFollow = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                                    $stmtCheckFollow->bind_param("ii", $loggedInUserId, $batchPosts[0]['post_id']);
                                    $stmtCheckFollow->execute();
                                    $isFollowing = $stmtCheckFollow->get_result()->num_rows > 0;
                                    $stmtCheckFollow->close();
                                ?>
                                <button id="lk-btn" class="btn btn-outline-primary like-btn <?php echo $isFollowing ? 'unlike' : 'like'; ?>" data-post-id="<?php echo $batchPosts[0]['post_id']; ?>">
                                <?php echo $isFollowing ? 'Unlike ' : 'Like '; ?><span class="like-count"><?php echo $batchPosts[0]['like_count']; ?></span>
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
<?php include 'footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const likeButtons = document.querySelectorAll('.like-btn');
        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                fetch('action/like_post.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ post_id: postId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const likeCountSpan = this.querySelector('.like-count');
                        likeCountSpan.textContent = data.like_count;

                        this.classList.toggle('like');
                    this.classList.toggle('unlike');

                        const textNode = this.firstChild;
                    if (textNode.nodeType === Node.TEXT_NODE) {
                        if (textNode.textContent.includes('Like')) {
                            textNode.textContent = 'Unlike ';
                            this.style.outline= '2px solid red';
                        } else if (textNode.textContent.includes('Unlike')) {
                            textNode.textContent = 'Like ';
                            this.style.outline= '2px solid green';
                        }
                    }
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
<style>
    .post-content img {
    width: 100%;
    height: auto;
    max-height: 600px; /* Adjust as needed */
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
    .user-info {
    margin-right: 15px;
    }
</style>
