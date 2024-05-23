<?php 

try {

    $pdo = new PDO('mysql:host=localhost;dbname=projektifinal', 'root', '');  

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    if(isset($_GET['delete'])) {

        $delete_id = $_GET['delete'];

        $delete_query = "DELETE FROM upload WHERE id = :id";

        $stmt = $pdo->prepare($delete_query);

        $stmt->bindParam(':id', $delete_id);

        if($stmt->execute()) {
            echo "<script>alert('Produkti eshte i fshire')</script>";
            echo "<script>window.open('product.php','_self');</script>";

        }

    }



   

}

catch (PDOException $e) {

    echo 'Connection failed: ' . $e->getMessage();

}

?> 

</table>

</body>



</html>

