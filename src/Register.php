<?php
require_once('./php/config.php');
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

            <?php

            function test_input($data) {
                $data = trim($data);//去前后空格
                $data = stripslashes($data);//删除输入的反斜杠
                $data = htmlspecialchars($data);//把符号转为HTML实体
                return $data;
            }

            $usernameHint = $emailHint = $passwordHint = $check_passHint = 'hidden';
            $usernameErr = $emailErr = $passwordErr = $check_passErr = "";
            $username = $email = $password = $check_pass = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["username"])) {
                    $usernameErr = "请输入用户名";
                    $usernameHint = 'visible';
                }
                else {
                    $username = test_input($_POST["username"]);
                    // 用户名只包含字母、数字和下划线
                    if (!preg_match("/^[a-zA-Z0-9._]*$/", $username)) {
                        $usernameErr = "用户名只包含字母、数字、_和.";
                        $usernameHint = 'visible';
                    }
                    else {
                        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                        $sql = "SELECT * FROM traveluser WHERE UserName=:user";
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(':user',$username);
                        $statement->execute();

                        //检查用户名是否已存在
                        if($statement->rowCount()>0){
                            $usernameErr = "用户名已存在";
                            $usernameHint = 'visible';
                        }
                        else{
                            $usernameErr = "";
                            $usernameHint = 'hidden';
                        }
                    }
                }

                if (empty($_POST["email"])) {
                    $emailErr = "请输入邮箱";
                    $emailHint = 'visible';
                }
                else {
                    $email = test_input($_POST["email"]);
                    // 检查邮箱格式
//                    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
                    if (!preg_match("/^([\w-])+@([a-z0-9])+((\.[a-z]{2,3}){1,2})$/",$email)) {
                        $emailErr = "请输入合法的邮箱";
                        $emailHint = 'visible';
                    }
                    else {
                        $emailErr = "";
                        $emailHint = 'hidden';
                    }
                }

                if (empty($_POST["password"])) {
                    $passwordErr = "请输入密码";
                    $passwordHint = 'visible';
                }
                else {
                    $password = test_input($_POST["password"]);
                    // 检查密码至少包含一个字母数字和特殊符号
                    if (!preg_match("/^(?![a-zA-z]+$)(?!\d+$)(?![!@#$%^&*]+$)[a-zA-Z\d!@#$%^&*]+$/", $password)) {
                        $passwordErr = "弱密码，至少包含一个字母数字和特殊符号";
                        $passwordHint = 'visible';
                    }
                    else {
                        $passwordErr = "";
                        $passwordHint = 'hidden';
                    }
                }

                if (empty($_POST["check_pass"])) {
                    $check_passErr = "请再次输入密码";
                    $check_passHint = 'visible';
                }
                else {
                    $check_pass = test_input($_POST["check_pass"]);
                    if($password !== $check_pass){
                        $check_passErr = "输入的密码与第一次不同";
                        $check_passHint = 'visible';
                    }
                    else {
                        $check_passErr = "";
                        $check_passHint = 'hidden';
                    }
                }

                if($usernameErr === "" && $emailErr === "" && $passwordErr === "" && $check_passErr === ""){
                    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                    $sql = "INSERT INTO traveluser (Email, UserName, Pass) VALUES (:email, :user, :pass)";
                    $statement = $pdo->prepare($sql);
                    $statement->bindValue(':user',$username);
                    $statement->bindValue(':email',$email);
                    $statement->bindValue(':pass',$password);
                    $statement->execute();
                    header("Location: ./Login.php");
                }
            }
            ?>

            <form id="register_form" name="register_form" action="" method="post">
                <div class="input-container">
                    <div class="inputBox">
                        <div style="padding: 0 5px; color: #f6e58d">*</div>
                        <input type="text" name="username" placeholder="用户名" value="<?php echo $username;?>" />
                    </div>
                    <div class="hint-message" style="visibility: <?php echo $usernameHint;?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $usernameErr;?></div>

                    <div class="inputBox">
                        <div style="padding: 0 5px; color: #f6e58d">*</div>
                        <input type="email" name="email" placeholder="邮箱" value="<?php echo $email;?>" />
                    </div>
                    <div class="hint-message" style="visibility: <?php echo $emailHint;?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $emailErr;?></div>

                    <div class="inputBox">
                        <div style="padding: 0 5px; color: #f6e58d">*</div>
                        <input type="password" name="password" placeholder="密码" value="<?php echo $password;?>" />
                    </div>
                    <div class="hint-message" style="visibility: <?php echo $passwordHint;?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $passwordErr;?></div>

                    <div class="inputBox">
                        <div style="padding: 0 5px; color: #f6e58d">*</div>
                        <input type="password" name="check_pass" placeholder="确认密码" value="<?php echo $check_pass;?>"  />
                    </div>
                    <div class="hint-message" style="visibility: <?php echo $check_passHint;?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $check_passErr;?></div>
                </div>

                <div class="last-row">
                    <div class="message"><a href="Login.php">已注册，去登录</a></div>

                    <div id="register_btn" class="reg-btn">注册</div>
                </div>
            </form>

            <script>
                $(function(){
                    $("#register_btn").click(function () {
                        document:register_form.submit();
                    });
                });
            </script>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>

</body>
</html>