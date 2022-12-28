<?php 

    session_start();
    require_once 'config.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $commentid = $_POST['commentID'];
        $subject = $_POST['subject'];
        $comment = $_POST['comment'];
        
        
        
        $userID = $_SESSION['userID'];
        date_default_timezone_set("Asia/Bangkok");
        $date = date("Y/m/d H:i:s");


        try {
            $stmt = $conn->prepare("UPDATE comment SET subject = ? , comment = ? WHERE commentID = ? ");
            $stmt->bindParam(1 ,$subject);
            $stmt->bindParam(2 ,$comment);
            $stmt->bindParam(3 ,$commentid);

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