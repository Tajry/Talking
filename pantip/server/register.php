<?php 
    session_start();
    require_once 'config.php';

    

    

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
       $username = $_POST['username'];
       $email = $_POST['email'];
       $password = $_POST['password'];
        
        

        date_default_timezone_set("Asia/Bangkok");
        $date = date("Y/m/d H:i:s");


        try {
            $stmt = $conn->prepare("SELECT email FROM user WHERE email = ? ");
            $stmt->bindParam(1 ,$email);
            // $stmt->bindParam(2 ,$password);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(array('message'=>"no user",'stats'=>false));
            }else {
                $insert= $conn->prepare("INSERT INTO user(profile ,username , email ,password) VALUES('profile1.png' ,? ,? ,? ) ");
                $insert->bindParam(1 , $username);
                $insert->bindParam(2 , $email);
                $insert->bindParam(3 , $password);
                if ($insert->execute()) {
                    $select= $conn->prepare("SELECT * FROM user WHERE email = ? ");
                    $select->bindParam(1 , $email);
                    $select->execute();
                    $row = $select->fetchAll(PDO::FETCH_ASSOC);

                    $_SESSION['userID'] = $row[0]['userID'];
                    $_SESSION['username'] = $row[0]['username'];
                    $_SESSION['email'] = $row[0]['email'];
                    
                
                    echo json_encode(array('message'=>'succes','status'=>true));
                }
                

            }

        }catch(PDOException $e) {
            echo "error". $e->getMessage();
        }





    }





?>


