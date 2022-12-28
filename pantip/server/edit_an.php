<?php 

session_start();
    require_once 'config.php';

if (isset($_POST['answerID'])) {
    try {

        $stmt = $conn->prepare("UPDATE answer SET answer = ? WHERE answerID = ? ");
        $stmt->bindParam(1 ,$_POST['answer']);
        $stmt->bindParam(2 ,$_POST['answerID']);

        if ($stmt->execute()) {
            echo json_encode(array('message'=>true));
            
        }else {
            echo json_encode(array('message'=>false));

        }


    }catch(PDOXeception $e){
        echo "error".$e->getMessage();
    }
}



?>