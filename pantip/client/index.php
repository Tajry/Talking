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
    <link rel="stylesheet" href="./css/answer1.css?parameter=1">
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
            <form action="" method="GET">
                <input type="search"  placeholder="ค้นหาที่นี้" name="search">
                <button type="submit">ค้นหา</button>
            </form>
        </div>
    </nav>
    <div class="way">
        <p>กระทู้ ></p>
       </div>

    <div class="content" style="min-height:100vh;">
        
        <?php 
            try {
                
            
                if (!isset($_GET['search'])) {
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
                    ON comment.userID = user.userID
                    ");
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                }else {
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
                    ON comment.userID = user.userID WHERE comment.subject LIKE  ?  ");
                    $search = $_GET['search'];

                    $stmt->execute(array("$search%"));
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                }

            }catch(PDOException $e){
                echo "error".$e->getMessage();
            }
            
            if (!empty($data)) {
                foreach($data as $row) {
        ?>
                <div class="comment">
                    <div class="cm_header">
                        <h3><?php echo $row['subject'] ?></h3>
                        <div style="display:flex;align-items:center;">
                            <img src="./img-profile/<?php echo $row['profile'] ?>" style="border-radius:50%;margin:0 10px;" width="50px" alt="">
                            <p><?php echo $row['username'] ?></p>
                        </div>
                    </div>
                    <div class="cm_content">
                        <p><?php echo $row['comment'] ?></p>
                    </div>
                    <div class="cm_footer">
                        <p id="date"><?php echo $row['time'] ?></p>
                        <a href="answer.php?commentid=<?php echo $row['commentID'] ?>">ตอบ</a>
                    </div>
                </div>
        <?php 
                } 
    
            }else {
                echo "<p>ไม่มีกระทู้ค้นหา</p>";
            }
        ?>
        
        


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




</body>
</html>