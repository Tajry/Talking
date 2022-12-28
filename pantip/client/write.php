<?php 
session_start();
require_once '../server/config.php';
if (!isset($_SESSION['username'])) {
    header("location:../index.php");
}

// require_once 'config.php';

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $subject = $_POST['subject'];
//     $userID = $_SESSION['userID'];
//     $comment = $_POST['comment'];
    
    

//     date_default_timezone_set("Asia/Bangkok");
//     $date = date("Y/m/d H:i:s");


//     try {
//         $stmt = $conn->prepare("INSERT INTO comment(userID ,subject , comment ,time ) VALUES(? ,? ,? ,?)");
//         $stmt->bindParam(1 ,$userID);
//         $stmt->bindParam(2 ,$subject);
//         $stmt->bindParam(3 ,$comment);
//         $stmt->bindParam(4 ,$date);

//         if ($stmt->execute()) {
//            header("location:write.php");
//         }else {
//             echo json_encode(array('message'=>false));

//         }

//     }catch(PDOException $e) {
//         echo "error". $e->getMessage();
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/answer.css?parameter=1">
    <title>Talking to fun</title>
</head>
<body>
    <div class="header">
        <h1>Talking to fun</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">หน้าหลัก</a></li>
            <li><a href="write.php">เขียน</a></li>
            <li><a href="recore.php">กระทู้ของฉัน</a></li>
            <li><a href="profile.php">โปรไฟล์</a></li>
            <?php if(isset($_SESSION['username'])) { ?>
                <li><a href="../server/logout.php">ออกจากระบบ</a></li>
            <?php }else { ?>
                <li><a href="../index.php">เข้าสู่ระบบ</a></li>
            <?php } ?>
        </ul>
        <div class="search">
            
        </div>
    </nav>
   
    <div class="write">
        <form id="Add_comment" >
            <div class="form-control">
                <label for="">เรื่อง</label>
                <input type="text" name="subject" id="sub" placeholder="ชื่อเรื่อง" required>
            </div>
            <div class="form-control">
                <label for="">คำอธิบาย</label>
                <textarea name="comment" id="cm" cols="30" rows="10" required style="height:200px" ></textarea>
            </div>
            <div class="form-control">
                <button type="submit" >เผยแพร่</button>
            </div>
        </form>
    </div>

    <style>
        .modal {
            position: fixed ;
            top:0;
            left:0;
            width: 100%;
            height: 100%;
            display:none;
            justify-content:center;
            align-items:center;
        }
        .modal-body {
            width: 40%;
            background:rgba(0 , 0 , 0 ,0.5);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:50px;
            border-radius:20px;
            color:#fff;
            
        }
    </style>

    <div class="modal" id="success">
        <div class="modal-body" id="message">
           <h3 class="text-success">เพิ่มข้อมูลเรียบร้อย </h3>
        </div>
    </div>


    

    <footer>
        <div class="items">
            <h3>Profile</h3>
            <ul>
                <li>Mr. jirayut</li>
                <li>thailand</li>
            </ul>
        </div>
        <div class="items">
            <h3>About</h3>
            <ul>
                <li>website</li>
                <li>taking</li>
                <li>Thailand</li>
            </ul>
        </div>
        <div class="items">
            <h3>More</h3>
            <ul>
                <li>learning to code</li>
            </ul>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#Add_comment').submit(function(e){
                e.preventDefault();
                $('.modal').css('display' , 'flex')
                setTimeout(() => {
                    if (check()) {
                    $.ajax({
                    url:'../server/create_comment.php',
                    data:$(this).serialize(),
                    type:"post",
                    success:function(res){
                        let data = JSON.parse(res);
                        if (data.message ==  true) {
                            $('.modal').css('display' , 'none')

                            $('#sub').val("");
                            $('#cm').val("");
                        }
                    },
                    catch:function(err){
                        console.log(err)
                    }
                    })

                    }else {
                        alert("โปรดกรอกไห้ครบ");
                    }
                }, 2000);
            })
        })


        function check() {

            if ($('#sub').val() == "" || $('#cm').val() == "") {
                return false;
            }else {
                return true;
            }
        }
           
        
    </script>



</body>
</html>