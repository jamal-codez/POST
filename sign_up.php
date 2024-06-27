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

  <!-- Favicons
  <link href='assets/img/favicon.png" rel="icon">
  <link href='assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href='assets/vendor/bootstrap/css/bootstrap.min.css'  rel="stylesheet">
  <link href='assets/vendor/bootstrap-icons/bootstrap-icons.css'  rel="stylesheet">
  <link href='assets/vendor/boxicons/css/boxicons.min.css'  rel="stylesheet">
  <link href='assets/vendor/quill/quill.snow.css'  rel="stylesheet">
  <link href='assets/vendor/quill/quill.bubble.css'  rel="stylesheet">
  <link href='assets/vendor/remixicon/remixicon.css'  rel="stylesheet">
  <link href='assets/vendor/simple-datatables/style.css'  rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href='assets/css/style.css'  rel="stylesheet">

</head>

<body>

  <main style="background-image: linear-gradient(45deg, rgb(8, 101, 70),rgb(52, 75, 75));">
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div  style="margin-bottom: 30px;color: white;font-size: 30px;font-weight: 800;font-family: 'Times New Roman', Times, serif;text-align: center;">
          <!-- <h1 >WELCOME TO AJ_DATA</h1> -->
          <h2>SIGN UP</h2>
        </div>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="card mb-3">

                <div class="card-body">
                  <div class="pt-4 pb-2">
                  <div class="card mb-3 text-center">
                  <!-- <img src='assets/img/logo.png" alt="" style="width: 50%;margin-left: 75px;"> -->
                  <!--<h3 style="color:#36beae;"> JAMAL DEV</h3>-->
                </div>
                  </div>

                  <form action="action/signup_action.php" method="POST"  enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                  <div class="form-group">
                                       <!-- <label for="applicant_image" class="col-sm-2 col-form-label">Upload </label> -->
                                       <!-- <div class="col-sm-6 d-flex align-items-center"> -->
                                       <div class="row mb-3 justify-content-center">
                                       <div class="col-sm-6 align-items-center justify-content-center">
                                          <img id="selectedImagePreview" class="img-thumbnail text-center" alt="Selected Image Preview"
                                          style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; display:none;">
                                       </div>
                                    </div>
                                       <div class="form-group">
                                          <!-- <input type="file" name="image" id="image" class="form-control" size="30" required disabled>
                                          <div class="invalid-feedback"> Image</div>
                                          <button type="button" class="bi bi-camera ml-10" onclick="openCamera()"></button> 
                                          <button type="button" style="border: none;" onclick="openCamera()"><img src="icons/camera.png" alt="Camera Icon" style="width: 30px; height: 30px;" ></button>
                                          
                                          <input type="hidden" id="webcam_image" name="webcam_image"> -->

                                          <input type="file" name="image" id="image" class="form-control" size="30" style="display: none;" multiple>
                              <!-- Button to trigger the file input -->
                              <button type="button" id="uploadButton" class="btn btn-primary">Choose File</button>
                              <div class="invalid-feedback"> Image</div>
                              <button type="button" style="border: none;" onclick="openCamera()"><img src="icons/camera.png" alt="Camera Icon" style="width: 30px; height: 30px;" ></button>
                              <input type="hidden" id="webcam_image" name="webcam_image">
                                       </div>

                                    <!-- Modal for camera interface -->
                                    <div class="modal" id="cameraModal" tabindex="-1" role="dialog">
                                       <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <h5 class="modal-title">Camera Interface</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeCameraModal()">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                             </div>
                                             <div class="modal-body">
                                                <video id="cameraFeed" width="100%" height="auto" autoplay></video>
                                                <button type="button" class="btn btn-primary" onclick="captureImage()">Capture</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <script>
                                      document.getElementById('uploadButton').addEventListener('click', function() {
    document.getElementById('image').click();
});
                                       document.getElementById('image').addEventListener('change', function (e) {
                                           var fileInput = e.target;
                                           var selectedImagePreview = document.getElementById('selectedImagePreview');
                                       
                                           if (fileInput.files && fileInput.files[0]) {
                                               var reader = new FileReader();
                                       
                                               reader.onload = function (e) {
                                                   selectedImagePreview.src = e.target.result;
                                                   selectedImagePreview.style.display = 'block';
                                               };
                                       
                                               reader.readAsDataURL(fileInput.files[0]);
                                           }
                                       });
                                    </script>
                                    <script>
                                       function openCamera() {
                                            // Show the camera modal
                                            $('#cameraModal').modal('show');
                                            var video = document.getElementById('cameraFeed');
                                            var constraints = { video: true };
                                            navigator.mediaDevices.getUserMedia(constraints)
                                                .then(function (stream) {
                                                    video.srcObject = stream;
                                                })
                                                .catch(function (err) {
                                                    console.error('Error accessing webcam:', err);
                                                });
                                        }
                                        function captureImage() {
                                            var video = document.getElementById('cameraFeed');
                                            var canvas = document.createElement('canvas');
                                            var context = canvas.getContext('2d');
                                            // Set canvas dimensions to the same as the video feed
                                            canvas.width = video.videoWidth;
                                            canvas.height = video.videoHeight;
                                            // Draw the video frame onto the canvas
                                            context.drawImage(video, 0, 0, canvas.width, canvas.height);
                                            // Convert the captured image to data URL
                                            var dataURL = canvas.toDataURL('image/png');
                                            // Set the data URL as the source for the selected image preview
                                            selectedImagePreview.src = dataURL;
                                            selectedImagePreview.style.display = 'block';
                                            // Set the base64 data as a hidden input value to send to the server
                                            var hiddenInput = document.getElementById('webcam_image');
                                            hiddenInput.value = dataURL.split(',')[1]; // Remove the "data:image/png;base64," prefix
                                            // Hide the camera modal using Bootstrap's modal function
                                            closeCameraModal();
                                        }
                                        function closeCameraModal() {
                                            // Stop the video stream to release the camera
                                            var video = document.getElementById('cameraFeed');
                                            var stream = video.srcObject;
                                            var tracks = stream.getTracks();
                                            tracks.forEach(track => track.stop());
                                            // Hide the camera modal using Bootstrap's modal function
                                            $('#cameraModal').modal('hide');
                                        }
                                    </script>
                                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                 </div>
                    <div class="col-12">
                      <div class="input-group has-validation" style="display: flex;">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <div class="col-12">
                          <label for="yourUsername" class="form-label">First Name</label>
                          <input type="text" name="firstname" class="form-control" id="yourUsername" required>
                          <div class="invalid-feedback">Please enter your username.</div>
                       </div>

                       <div class="col-12">
                          <label for="yourUsername" class="form-label">Last Name</label>
                          <input type="text" name="lastname" class="form-control" id="yourUsername" required>
                          <div class="invalid-feedback">Please enter your username.</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Gender</label>
                      <!-- <input type="text" name="gender" class="form-control" id="yourUsername" required> -->
                      

                      <select class="form-control" name="gender" placeholder="Gender" required>
                                          <option value="">Gender</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                       </select>
                                       <div class="invalid-feedback">Please enter your Username!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Username</label>
                      <input type="text" name="username" class="form-control" id="yourUsername" required>
                      <div class="invalid-feedback">Please enter your Username!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your Email!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password1" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="password2" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
  <input type="checkbox" name="agree" class="form-check-input" id="agreeCheckbox" required>
  <label class="form-check-label" for="agreeCheckbox">I agree with the terms and conditions.</label>
  <div class="invalid-feedback">Please check the box to agree.</div>
</div>

                    <br>
                    <div class="col-12">
                      <button class="btn btn-success w-100" type="submit" name="login-btn">Submit</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already a user? <a href='index.php'>Login</a></p>
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
  <script src='assets/vendor/apexcharts/apexcharts.min.js' ></script>
  <script src='assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ></script>
  <script src='assets/vendor/chart.js/chart.min.js' ></script>
  <script src='assets/vendor/echarts/echarts.min.js' ></script>
  <script src='assets/vendor/quill/quill.min.js' ></script>
  <script src='assets/vendor/simple-datatables/simple-datatables.js' ></script>
  <script src='assets/vendor/tinymce/tinymce.min.js' ></script>
  <script src='assets/vendor/php-email-form/validate.js' ></script>

  <!-- Template Main JS File -->
  <script src='assets/js/main.js' ></script>

</body>

</html>