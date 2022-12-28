<?php 
    session_start();
    require_once 'config.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        


        try {
            $stmt = $conn->prepare("UPDATE user SET profile = ? WHERE userID = ? ");
            $stmt->bindParam(1 , $_POST['img-1']);
            $stmt->bindParam(2 , $_SESSION['userID']);
            if ($stmt->execute()) {
                echo json_encode(array('message'=>true));
            }
           

        }catch(PDOException $e) {
            echo "error". $e->getMessage();
        }





    }



?>