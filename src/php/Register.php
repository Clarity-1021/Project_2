<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/Style.css" />
    <link rel="stylesheet" href="../css/Register.css" />
    <script src="../js/jQuery.min.js"></script>
    <base target="_self" />
    <title>注册</title>
</head>

<body>
    <h1 class="reg-title">Register</h1>

    <div class="reg-box-outer">
        <div class="reg-container">
            <div class="title"><span class="underline-yellow">注册</span></div>

            <form id="register_form" name="register_form" action="../../index.php">
                <div class="input-container">
                    <input type="text" name="username" placeholder="用户名" />
                    <input type="email" name="email" placeholder="邮箱" />
                    <input type="password" name="password" placeholder="密码" />
                    <input type="password" name="check-pass" placeholder="确认密码" />
                </div>

                <div class="last-row">
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