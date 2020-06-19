<?php
require_once('./php/config.php');

function test_input($data) {
    $data = trim($data);//去前后空格
    $data = stripslashes($data);//删除输入的反斜杠
    $data = htmlspecialchars($data);//把符号转为HTML实体
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

    $salt=base64_encode(mcrypt_create_iv(32,MCRYPT_DEV_RANDOM));//随机生成树并通过base64加密，加长长度
    $password = sha1($password . $salt);//哈希

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sql = "INSERT INTO traveluser (Email, UserName, SALTEDPASSHASH, SALT) VALUES (:email, :user, :pass, :sal)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user',$username);
    $statement->bindValue(':email',$email);
    $statement->bindValue(':pass',$password);
    $statement->bindValue(':sal',$salt);
    $statement->execute();
    header("Location: ./Login.php");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/Style.css" />
    <link rel="stylesheet" href="css/Register.css" />
    <script src="js/jQuery.min.js"></script>
    <base target="_self" />
    <title>注册</title>
</head>

<body>
    <h1 class="reg-title">Register</h1>

    <div class="reg-box-outer">
        <div class="reg-container">
            <div class="title"><span class="underline-yellow">注册</span></div>

            <form id="register_form" name="register_form" method="post">
                <div class="input-container">
                    <div class="inputBox">
                        <div id="usernameStar" style="padding: 0 5px; color: #f6e58d">*</div>
                        <input onkeyup="checkUsername(this.value);" type="text" name="username" placeholder="用户名" value="" />
                    </div>
                    <div id="username_Hint" class="hint-message" style="visibility: hidden"><i class="fa fa-info-circle" aria-hidden="true"></i> <span id="usernameHint"></span></div>

                    <div class="inputBox">
                        <div id="emailStar" style="padding: 0 5px; color: #f6e58d">*</div>
                        <input onkeyup="checkEMail(this.value);" type="email" name="email" placeholder="邮箱" value="" />
                    </div>
                    <div id="email_Hint" class="hint-message" style="visibility: hidden"><i class="fa fa-info-circle" aria-hidden="true"></i> <span id="emailHint"></span></div>

                    <div class="inputBox">
                        <div id="passwordStar" style="padding: 0 5px; color: #f6e58d">*</div>
                        <input onkeyup="checkPass(this.value);" onchange="reCheckPass(this.value, this.form.check_pass.value)" type="password" name="password" placeholder="密码" value="" />
                    </div>
                    <div id="password_Hint" class="hint-message" style="visibility: hidden"><i class="fa fa-info-circle" aria-hidden="true"></i> <span id="passwordHint"></span></div>

                    <div class="inputBox">
                        <div id="passwordCheckStar" style="padding: 0 5px; color: #f6e58d">*</div>
                        <input onkeyup="reCheckPass(this.form.password.value, this.value);" type="password" name="check_pass" placeholder="确认密码" value="" />
                    </div>
                    <div id="passwordCheck_Hint" class="hint-message" style="visibility: hidden"><i class="fa fa-info-circle" aria-hidden="true"></i> <span id="passwordCheckHint"></span></div>
                </div>

                <div class="last-row">
                    <div class="message"><a href="Login.php">已注册，去登录</a></div>

                    <div id="register_btn" class="reg-btn" onclick="onSubmit();">注册</div>
                </div>
            </form>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>

    <?php
    ?>

</body>

<script>
    function isUsernameValid(username) {
        let result = false;
        let xmlhttp;
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let isValid = this.responseText;
                if (isValid === "true"){
                    document.getElementById('usernameHint').innerText = "";
                    document.getElementById('username_Hint').style.visibility = "hidden";
                    document.getElementById('usernameStar').style.visibility = "hidden";
                }
                else{
                    document.getElementById('usernameHint').innerText = "用户名已存在";
                    document.getElementById('username_Hint').style.visibility = "visible";
                    document.getElementById('usernameStar').style.visibility = "visible";
                }
            }
        };
        let url = "./php/checkUsername.php?username=" + username + "&sid=" + Math.random();
        xmlhttp.open("GET", url, true);
        xmlhttp.send();

        if (document.getElementById('usernameStar').style.visibility === "hidden"){
            result = true;
        }
        return result;
    }

    function checkUsername(username) {
        let result = false;

        if(username === ""){
            document.getElementById('usernameHint').innerText = "请输入用户名";
            document.getElementById('username_Hint').style.visibility = "visible";
            document.getElementById('usernameStar').style.visibility = "visible";
        }
        else {
            let usernameFlag = /^[a-zA-Z0-9._]*$/.test(username);
            if(!usernameFlag){
                document.getElementById('usernameHint').innerText = "用户名只包括字母、数字、_和.";
                document.getElementById('username_Hint').style.visibility = "visible";
                document.getElementById('usernameStar').style.visibility = "visible";
            }
            else {
                document.getElementById('usernameHint').innerText = "";
                document.getElementById('username_Hint').style.visibility = "hidden";
                document.getElementById('usernameStar').style.visibility = "hidden";
                result = this.isUsernameValid(username);
            }
        }

        return result;
    }

    function isEMailValid(email) {
        let mailFlag = /^([\w-])+@([a-z/d])+((\.[a-z]{2,3}){1,2})$/.test(email);
        if (mailFlag){
            document.getElementById('emailHint').innerText = "";
            document.getElementById('email_Hint').style.visibility = "hidden";
            document.getElementById('emailStar').style.visibility = "hidden";
            return true;
        }
        else {
            document.getElementById('emailHint').innerText = "邮箱格式错误";
            document.getElementById('email_Hint').style.visibility = "visible";
            document.getElementById('emailStar').style.visibility = "visible";
            return false;
        }
    }

    function checkEMail(email) {
        let result = false;

        if(email === ""){
            document.getElementById('emailHint').innerText = "请输入邮箱";
            document.getElementById('email_Hint').style.visibility = "visible";
            document.getElementById('emailStar').style.visibility = "visible";
        }
        else {
            result = true;
            document.getElementById('emailHint').innerText = "";
            document.getElementById('email_Hint').style.visibility = "hidden";
            document.getElementById('emailStar').style.visibility = "hidden";
            result = this.isEMailValid(email);
        }

        return result;
    }

    function isPassValid(pass) {
        let result = false;
        if (pass.length < 6){
            document.getElementById('passwordHint').innerText = "密码长度必须大于6位";
            document.getElementById('password_Hint').style.visibility = "visible";
            document.getElementById('passwordStar').style.visibility = "visible";
        }
        else{
            let weakFlag =/^(?![a-zA-Z]+$)(?![0-9]+$)[a-zA-Z0-9!@#$%^&*]+$/.test(pass);
            if (!weakFlag){
                document.getElementById('passwordHint').innerText = "密码至少包括一个字母和数字";
                document.getElementById('password_Hint').style.visibility = "visible";
                document.getElementById('passwordStar').style.visibility = "visible";
            }
            else {
                result = true;
                document.getElementById('passwordHint').innerText = "";
                document.getElementById('password_Hint').style.visibility = "hidden";
                document.getElementById('passwordStar').style.visibility = "hidden";
            }
        }

        return result;
    }

    function checkPass(pass) {
        let result = false;

        if(pass === ""){
            document.getElementById('passwordHint').innerText = "请输入密码";
            document.getElementById('password_Hint').style.visibility = "visible";
            document.getElementById('passwordStar').style.visibility = "visible";
        }
        else {
            document.getElementById('passwordHint').innerText = "";
            document.getElementById('password_Hint').style.visibility = "hidden";
            document.getElementById('passwordStar').style.visibility = "hidden";
            result = isPassValid(pass);
        }

        return result;
    }

    function isReCheckPassValid(pass, checkPass) {
        let checkPassFlag = (pass === checkPass);
        if(checkPassFlag){
            document.getElementById('passwordCheckHint').innerText = "";
            document.getElementById('passwordCheck_Hint').style.visibility = "hidden";
            document.getElementById('passwordCheckStar').style.visibility = "hidden";
            return true;
        }
        else {
            document.getElementById('passwordCheckHint').innerText = "密码与第一次输入的不同";
            document.getElementById('passwordCheck_Hint').style.visibility = "visible";
            document.getElementById('passwordCheckStar').style.visibility = "visible";
            return false;
        }
    }

    function reCheckPass(pass, checkPass) {
        let result = false;

        if(checkPass === ""){
            document.getElementById('passwordCheckHint').innerText = "请再次输入密码";
            document.getElementById('passwordCheck_Hint').style.visibility = "visible";
            document.getElementById('passwordCheckStar').style.visibility = "visible";
        }
        else {
            result = true;
            document.getElementById('passwordCheckHint').innerText = "";
            document.getElementById('passwordCheck_Hint').style.visibility = "hidden";
            document.getElementById('passwordCheckStar').style.visibility = "hidden";
            result = this.isReCheckPassValid(pass, checkPass);
        }

        return result;
    }

    function checkForm() {
        let form = document.getElementById('register_form');
        let checkUsername = this.checkUsername(form.username.value);
        let checkEMail = this.checkEMail(form.email.value);
        let checkPass = this.checkPass(form.password.value);
        let reCheckPass = this.reCheckPass(form.password.value, form.check_pass.value);
        return (checkUsername && checkEMail && checkPass && reCheckPass);
    }

    function onSubmit() {
        if(checkForm()){
            document.getElementById('register_form').submit();
        }
    }
</script>
</html>