
<?php 
session_start();
require_once '../server/config.php';
if (!isset($_SESSION['username'])) {
    header("location:../index.php");
}


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
    <div class="way">
        <p>กระทู้ ></p>
       </div>

    <div class="content" style="min-height:100vh" id="d">

        <?php 
        
        try {
            $stmt=$conn->prepare("SELECT 
                 comment.commentID,
                 comment.userID,
                 comment.subject,
                 comment.comment,
                 comment.time,
                 user.username,
                 user.email
                 FROM comment INNER JOIN user 
                 ON comment.userID = user.userID WHERE user.userID = ? 
                 ");
                $stmt->bindParam(1 ,$_SESSION['userID']);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
            }catch(PDOException $e){
                echo "error".$e->getMessage();
            }
            if (!empty($data)) {
                foreach($data as $row){
        ?>
                <div class="comment" style="min-width:100%;">
                    <div class="cm_header">
                        <h3><?php echo $row['subject'] ?></h3>
                        <p><?php echo $row['username'] ?></p>
                    </div>
                    <div class="cm_content">
                        <p><?php echo $row['comment'] ?></p>
                    </div>
                    <div class="cm_footer">
                        <p id="date"><?php echo $row['time'] ?></p>
                    <div class="btn">
                        <a href="answer.php?commentid=<?php echo $row['commentID'] ?>">ตอบ</a>
                        <a id="edit" href="edit.php?commentid=<?php echo $row['commentID'] ?>">แก้ไข</a>
                        <a id="del" onclick="del(<?php echo $row['commentID'] ?>)">ลบ</a>
                    </div>
                    </div>
                </div>

        <?php 
                } 
    
            }else {
                echo "<p>ไม่มีกระทู้ของคุณ</p>";
                
            }
        ?>


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
           <h3 class="text-success">ทำรายการสำเร็จ </h3>
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
            
        })


        function del(id) {

           if (confirm("คุณต้องการทีจะลบ หรือไม่") == true) {
                $.ajax({
                url:'../server/del.php?commentid='+id,
                type:"get",
                success:function(res){
                    $('.modal').css('display' , 'flex')
                    setTimeout(() => {
                        window.location = "recore.php"
                    }, 1500);
                },
                catch:function(err){
                    console.log(err)
                }
                })
           }else {

           }
        }
           
        
    </script>



</body>
</html>