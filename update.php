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
    <br>
  

  <form action="action/update_action.php" method="POST"  enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
  <div class="card-body profile-card pt-4 d-flex  align-items-center justify-content-center">
  <img id="selectedImagePreview" class="img-thumbnail text-center" alt="Selected Image Preview"
                                          style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; display:none;">
                  <?php  echo '<img id= "hideimg" src="' . $dataUri . '" alt="Image"  style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; display:block;">'; ?>
                  <!-- <button type="button" style="border: none;" onclick="openCamera()"><img src="icons/camera.png" alt="Camera Icon" style="width: 30px; height: 30px;" ></button> -->
                </div>
                <div class="row mb-3 justify-content-center">
                                       <div class="col-sm-6 align-items-center justify-content-center">
                                          <!-- <img id="selectedImagePreview" class="img-thumbnail text-center" alt="Selected Image Preview"
                                          style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; display:none;"> -->
                                       </div>
                                    </div>
                                       <div class="form-group">
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
                                           var hideimg = document.getElementById('hideimg');
                                       
                                           if (fileInput.files && fileInput.files[0]) {
                                               var reader = new FileReader();
                                       
                                               reader.onload = function (e) {
                                                   selectedImagePreview.src = e.target.result;
                                                   selectedImagePreview.style.display = 'block';
                                                   hideimg.style.display = 'none';
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
                                            hideimg.style.display = 'none';
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
    <div class="col-12">
      <label for="yourUsername" class="form-label">Username</label>
      <div class="input-group has-validation">
        <input type="text" name="nn" class="form-control" value= "<?php echo $user['username'];?>" >
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
    </div>
    <div class="col-12">
      <label for="yourUsername" class="form-label">First Name</label>
      <div class="input-group has-validation">
        <input type="text" name="firstname" class="form-control" id="yourUsername" value= "<?php echo $user['firstname'];?>" >
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
    </div>
    <div class="col-12">
      <label for="yourUsername" class="form-label">Last Name</label>
      <div class="input-group has-validation">
        <input type="text" name="lastname" class="form-control" id="yourUsername" value= "<?php echo $user['lastname'];?>" >
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
    </div>
    <div class="col-12">
      <label for="yourUsername" class="form-label">Email</label>
      <div class="input-group has-validation">
        <input type="text" name="email" class="form-control"  value= "<?php echo $user['email'];?>">
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
    <div class="col-12">
      <label for="yourPassword" class="form-label">Last Updated</label>
      <input type="password" name="password" class="form-control"  value= "<?php echo $user['updated_at'];?>" disabled>
      <div class="invalid-feedback">Please enter your password!</div>
    </div>
    <br>
    <div class="col-12">
      <a href="update.php"><button class="btn btn-success w-100" type="submit" name="login-btn">Submit</button></a>
      <!-- <a href="{% url 'home' class="btn btn-primary w-100">Login</a> -->
    </div>
   <br>
   <br>
  </form>

</div>
</div>
      

        </div>
       
    </div>
</section>
</main>


    
 
<?php
include 'footer.php';
?>