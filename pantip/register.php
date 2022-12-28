<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./client/css/login.css">
    <title>login</title>
</head>
<body>

    <div class="content">
        <div class="box">
            <form id="register" >
                <div class="input-groub">
                <h1 style="-webkit-text-stroke: 1px  navy;-webkit-text-stroke-color:black;">Talking register</h1>
                </div>
                <div class="input-groub">
                    <label for="">ชื่อผู้ใช้</label>
                    <input type="text" name="username"  id="username">
                </div>
                <div class="input-groub">
                    <label for="">อีเมลล์</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="input-groub">
                    <label for="">รหัสผ่าน</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="input-groub">
                    <label for="">ยืนยันรหัสผ่าน</label>
                    <input type="password" id="password2" onchange="checkpassword()">
                </div>
                <div class="input-check">
                    <input type="checkbox" id="check">
                    <label for="">แสดงรหัสผ่าน</label>
                </div>
                <div class="input-groub">
                    <button type="submit">เข้าสูระบบ</button>
                </div>
            </form>
                <div class="more">
                    <p>มีบัญชีอยู่แล้ว?</p>
                    <a href="index.php">เข้าสู่ระบบ</a>
                </div>
            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#register').submit(function(e){
                e.preventDefault();
                if (check()) { 
                    if (checkpassword()) {

                        if ($('#password').val().length < 8) { // เช็คไม่ให้รหัสผ่านน้อยกว่า 8 ตัวอักษร หรือ ตัวเลข
                            alert('รหัสผ่านอย่างน้อย 8 ตัว')
                        }else {

                            $.ajax({
                                url:'./server/register.php',
                                data:$(this).serialize(),
                                type:"post",
                                success:function(res){
                                    let data = JSON.parse(res);
                                    if (data.status==  true) {
                                        window.location = "./client"
                                    }else{
                                        alert("อีเมล์นี้ ถูกใช้ไปแล้ว");
                                    }
                                },
                                catch:function(err){
                                    console.log(err)
                                }
                            })
                        }
                   
                    }else {
                        alert('โปรดป้อนรหัสผ่านให้ครงกัน');
                    }
                }else {
                    alert('โปรดป้อนข้อมูลให้ครบ ');
                }
               

            })


        })

        // เช็คไม่ให้มีค่าว่าง
        function check() {
            if ( $('#username').val() =="" ||  $('#email').val()=="" ||  $('#password').val()=="" ||  $('#password2').val()=="") {
                return false;
            }else {
                return true;

            }
        }
        // เช็คยืนยันรหัสผ่านให้ตรงกัน
        function checkpassword() {
            if ($('#password').val()  ===  $('#password2').val()) {
                return true;
            }else {
                return false;
                
            }
        }


        $('#check').click(function(e){

            if (this.checked) {
                $('#password').attr('type', 'text');
                $('#password2').attr('type', 'text');
            }else {
                $('#password').attr('type', 'password');
                $('#password2').attr('type', 'password');

            }
        }) 
        



        

        

        



    </script>
    
</body>
</html>