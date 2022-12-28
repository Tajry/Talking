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
    <a href="answer.php?commentid=<?php echo $_GET['commentid'] ?>">หลับ</a>
    <p>กระทู้ > แก้ไข</p>
   </div>

    <div class="content">
        
        
        
        

    </div>

    <?php 
            try {
                $select=$conn->prepare("SELECT * FROM answer WHERE answerID = ? ");
                $select->bindParam(1, $_GET['answerID']);
                $select->execute();
                $answer = $select->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $e){
                echo "error".$e->getMessage();
            }
            // print_r($data);
        
        ?>
    <div class="answer">
        <form id="answer">
            <input type="hidden" name="answerID" id="cmid" value="<?php echo $_GET['answerID'] ?>">
            <textarea name="answer" id="an" cols="30" rows="10"><?php echo $answer[0]['answer'] ?></textarea>
            <button type="submit">แก้ไขความคิดเห็น</button>
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
            $('#answer').submit(function(e){
                e.preventDefault();
                
                $.ajax({
                url:'../server/edit_an.php',
                data:$(this).serialize(),
                type:"post",
                success:function(res){
                    let data = JSON.parse(res);
                    if (data.message ==  true) {
                       alert("แก้ไขเรียบร้อยแล้ว");
                       location.reload();
                    }
                },
                catch:function(err){
                    console.log(err)
                }
                })

               
            })
        })


        
       
        
           
        
    </script>


</body>
</html>