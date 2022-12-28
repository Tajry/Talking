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
   <div class="way">
    <a href="index.php">หลับ</a>
    <p>กระทู้ > แสดงควมคิดเห็น</p>
   </div>

    <div class="content">
        
        <?php 
            try {
                $stmt=$conn->prepare("SELECT 
                 comment.commentID,
                 comment.userID,
                 comment.subject,
                 comment.comment,
                 comment.time,
                 user.username,
                 user.profile,
                 user.email
                 FROM comment INNER JOIN user 
                 ON comment.userID = user.userID WHERE comment.commentID = ? 
                 ");
                $stmt->bindParam(1, $_GET['commentid']);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $e){
                echo "error".$e->getMessage();
            }
            // print_r($data);
        ?>
        <div class="comment">
            <div class="cm_header">
                <h3><?php echo $data[0]['subject'] ?></h3>
                <div style="display:flex;align-items:center;">
                    <img src="./img-profile/<?php echo $data[0]['profile'] ?>" style="margin:0 10px ;width:50px;border-radius:50%;" alt="">
                    <p><?php echo $data[0]['username'] ?></p>
                </div>
            </div>
            <div class="cm_content">
                <p><?php echo $data[0]['comment'] ?></p>
            </div>
            <div class="cm_footer">
                <p id="date"><?php echo $data[0]['time'] ?></p>
            </div>
        </div>
        
        

    </div>
    <div class="answer">
        <form id="answer">
            <input type="hidden" name="commentID" id="cmid" value="<?php echo $_GET['commentid'] ?>">
            <textarea name="answer" id="an" cols="30" rows="10"></textarea>
            <button type="submit">ส่งความคิดเห็น</button>
        </form>
    </div>
   
    
    <div class="content" id="showanswer" style="min-width:100%;">

        <?php 
            try {
                $select=$conn->prepare("SELECT 
                 answer.answerID,
                 answer.commentID,
                 answer.userID,
                 answer.answer,
                 answer.time,
                 user.username,
                 user.profile,
                 user.email
                 FROM answer INNER JOIN user 
                 ON answer.userID = user.userID WHERE answer.commentID = ? 
                 ");
                $select->bindParam(1, $_GET['commentid']);
                $select->execute();
                $answer = $select->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $e){
                echo "error".$e->getMessage();
            }
            // print_r($data);
            foreach($answer as $row) {
        ?>
        <div class="comment">
            <div class="cm_header">
                <img src="./img-profile/<?php echo $row['profile'] ?>" style="width:50px;border-radius:50%;" alt="">  
                <p><?php echo $row['username']?></p>
            </div>
            <div class="cm_content">
                <p><?php echo $row['answer']?></p>
            </div>
            <div class="cm_footer">
                <p id="date"><?php echo $row['time']?></p>

                <?php if($row['userID'] == $_SESSION['userID']) {?>
                    <div class="btn">
                        <a id="edit" href="edit_answer.php?answerID=<?php echo $row['answerID']?>&&commentid=<?php echo $_GET['commentid']?>">แก้ไข</a>
                        <a id="del" onclick="del(<?php echo $row['answerID'] ?>)">ลบ</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

        
        
        

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
            $('#answer').submit(function(e){
                e.preventDefault();
                
                if ($('#an').val() != "") {
                    $.ajax({
                    url:'../server/answer.php',
                    data:$(this).serialize(),
                    type:"post",
                    success:function(res){
                        let data = JSON.parse(res);
                        if (data.message ==  true) {
                            $('.modal').css('display' , 'flex')
                            $('#cmid').val("");
                            $('#an').val("");
                            $('#showanswer').load(window.location.href + ' #showanswer')

                            setTimeout(() => {
                                $('.modal').css('display' , 'none')
                                
                            }, 1500);
                        }
                    },
                    catch:function(err){
                        console.log(err)
                    }
                    })

                }else {
                    alert('โปรดป้อน ความคิดเห็น');
                }
               
            })
        })


        function del(id) {
            if (confirm("คุณต้องการทีจะลบ หรือไม่") == true) {
                $.ajax({
                url:'../server/del_answer.php?answerid='+id,
                type:"get",
                success:function(res){
                if (res) {
                    $('.modal').css('display' , 'flex')
                        
                        setTimeout(() => {
                            location.reload()
                        }, 1500);
                }
                },
                catch:function(err){
                    console.log(err)
                }
                })
            }
        }

       
        
           
        
    </script>


</body>
</html>