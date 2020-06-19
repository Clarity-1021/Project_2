<?php
session_start();

if(isset($_SESSION['UID'])){
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/Style.css" />
    <link rel="stylesheet" href="css/Login.css" />
    <script src="js/jQuery.min.js"></script>
    <base target="_self" />
    <title>登录</title>
</head>

<body>
    <h1 class="log-title" data-spotlight="Login!">Login</h1>

    <div class="log-box-outer">
        <div class="log-container">
            <div class="left-container">
                <div class="title"><span class="underline-yellow">登录</span></div>

                <form name="login_form" id="login_form">
                    <div class="input-container">
                        <input type="text" id="username" name="username" placeholder="用户名" />
                        <input type="password" id="password" name="password" placeholder="密码" />
                    </div>

                    <div id="hint_message" class="hint-message" style="visibility: hidden"><i class="fa fa-info-circle" aria-hidden="true"></i> <span id="hint"></span></div>

                    <div class="last-row">
                        <div class="message"><a onclick="alert('再想想！')">忘记密码</a></div>

                        <div id="login_btn" class="login-btn" onclick="onSubmit();">登录</div>
                    </div>
                </form>
            </div>

            <div class="right-container">
                <div class="title reg"><span class="underline-yellow">注册</span></div>

                <div class="message reg-hint">
                    <a href="Register.php">没有账号，去注册</a>
                </div>
            </div>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>

<script>
    function checkEmpty() {
        let form = document.getElementById('login_form');

        if(form.username.value === ""){
            document.getElementById('hint').innerText = "请输入用户名";
            document.getElementById('hint_message').style.visibility = "visible";
            return ;
        }
        if (form.password.value === "") {
            document.getElementById('hint').innerText = "请输入密码";
            document.getElementById('hint_message').style.visibility = "visible";
            return ;
        }
        document.getElementById('hint').innerText = "";
        document.getElementById('hint_message').style.visibility = "hidden";
    }

    function checkPass(username, password) {
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
                    window.location.href = "../index.php";
                }
                else if (isValid === "false") {
                    document.getElementById('hint').innerText = "用户名或密码输入错误";
                    document.getElementById('hint_message').style.visibility = "visible";
                }
            }
        };
        let url = "./php/checkPass.php?username=" + username + "&password=" + password;
        url += "&sid=" + Math.random();
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function onSubmit() {
        let form = document.getElementById('login_form');
        checkEmpty();
        checkPass(form.username.value, form.password.value);
    }

</script>
</html>