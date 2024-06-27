
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>POST</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
       
 
  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href= 'assets/vendor/bootstrap/css/bootstrap.min.css' rel="stylesheet">
  <link href= 'assets/vendor/bootstrap-icons/bootstrap-icons.css' rel="stylesheet">
  <link href= 'assets/vendor/boxicons/css/boxicons.min.css' rel="stylesheet">
  <link href= 'assets/vendor/quill/quill.snow.css' rel="stylesheet">
  <link href= 'assets/vendor/quill/quill.bubble.css' rel="stylesheet">
  <link href= 'assets/vendor/remixicon/remixicon.css' rel="stylesheet">
  <link href= 'assets/vendor/simple-datatables/style.css' rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href= 'assets/css/style.css' rel="stylesheet">

</head>

<body>

  <main style="background-image: linear-gradient(45deg, rgb(8, 101, 70),rgb(52, 75, 75));">
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4" >
        <div  style="margin-bottom: 30px;color: white;font-size: 30px;font-weight: 800;font-family: 'Times New Roman', Times, serif;text-align: center;">
          <h1 >WELCOME </h1>
          <h2>LOGIN</h2>
        </div>
        
        <div class="container" >
          
          
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <!-- Center the logo image in all views -->
<!-- <div class="d-flex justify-content-center py-4">
  <a href="#" class="logo d-flex align-items-center w-auto">
    <img src="assets/img/logo.png" alt="" class="mx-auto"> 
    <span class="d-none d-lg-block">AJ DATA</span>
  </a>
</div> -->
<!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">
                  <div class="pt-4 pb-2">
                  <div class="card mb-3 text-center">
                  <!-- <img src="assets/img/logo.png" alt="" style="width: 50%;margin-left: 75px;"> -->
                </div>
                  </div>

                  <form action="action/login_action.php" method="POST"  class="row g-3 needs-validation" novalidate>
                    <?php if (isset($_SESSION['succ'])){?>
                      <h2 style="background-color:green;color:white;"> SIGNUP SUCESSFUL</H2>
                      <?php } 
                      unset($_SESSION['succ']); ?>
                    <?php if (isset($_SESSION['feed'])){?>
                      <h2 style="background-color:red;color:white;"><?php echo $_SESSION['feed']?> </h2>
                      <?php } 
                      unset($_SESSION['feed']); ?>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <br>
                    <div class="col-12">
                      <button class="btn btn-success w-100" type="submit" name="login-btn">Login</button>
                      <!-- <a href="{% url 'home' class="btn btn-primary w-100">Login</a> -->
                    </div>
                    <div class="col-12">
                      <p class="small mb-0" ><a href="#" style="color: rgb(195, 32, 32);">Forgotten Password</a></p>
                    </div>

                    <div class="col-12">
                      <p class="small mb-0">New User? <a href='sign_up.php'>Sign IN</a></p>
                    </div>

                  
                   <br>
                   <br>
                  </form>

                </div>
              </div>

            

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src= 'assets/vendor/apexcharts/apexcharts.min.js'></script>
  <script src= 'assets/vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
  <script src= 'assets/vendor/chart.js/chart.min.js'></script>
  <script src= 'assets/vendor/echarts/echarts.min.js'></script>
  <script src= 'assets/vendor/quill/quill.min.js'></script>
  <script src= 'assets/vendor/simple-datatables/simple-datatables.js'></script>
  <script src= 'assets/vendor/tinymce/tinymce.min.js'></script>
  <script src= 'assets/vendor/php-email-form/validate.js'></script>

  <!-- Template Main JS File -->
  <script src= 'assets/js/main.js'></script>

</body>

</html>