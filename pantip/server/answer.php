<?php 
    session_start();
    require_once 'config.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $commentid = $_POST['commentID'];
        $userID = $_SESSION['userID'];
        $answer = $_POST['answer'];
        

        date_default_timezone_set("Asia/Bangkok");
        $date = date("Y/m/d H:i:s");


        try {
            $stmt = $conn->prepare("INSERT INTO answer(commentID ,userID ,answer ,time ) VALUES(? ,? ,? ,?)");
            $stmt->bindParam(1 ,$commentid);
            $stmt->bindParam(2 ,$userID);
            $stmt->bindParam(3 ,$answer);
            $stmt->bindParam(4 ,$date);

            if ($stmt->execute()) {
                echo json_encode(array('message'=>true));
            }else {
                echo json_encode(array('message'=>false));

            }

        }catch(PDOException $e) {
            echo "error". $e->getMessage();
        }





    }



?>