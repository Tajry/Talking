<?php 
    session_start();
    require_once 'config.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        


        try {
            $stmt = $conn->prepare("UPDATE user SET password = ? WHERE userID = ? ");
            $stmt->bindParam(1 , $_POST['new_password']);
            $stmt->bindParam(2 , $_SESSION['userID']);
            if ($stmt->execute()) {
                echo json_encode(array('message'=>true));
            }
           

        }catch(PDOException $e) {
            echo "error". $e->getMessage();
        }





    }



?>