<?php
// Include connection.php and start the session
include "./includes/connection.php";

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Secure Navy Town OJO</title>
      <meta content="" name="description">
      <meta content="" name="keywords">
      <!-- Favicons -->
      <link href="../assets/img/logo/logo.png" rel="icon">
      <link href="../assets/img/logo/logo.png" rel="apple-touch-icon">
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
   </head>
   <body>
      <!-- ======= Header ======= -->
      <header id="header" class="header fixed-top d-flex align-items-center">
         <div class="d-flex align-items-center justify-content-between">  
            <a href="#" class="logo d-flex align-items-center" style="margin-left: 220px;">
            <img src=".\assets\img\logo.png" alt="logo">
            <span class="d-none d-lg-block" style="font-size: 16px;margin-left: 41px;">SECURE NAVY TOWN OJO</span>
            </a>
         </div>
         <!-- End Logo -->
         <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
               <li class="nav-item dropdown">
                  <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                     <i class="bi bi-bell"></i>
                     <!-- <span class="badge bg-primary badge-number"> </span> -->
                  </a>
                  <!-- End Notification Icon -->
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                     <li class="dropdown-header">
                        You have no notifications
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                     </li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li class="dropdown-footer">
                        <a href="#">Show all notifications</a>
                     </li>
                  </ul>
                  <!-- End Notification Dropdown Items -->
               </li>
               <!-- End Notification Nav -->
               <li class="nav-item dropdown">
                  <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                     <i class="bi bi-chat-left-text"></i>
                     <!-- <span class="badge bg-success badge-number"></span> -->
                  </a>
                  <!-- End Messages Icon -->
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                     <li class="dropdown-header">
                        You have no new messages
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                     </li>
                     <li class="dropdown-footer">
                        <a href="#">Show all messages</a>
                     </li>
                  </ul>
                  <!-- End Messages Dropdown Items -->
               </li>
               <!-- End Messages Nav -->
               <li class="nav-item dropdown pe-3">
                  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                     <i class="bi bi-person" rounded-circle style="width: 20px;"></i>
                     <!-- <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo "$name"; ?></span> -->
                  </a>
                  <!-- End Profile Iamge Icon -->
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                     <li>
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                        </a>
                     </li>
                  </ul>
                  <!-- End Profile Dropdown Items -->
               </li>
               <!-- End Profile Nav -->
            </ul>
         </nav>
         <!-- End Icons Navigation -->
      </header>
      <!-- End Header -->
      <main id="main" class="main">
         <div class="pagetitle">
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item">Keke Payments</li>
               </ol>
            </nav>
         </div>
         <!-- End Page Title -->
         <?php include('message.php'); ?>
         <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
         <!-- DataTables CSS -->
         <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
         <!-- DataTables JS -->
         <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>
         <script>
            $(document).ready(function () {
                $("#myinput").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            });
         </script>
         <script>
            $(document).ready(function () {
              $('#user-list-table').DataTable();
            });
         </script>
         <section class="section">
            <div class="row">
            <div class="col-lg-14">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title form-group">Keke Payment table</h5>
                     <div class="export-section" style="text-align: end;">
                        <form action='#' method='POST'>
                           <input type="hidden" name="action" value="export_applicant">
                           <button class='btn btn-success' name='export' type='submit'><span
                              style='color:#ffff;'>Download Payment History</span></button>
                        </form>
                     </div>
                     <br>
                     <div class="form-group">
                        <input type="text" name="" id="myinput" placeholder="Search..." class="form-control">
                     </div>
                     <br>
                     <!-- Table with hoverable rows -->
                     <div class="table-responsive">
                        <table id="user-list-table" class="table table-hover table-bordered mt-4" role="grid">
                           <thead>
                              <tr class="table-success">
                                 <th scope="col">S/N</th>
                                 <th scope="col">Name</th>
                                 <th scope="col">keke No.</th>
                                 <th scope="col">Payment Status</th>
                                 <th scope="col">Last Payment Date</th>
                              </tr>
                           </thead>
                           <tbody id="myTable">
                              <?php
                                 // query all users
                                         $query = "SELECT * FROM applicant";
                                         $result = mysqli_query($conn, $query);
                                 
                                         // check if any users exist
                                         if (mysqli_num_rows($result) > 0) {
                                             // loop through each user and display as row in table
                                             $sn = 1;
                                             while ($row = mysqli_fetch_assoc($result)) {
                                                 // $idd = $row["id"];
                                                 // $quer = "SELECT * FROM card_info where c_id = $idd";
                                                 // $resul = mysqli_query($conn, $quer);
                                                 // $row1 = mysqli_fetch_assoc($resul);
                                                 //if ($row["rfid_n"] !== NULL){
                                                     echo "<tr>
                                                         <td>" . $sn++ . "</td>
                                                         <td>" . $row["name"] . "</td>
                                                         <td>" . $row["keke_no"] . "</td>";
                                                     
                                                     if($row["suspention"] == 0){
                                                         echo "<td>
                                                         <div class='btn-group gap-1' role='group'>
                                                             <div class='btn btn-danger btn-sm'>
                                                             <i class='bi bi-qrcode'></i> SUSPENDED
                                                             </div>
                                                         </div>
                                                     </td>";
                                                     }else if ($row["rfid_n"] == NULL){
                                                         echo "<td>
                                                         <div class='btn-group gap-1' role='group'>
                                                         <a class='btn btn-warning btn-sm' href='#'>
                                                             No card Assigned
                                                         </a>
                                                     </div>
                                                     </td>";
                                                     }
                                                     else if ($row["pay_status"] == false){
                                                         echo "<td ><div class='btn-group gap-1' role='group'>
                                                         <a class='btn btn-success btn-sm' href='invoice.php?id=" . $row["id"] . "&sect=invoice'>
                                                    <i class='bi bi-credit-card'></i> Pay
                                                </a>
                                                     </div></td>";
                                                     }else{
                                                         echo"<td><span class='badge bg-primary'>Paid</td>";
                                                     }
                                                     
                                                     echo "<td>23/5/2024</td>
                                         </tr>";
                                                 //}
                                             }
                                             // close table
                                             echo "</table>";
                                         } else {
                                             echo "No Users Found!";
                                         }
                                 
                                         // close database connection
                                         mysqli_close($conn);
                                         ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
      <?php
         include_once 'footer.php';
         ?>
      <script>
         function confirmSuspend() {
             return confirm("Are you sure you want to delete this applicant?");
         }
      </script>