<?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=projektifinal', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(isset($_POST['update'])) {

            $fileId = $_POST['id'];
            $fileName1 = $_POST['fileName'];
            $fileDescription1 = $_POST['description'];
            $fileUpload1 = $_FILES['fileUpload']['name'];
            $fileUpload1_tmp = $_FILES['fileUpload']['tmp_name'];

            if(!move_uploaded_file($fileUpload1_tmp, "file/$fileUpload1")) {
                echo "<script>alert('You can't upload this image!')</script>";
            }

            if($fileName1 == '' || $fileDescription1 == '' || $fileUpload1 == '') {
                echo "<script>alert('Ndonjera prej fushave eshte e zbrazet')</script>";
                echo "<script>window.open('product.php','_self');</script>";
                exit();
            } else {	
                $update_query = "UPDATE upload SET
                    fileName = :fileName1,
                    fileUpload = :fileUpload1,
                    fileDescription = :fileDescription1
                    WHERE
                    id = :fileId";
                
                $stmt = $pdo->prepare($update_query);
                $stmt->bindParam(':fileName1', $fileName1);
                $stmt->bindParam(':fileUpload1', $fileUpload1);
                $stmt->bindParam(':fileDescription1', $fileDescription1);
                $stmt->bindParam(':fileId', $fileId);
                
                if($stmt->execute()) {
                    echo "<script>alert('File is updated!')</script>";
                    echo "<script>window.open('product.php','_self');</script>";
                }
            }
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>