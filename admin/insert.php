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
        <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Basic form elements</h4>
                    <p class="card-description"> Basic form elements </p>
                    <form method="POST" class="forms-sample"enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">File Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="fileName">
                      </div>

                      <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="img[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="file" name="fileUpload" class="form-control file-upload-info" placeholder="Upload Image">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                          </span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                      </div>
                      <button type="submit" name="upload" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
              <?php

try {

    include('includes/connect.php');



    if (isset($_POST['upload'])) {

        $fileName = $_POST['fileName'];

        $fileDescription = $_POST['fileDescription'];

        $fileUpload = $_FILES['fileUpload']['name'];

        $fileUpload_tmp = $_FILES['fileUpload']['tmp_name'];



        if ($fileName == '' or $fileUpload == '') {

            echo "<script>alert('Any input is Empty');</script>";

        } else {

            // Check if file already exists

            $select = "SELECT * FROM upload WHERE fileName=:fileName OR fileUpload=:fileUpload LIMIT 1";

            $stmt = $conn->prepare($select);

            $stmt->bindParam(':fileName', $fileName);

            $stmt->bindParam(':fileUpload', $fileUpload);

            $stmt->execute();

            $exist = $stmt->fetch(PDO::FETCH_ASSOC);



            if ($exist) {

                echo "<script>alert('This file already exists!');</script>";

            } else {

                move_uploaded_file($fileUpload_tmp, "assets/file/$fileUpload");



                $uploadFile = "INSERT INTO upload(fileName, fileUpload, fileDescription)

                               VALUES(:fileName, :fileUpload, :fileDescription)";

                $stmt = $conn->prepare($uploadFile);

                $stmt->bindParam(':fileName', $fileName);

                $stmt->bindParam(':fileUpload', $fileUpload);

                $stmt->bindParam(':fileDescription', $fileDescription);



                if ($stmt->execute()) {

                    echo "<script>alert('File is Upload');</script>";

                } else {

                    echo "<script>alert('Upload Failed!');</script>";

                }

            }

        }

    }

} catch (PDOException $e) {

    echo 'Connection failed: ' . $e->getMessage();

}

?>
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