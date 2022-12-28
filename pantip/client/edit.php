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
   
    <div class="write">
        <?php 
            try {
                $stmt=$conn->prepare("SELECT * FROM comment WHERE commentID = ? ");
                $stmt->bindParam(1 , $_GET['commentid']);
                $stmt->execute();

                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        ?>
        <form id="Add_comment">
            <div class="form-control">
                <label for="">เรื่อง</label>
                <input type="hidden" name="commentID" value="<?php echo $_GET['commentid'] ?>">
                <input type="text" name="subject" id="sub" value="<?php echo $row[0]['subject'] ?>" placeholder="ชื่อเรื่อง">
            </div>
            <div class="form-control">
                <label for="">คำอธิบาย</label>
                <textarea name="comment" id="cm"  cols="30" rows="10">
                <?php echo $row[0]['comment'] ?>
                </textarea>
            </div>
            <div class="form-control">
                <button type="submit">เผยแพร่</button>
            </div>
        </form>
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
                if (check()) {
                    $.ajax({
                    url:'../server/edit.php',
                    data:$(this).serialize(),
                    type:"post",
                    success:function(res){
                        let data = JSON.parse(res);
                        if (data.message ==  true) {
                            alert("แก้ไขกระทู้เรียบร้อย");
                            setTimeout(() => {
                                window.location = "recore.php";
                            }, 200);
                        }
                    },
                    catch:function(err){
                        console.log(err)
                    }
                    })

                }else {
                    alert("โปรดกรอกไห้ครบ");
                }
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