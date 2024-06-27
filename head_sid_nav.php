 <?php
session_start(); 
if (empty($_SESSION['loggedInUser'])) {
    echo "<html>
<head>
    <title>Redirecting...</title>
    <script type='text/javascript'>
        window.location.replace('index.php');
    </script>
</head>";
    exit;
    // session_destroy();
    // header("Location: index.php");
    // exit;
}

include "./includes/connection.php";


// ob_end_flush();

 // Flush the output

 $id=$_SESSION['id'] ;

$sql = "SELECT * FROM `users` WHERE `user_id`='$id'";
$applicant_q = $conn->query($sql);
$user = $applicant_q->fetch_assoc();



$dbImage = $user["img"];

// Decode base64 string to binary data
$imageData = ($dbImage !== NULL) ? base64_decode($dbImage) : '';

$dataUri = ($dbImage !== NULL) ? 'data:image/png;base64,' . $dbImage : '';

$stmtFollowers = $conn->prepare("SELECT COUNT(*) AS followers FROM follows WHERE following_id  = ?");
$stmtFollowers->bind_param("i", $id);
$stmtFollowers->execute();
$followersResult = $stmtFollowers->get_result();
$followersCount = $followersResult->fetch_assoc()['followers'];
$stmtFollowers->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>JAMAL PHP</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link href="../assets/img/logo/logo.png" rel="icon">
  <link href="../assets/img/logo/logo.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- css2 -->
<link rel="stylesheet" href="assets/css2/bootstrap.min.css">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-dataTransactions/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<style>
  /* Default button style */
.like-btn {
    /* Add your default button styles here */
    outline: none;
}

/* Style for Like state */
.like-btn.like {
    /* Add your Like button styles here */
    color: green;
    outline: 2px solid green; /* Text color for Like state */
}

/* Style for Unlike state */
.like-btn.unlike {
    /* Add your Unlike button styles here */
    color: red;
    outline: 2px solid red; /* Text color for Unlike state */
}

/* Hover effect for Like state */
.like-btn.like:hover {
    background-color: lightgreen; /* Green hover color for Like state */
}

/* Hover effect for Unlike state */
.like-btn.unlike:hover {
    background-color: red; /* Red hover color for Unlike state */
}

/* Add this CSS to your existing stylesheet */
.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #808080; /* Ash color */
    opacity: 0.7; /* Adjust opacity as needed */
    transition: background-color 0.3s ease;
    top: 50%; /* Position arrows vertically at 50% from the top */
    transform: translateY(-50%); /* Adjust vertically to center */
}

.carousel-control-prev {
    left: 10px; /* Position the previous arrow */
}

.carousel-control-next {
    right: 10px; /* Position the next arrow */
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: #808080; /* Darker ash color on hover */
}


</style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <!-- <img src=".\assets\img\logo.png" alt="logo"> -->

      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    
    <div style="margin-left:auto;display:flex;">
            <a href="post.php"><button class="btn btn-primary" style="margin-right:20px;" data-target="#new-task-modal" data-toggle="modal" style="height:40px;"> Make a Post</button></a>
            <a href="search.php"><button class="btn btn-primary" data-target="#new-task-modal" data-toggle="modal" style="height:40px;">Follow Users</button></a>
        </div>


    <div class="search-bar" style="margin-left: auto;">
  <div class="d-flex align-items-center ">
    
  </div>
</div>



  </header><!-- End Header -->


  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <section class="section profile">
          <div class="row">
            <div class="col-xl-12">
    
              <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                  <?php  
                  if ($dbImage !== null){
                      echo '<img src="' . $dataUri . '" alt="Image" style="width: 150px; height: 110px; object-fit: cover; border-radius: 50%;">';
                  }else{
                      echo '<img src="icons/pp.png" alt="Image" style="width: 150px; height: 110px; object-fit: cover; border-radius: 50%;">';
                  }
                   ?>
                  <div class="text-center">
                    <h5 class="card-title"><?php echo htmlspecialchars($user['username']); ?></h5>
                    <p class="card-text" style="font-size:20px; font-weight: 900;">Followers: <?php echo $followersCount; ?></p>
                    <!-- <p class="card-text">Following: <?php echo $followingCount; ?></p>
                    <p class="card-text">Posts: <?php echo $numPosts; ?></p> -->
                </div>
                </div>

              </div>
            </div>
          </div>
        </section>

        <li class="nav-item">
          <a class="nav-link collapsed" href="feeds.php">
            <i class="bi bi-grid"></i>
            <span>Posts</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="account.php">
            <i class="bi bi-grid"></i>
            <span>My Account</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="profile.php">
            <i class="bi bi-grid"></i>
            <span>Profile</span>
          </a>
        </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Login Page Nav -->

      

    </ul>

  </aside><!-- End Sidebar-->