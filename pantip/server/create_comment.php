<?php 

    session_start();
    require_once 'config.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $subject = $_POST['subject'];
        $userID = $_SESSION['userID'];
        $comment = $_POST['comment'];
        
        

        date_default_timezone_set("Asia/Bangkok");
        $date = date("Y/m/d H:i:s");


        try {
            $stmt = $conn->prepare("INSERT INTO comment(userID ,subject , comment ,time ) VALUES(? ,? ,? ,?)");
            $stmt->bindParam(1 ,$userID);
            $stmt->bindParam(2 ,$subject);
            $stmt->bindParam(3 ,$comment);
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