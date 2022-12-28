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
            <form id="login">
            <div class="input-groub">
               <h1 style="-webkit-text-stroke: 1px  navy;-webkit-text-stroke-color:black;">Talking login</h1>
            </div>
            <div class="input-groub">
                <label for="">อีเมลล์</label>
                <input type="email" name="email">
            </div>
            <div class="input-groub">
                <label for="">รหัสผ่าน</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="input-check">
                <input type="checkbox" id="check">
                <label for="">แสดงรหัสผ่าน</label>
            </div>
            <div class="input-groub">
               <button>เข้าสูระบบ</button>
            </div>
            </form>
            <div class="more">
                <p>ยังไม่มีบัญชี?</p>
                <a href="register.php">ลงชื่อเข้าใช้</a>
            </div>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#login').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url:'./server/login.php',
                    data:$(this).serialize(),
                    type:"post",
                    success:function(res){
                        let data = JSON.parse(res);
                        if (data.status==  true) {
                            window.location = "./client"
                        }else{
                            alert("อีเมล์ หรือ รหัสผ่านไม่ถูกต้อง !!");
                        }
                    },
                    catch:function(err){
                        console.log(err)
                    }
                })

            })
        })

        $('#check').click(function(e){

            if (this.checked) {
                $('#password').attr('type', 'text');
            }else {
                $('#password').attr('type', 'password');

            }
        }) 
           
        
    </script>
</body>
</html>