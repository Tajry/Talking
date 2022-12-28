<?php 
    session_start();
    require_once 'config.php';

    $_GET['commentid'];
    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y/m/d H:i:s");


    try {
        $stmt = $conn->prepare("DELETE FROM comment WHERE commentID = ? ");
        $stmt->bindParam(1 ,$_GET['commentid']);

        if ($stmt->execute()) {
            $answerdel = $conn->prepare("DELETE FROM answer WHERE commentID = ? ");
            $answerdel->bindParam(1 ,$_GET['commentid']);
            $answerdel->execute();
            
            echo json_encode(array('message'=>true));
        }else {

            echo json_encode(array('message'=>false));

        }

    }catch(PDOException $e) {
        echo "error". $e->getMessage();
    }





    



?>