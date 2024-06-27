<?php

session_start();
include_once 'head_sid_nav.php';

// if ( !isset($_SESSION['loggedInUser']) ){
//   FlashMessage::redirect('index.php');exit;
// }

?>

<main id="main" class="main">

<div class="pagetitle d-flex">
    <div>
  <h1>MAKE POST</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item active">Post</li>
    </ol>
  </nav>
</div>

</div><!-- End Page Title -->



<section class="section dashboard">
    <div class="row justify-content-center">

    <!-- Left side columns -->
        <div class="col-lg-8 d-flex flex-column align-items-center justify-content-center">
        <div class="card mb-3">

<div class="card-body" style="width:400px;">

  <!-- <form action="action/login_action" method="POST"  class="row g-3 needs-validation" novalidate> -->
  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                  <?php  echo '<img src="' . $dataUri . '" alt="Image" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">'; ?>
                </div>
    <div class="col-12">
      <label for="yourUsername" class="form-label">Username</label>
      <div class="input-group has-validation">
        <input type="text" name="username" class="form-control" value= "<?php echo $user['username'];?>" disabled>
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
    </div>
    <div class="col-12">
      <label for="yourUsername" class="form-label">Full Name</label>
      <div class="input-group has-validation">
        <input type="text" name="username" class="form-control" id="yourUsername" value= "<?php echo $user['firstname'].' '.$user['lastname'];?>" disabled>
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
    </div>
    <div class="col-12">
      <label for="yourUsername" class="form-label">Email</label>
      <div class="input-group has-validation">
        <input type="text" name="username" class="form-control"  value= "<?php echo $user['email'];?>" disabled>
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
    </div>
    <div class="col-12">
      <label for="yourUsername" class="form-label">Gender</label>
      <div class="input-group has-validation">
        <input type="text" name="username" class="form-control"  value= "<?php echo $user['gender'];?>" disabled>
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
    </div>
    <div class="col-12">
      <label for="yourPassword" class="form-label">Joining Date</label>
      <input type="text" name="password" class="form-control"  value= "<?php echo $user['created_at'];?>" disabled>
      <div class="invalid-feedback">Please enter your password!</div>
    </div>
    <br>
    <div class="col-12">
      <a href="update.php"><button class="btn btn-success w-100" type="submit" name="login-btn">Update Profile</button></a>
      <!-- <a href="{% url 'home' class="btn btn-primary w-100">Login</a> -->
    </div>
   <br>
   <br>
  <!-- </form> -->

</div>
</div>
      

        </div>
       
    </div>
</section>
</main>


    
 
<?php
include 'footer.php';
?>