<?php 
    session_start();
    require_once 'config.php';

    $_GET['answerid'];
    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y/m/d H:i:s");


    try {
        $stmt = $conn->prepare("DELETE FROM answer WHERE answerID = ? ");
        $stmt->bindParam(1 ,$_GET['answerid']);

        if ($stmt->execute()) {
            echo json_encode(array('message'=>true));
        }else {
            echo json_encode(array('message'=>false));

        }

    }catch(PDOException $e) {
        echo "error". $e->getMessage();
    }





    



?>