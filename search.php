<?php
session_start();
include_once 'head_sid_nav.php'; // Adjust the path as necessary

// if (!isset($_SESSION['loggedInUser'])) {
//     FlashMessage::redirect('index.php'); exit;
// }

$userId = $_SESSION['id'];

// Fetch all users from the database
$stmtUser = $conn->prepare("SELECT user_id, username, img, img_mime_type FROM users");
$stmtUser->execute();
$userResult = $stmtUser->get_result();
$users = $userResult->fetch_all(MYSQLI_ASSOC);
$stmtUser->close();

?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $("#myinput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Handle follow/unfollow button clicks
        $('.follow-btn').on('click', function () {
            var button = $(this);
            var userId = button.data('user-id');

            $.ajax({
                url: 'action/follow_user.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ user_id: userId }),
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        if (data.followed) {
                            button.text('Unfollow');
                        } else {
                            button.text('Follow');
                        }
                    } else {
                        alert(data.message);
                    }
                },
                error: function (error) {
                    alert('Error: ' + error);
                }
            });
        });
    });
</script>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table td {
        padding: 10px;
        text-align: left;
    }

    table td {
        border-bottom: 1px solid #ccc;
    }

    table tbody tr:last-child td {
        border-bottom: none;
    }

</style>

<main id="main" class="main">

<div class="pagetitle d-flex">
    <div>
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div style="margin-left:auto;">
        <a href="feeds.php"><button class="btn btn-primary" data-target="#new-task-modal" data-toggle="modal" style="height:40px;">Posts</button></a>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="col-lg-14">
        <div class="card">
            <div class="card-body ">
                <br>
                <div class="form-group">
                    <input type="text" name="" id="myinput" placeholder="Search..." class="form-control">
                </div>
                <br>
            </div>
        </div>
    </div>
    <div class="card mb-3">

<div class="card-body">
    <div class="row justify-content-center">

        <div class="col-lg-8">
            <table id="myTable">
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php
                        // Check if the current user is already following this user
                        $stmtCheckFollow = $conn->prepare("SELECT * FROM follows WHERE follower_id = ? AND following_id = ?");
                        $stmtCheckFollow->bind_param("ii", $userId, $user['user_id']);
                        $stmtCheckFollow->execute();
                        $isFollowing = $stmtCheckFollow->get_result()->num_rows > 0;
                        $stmtCheckFollow->close();
                        ?>
                        <tr>
                            <td style="width:80px;"><img src="data:<?php echo $user['img_mime_type']; ?>;base64,<?php echo $user['img']; ?>" class="img-fluid" alt="Profile Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"></td>
                            <td><h5 class="card-title"><?php echo htmlspecialchars($user['username']); ?></h5></td>
                            <td><button class="btn btn-outline-primary follow-btn" data-user-id="<?php echo $user['user_id']; ?>">
                                <?php echo $isFollowing ? 'Unfollow' : 'Follow'; ?>
                            </button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
                    </div>
                    </div>
</section>
</main>

<?php
include 'footer.php';
?>

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
    max-height: 600px; /* Adjust as needed */
    object-fit: cover;
}

.follow-btn {
    width: 100px;
}
</style>
