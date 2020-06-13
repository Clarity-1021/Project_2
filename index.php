<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="src/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="src/css/Style.css" />
    <link rel="stylesheet" href="src/css/index.css" />
    <script src="./src/js/jQuery.min.js"></script>
    <base target="_self" />
    <title>登录</title>
</head>

<body>
    <h1 class="log-title" data-spotlight="Login!">Login</h1>

    <div class="log-box-outer">
        <div class="log-container">
            <div class="left-container">
                <div class="title"><span class="underline-yellow">登录</span></div>

                <form name="login_form" id="login_form" action="src/php/Home.php">
                    <div class="input-container">
                        <input type="text" id="username" name="username" placeholder="用户名" />
                        <input type="password" id="password" name="password" placeholder="密码" />
                    </div>

                    <div class="last-row">
                        <div class="message"><a href="">忘记密码</a></div>

                        <div id="login_btn" class="login-btn">登录</div>
                    </div>
                </form>

                <script>
                    $(function(){
                        $("#login_btn").click(function () {
                            document:login_form.submit();
                        });
                    });
                </script>
            </div>

            <div class="right-container">
                <div class="title reg"><span class="underline-yellow">注册</span></div>

                <div class="message reg-hint">
                    <a href="src/php/Register.php">没有账号，去注册</a>
                </div>
            </div>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>
</html>