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
   </div>
   <!-- End Page Title -->
   <section class="section dashboard">
      <div class="row justify-content-center">
         <!-- Left side columns -->
         <div class="col-lg-8 d-flex flex-column align-items-center justify-content-center">
            <div class="card mb-3">
               <div class="card-body">
                  <!-- Form to create multiple posts -->
                  <form action="action/post_action.php" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                     <div id="postsContainer">
                        <div class="post">
                           <div class="row mb-3">
                              <div class="col-sm-6 ">
                                 <div id="imagePreviewContainer" class="d-flex" style="display:grid;">
                                    <!-- Selected images will be displayed here -->
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                           <input type="file" name="imag[]" id="image" class="form-control" size="30" style="display: none;" multiple>
                              <!-- Button to trigger the file input -->
                              <button type="button" id="uploadButton" class="btn btn-primary">Choose File</button>
                              <div class="invalid-feedback"> Image</div>
                              <button type="button" style="border: none;" onclick="openCamera()"><img src="icons/camera.png" alt="Camera Icon" style="width: 30px; height: 30px;" ></button>
                              <input type="hidden" id="webcam_image" name="webcam_image">
                           </div>
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
    var imagePreviewContainer = document.getElementById('imagePreviewContainer');

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-thumbnail');
            img.style.width = '150px';
            img.style.height = '150px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '50%';
            img.style.margin = '5px';
            imagePreviewContainer.appendChild(img);

            // Create hidden input for the image data
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'images[]';
            hiddenInput.style.display = 'none';
            // hiddenInput.value = e.target.result; 
            hiddenInput.value = e.target.result.split(',')[1]; // Remove the "data:image/png;base64," prefix
            imagePreviewContainer.appendChild(hiddenInput);

        };
        reader.readAsDataURL(fileInput.files[0]);
    }
});

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
    // Create an image element for preview
    var img = document.createElement('img');
    img.src = dataURL;
    img.classList.add('img-thumbnail');
    img.style.width = '150px';
    img.style.height = '150px';
    img.style.objectFit = 'cover';
    img.style.borderRadius = '50%';
    img.style.margin = '5px';
    var imagePreviewContainer = document.getElementById('imagePreviewContainer');
    imagePreviewContainer.appendChild(img);
    
    // Create hidden input for the image data
    var hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'images[]';
    hiddenInput.value = dataURL.split(',')[1]; // Remove the "data:image/png;base64," prefix
    imagePreviewContainer.appendChild(hiddenInput);
    
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



function triggerFileInput() {
    document.querySelector('.post:last-child input[type="file"]').click();
}


                           </script>
                           <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                           <div class="col-12 mb-3">
                              <label for="postComment1" class="form-label">Comment</label>
                              <textarea class="form-control" id="postComment1" name="comment" rows="3" required></textarea>
                              <div class="invalid-feedback">
                                 Please enter a comment for your post.
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- <div class="col-12">
                        <button class="btn btn-secondary" type="button" onclick="addPost()">Add Another Post</button>
                     </div> -->
                     <div class="col-12">
                        <button class="btn btn-primary" type="submit">POST</button>
                     </div>
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
