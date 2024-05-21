<?php
  session_start();

  if(!isset($_SESSION['username'])){
    header('Location: login.php');
  }
  else{
?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <?php include('includes/sidebar.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
      <?php include('includes/navbar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
        <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Hoverable Table</h4>
                    <p class="card-description"> Add class <code>.table-hover</code>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>User</th>
                            <th>Product</th>
                            <th>Sale</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                         
                        
              <?php
        try {
            include('includes/connect.php');

            $select = "SELECT * FROM upload";
            $stmt = $conn->query($select);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $fileId = $row['id'];
                $fileName = $row['fileName'];
                $fileUpload = $row['fileUpload'];
                $description = $row['fileDescription'];
                ?>
                <tr>
                    <td><?php echo $fileId; ?></td>
                    <td class="text-danger"><?php echo $fileName; ?></td>
                    <td><img src="assets/file/<?php echo $fileUpload; ?>" width="80" height="60"></td>
                    <td><?php echo $description?></td>
                    <td><a href="delete.php?delete=<?php echo $fileId; ?>" onclick="return confirm('A jeni i sigurt')">Delete</a></td>
                    <td><a href="update.php?update=<?php echo $fileId; ?>">Update</a></td>
                </tr>
                <?php
            }
          }  catch (PDOException $e) {

                    echo 'Connection failed: ' . $e->getMessage();
                
                }
                    ?>
                    </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include('includes/footer.php');?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>

<?php }?>
