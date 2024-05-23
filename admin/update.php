<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title> Update </title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        form {
            width: 50%;
            margin: 120px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 99;
        }

        input[type="text"],
        textarea {
            width: calc(100% - 20px);
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        img {
            display: block;
        }

        #a1{
            background-color: #353535;
            color: white;
            padding: 11px 45px;
            border-radius: 58px;
            border: 1px solid #353535;
            font-size: 14px;
            letter-spacing: 2px;
            font-family: 'Teko', sans-serif;
            transition: all .3s;
            cursor: pointer;
        }
        #a1:hover{
            color: #353535;
            transition: 0.3s;
            scale: 1.06;
            background-color: white;
        }
    </style>
</head>

<body>
    <?php

    include('includes/connect.php');
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=projektifinal', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(isset($_GET['update'])){
            $update_id = $_GET['update'];
            $select = "SELECT * FROM upload  WHERE id=:id";
            $stmt = $pdo->prepare($select);
            $stmt->bindParam(':id', $update_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <form method='post' action="update_ID.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
        File Name:<input type="text" name="fileName" value="<?php echo $row['fileName'];?>">
        <br><br>
        File Upload:<input type="file" name="fileUpload" placeholder="assets/file/<?php echo $row['fileUpload'];?>">
        <img src="assets/file/<?php echo $row['fileUpload'];?>" width="100" height="100">
        <br><br>
        File Description:<textarea name="description" cols="30" rows="20"><?php echo $row['fileDescription'];?>
                </textarea>
        <br><br>
        <input type="submit" name="update" value="Update">
    </form>
    <?php 
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>
</body>

</html>