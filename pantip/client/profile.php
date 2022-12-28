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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
   <?php 
   
   try {
    $stmt=$conn->prepare("SELECT * FROM user WHERE userID = ?");
    $stmt->bindParam(1 ,$_SESSION['userID']);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        echo "error".$e->getMessage();
    }

   
   ?>
    <div class="profile">
        <div class="box">
            <ul>
                <li>
                    <h4>รูป</h4>
                    <div class="image">
                        <img src="./img-profile/<?php echo $data[0]['profile'] ?>" alt="" >
                        <a onclick="OpenModalEditimage('<?php echo $data[0]['userID']?>')">edit</a>
                    </div>
                </li>
                <li>
                    <h4>ชื่อผู้ใช้</h4>
                    <p><?php echo $data[0]['username'] ?> <a onclick="OpenModalEditName('<?php echo $data[0]['userID']?>')" >edit</a></p>
                </li>
                <li>
                    <h4>อีเมล์</h4>
                    <p><?php echo $data[0]['email'] ?></p>
                </li>
                <li>
                    <h4>รหัสผ่าน</h4>
                    <p>****** <a onclick="OpenModalEditPassword('<?php echo $data[0]['userID']?>')">edit</a></p>
                </li>
               
            </ul>
        </div>
    </div>

    <style>

        .modal{
            position:fixed;
            top:0;
            left:0;
            width: 100%;
            height: 100%;
            display:none;
            justify-content:center;
            align-items:center;
            background-color:rgba(0, 0, 0, 0.5);
            
        }
       
        .modal-body{
            min-width: 50%;
            min-height: 75%;
            background:#fff;
            /* border:1px solid black; */
            padding:50px;
            position:relative;
            border-radius:10px;


        }
        .form-modal {
            display:flex ;
            flex-direction:column;
            margin:20px 10px;
        }
        .form-modal label {
            font-size:20px;
            margin:10px 0px;
        }
        .form-modal #new-name {
            padding:10px;
            font-size:20px;
            border-radius:10px;



        }
        .form-modal button {
            border:none;
            padding:5px 10px ;
            background:green;
            color:#fff;
            border-radius:10px;
        }
        #xmark {
            position:absolute;
            top:10px;
            right:20px;
            font-size:20px;
            color:red;
        }
        #xmark-pass {
            position:absolute;
            top:10px;
            right:20px;
            font-size:20px;
            color:red;
        }

        #xmark-image {
            position:absolute;
            top:10px;
            right:20px;
            font-size:20px;
            color:red;
        }

        li a {
            cursor: pointer;
            color:blue;
        }
        #box-image {
            /* overflow:scroll; */


        }
        .image-modal {
            display:flex;
            flex-wrap:wrap;
            max-width:100%;
            /* overflow:auto; */
            
        }
        /* .image-modal img {
            width: 100px;
            border-radius:50%;
            border:1px solid red;
        } */

        .image-modal label img {
            width: 100px;
            height: 100px;
            border: 2px solid gray;
            border-radius: 50%;
        
        
        }
        .image-modal input[type="radio"] {
            /* display:none; */
            /* width: 20px; */
        }
        .image-modal #profile1:checked + label #profileimg1 {
            border-color: green;
            
        }
        .image-modal #profile2:checked + label #profileimg2 {
            border-color: green;
            
        }
        .image-modal #profile3:checked + label #profileimg3 {
            border-color: green;
            
        }
        .image-modal #profile4:checked + label #profileimg4 {
            border-color: green;
            
        }
        .image-modal #profile5:checked + label #profileimg5 {
            border-color: green;
            
        }

        #submitimg {
            position: absolute;
            bottom: 10px; right: 20px;
            background:green;
            /* background: linear-gradient(to right, red, yellow); */
            color:#fff;
            border-radius:10px;
            border:none;
            padding:10px 20px;
            transition:all .2s ;
        }

        #submitimg:hover {
            transform:scale(1.2);
        }

        #success {
            background:none;
            display:none;
        }
        
        #message {
            font-size:25px;
            color:#fff;
            display:flex;
            justify-content:center;
            align-items:center;
            background-color:rgba(0, 0, 0, 0.2);
            min-width: 40%;
            min-height: 40%;
            
        }
       

        
    </style>

    <div class="modal" id="Editimage">
        <div class="modal-body"id="box-image">
            <i class="fas fa-xmark" id="xmark-image"></i>
            <div class="image-modal">
                <form id="chenageprofile">
                    <input type="radio" name="img-1" id="profile1" value="profile1.png">
                    <label for="img-1"><img src="./img-profile/profile1.png" id="profileimg1" alt=""></label>

                    <input type="radio" name="img-1" id="profile2" value="profile2.jpg">
                    <label for="img-1"><img src="./img-profile/profile2.jpg" id="profileimg2" alt=""></label>

                    <input type="radio" name="img-1" id="profile3" value="profile3.jpg">
                    <label for="img-1"><img src="./img-profile/profile3.jpg" id="profileimg3" alt=""></label>

                    <input type="radio" name="img-1" id="profile4" value="profile4.png">
                    <label for="img-1"><img src="./img-profile/profile4.png" id="profileimg4" alt=""></label>

                    <input type="radio" name="img-1" id="profile5" value="profile5.png">
                    <label for="img-1"><img src="./img-profile/profile5.png" id="profileimg5" alt=""></label>
                </div>
                <button stype="submit" id="submitimg">เปลี่ยน</button>
            </form>

        </div>  
    </div>

    <div class="modal" id="Editname">
        <div class="modal-body">
            <i class="fas fa-xmark" id="xmark"></i>
            <form id="updateusername">
                <div class="form-modal">
                    <label for="">ชื่อใหม่</label>
                    <input type="text" name="new_name" id="new-name">
                </div>
                <div class="form-modal">
                   <button type="submit">เปลี่ยน</button>
                </div>
            </form>
        </div>

    </div>


    <div class="modal" id="Editpassword">
        <div class="modal-body">
            <i class="fas fa-xmark" id="xmark-pass"></i>
            <form id="updatepassword">
                <div class="form-modal">
                    <label for="">รหัสผ่านใหม่</label>
                    <input type="text" name="new_password" id="new-password">
                </div>
                <div class="form-modal">
                   <button type="submit" id="btn-pass">เปลี่ยน</button>
                </div>
            </form>
        </div>
    </div>


    <div class="modal" id="success">
        <div class="modal-body" id="message">
           <h3 class="text-success">เปลี่ยนข้อมูลเรียบร้อย </h3>
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
            $('#xmark').click(function(e) {
                $('.modal').css('display', 'none');
            }) 
            $('#xmark-pass').click(function(e) {
                $('.modal').css('display', 'none');
            }) 

            $('#xmark-image').click(function(e) {
                $('.modal').css('display', 'none');
            }) 


            $('#btn-pass').attr('disabled' , true)

            $('#new-password').change(function(e){
                if (e.target.value.length >= 8) {
                    $('#btn-pass').attr('disabled' , false)
                }else {
                    alert("รหัสผ่านอย่างน้อย 8 ตัวอักษร")
                }
            })




            $('#chenageprofile').submit(function(e){
                e.preventDefault();
                console.log($(this).serialize())
                $.ajax({
                    url:'../server/edit_profile_image.php',
                    data:$(this).serialize(),
                    type:"post",
                    success:function(res){
                       if (res) {
                          $('#success').css('display', 'flex')
                          setTimeout(() => {
                            location.reload();
                          }, 300);
                       }
                    },
                    catch:function(err){
                        console.log(err)
                    }
                    })

            })

            $('#updateusername').submit(function(e){
                e.preventDefault();
                console.log($(this).serialize())
                $.ajax({
                    url:'../server/update_username.php',
                    data:$(this).serialize(),
                    type:"post",
                    success:function(res){
                       if (res) {
                          $('#success').css('display', 'flex')
                          setTimeout(() => {
                            location.reload();
                          }, 300);
                       }
                    },
                    catch:function(err){
                        console.log(err)
                    }
                    })

            })

            $('#updatepassword').submit(function(e){
                e.preventDefault();
                console.log($(this).serialize())
                $.ajax({
                    url:'../server/update_password.php',
                    data:$(this).serialize(),
                    type:"post",
                    success:function(res){
                       if (res) {
                          $('#success').css('display', 'flex')
                          setTimeout(() => {
                            location.reload();
                          }, 300);
                       }
                    },
                    catch:function(err){
                        console.log(err)
                    }
                    })

            })

            


            
            
            
        })

       function OpenModalEditName(id) {
            $('#Editname').css('display', 'flex');
       }

       function OpenModalEditPassword(id) {
            $('#Editpassword').css('display', 'flex');
       }

       function OpenModalEditimage(id) {
            $('#Editimage').css('display', 'flex');
       }

       
        
           
        
    </script>



</body>
</html>