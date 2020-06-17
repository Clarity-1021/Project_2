<?php
require_once('./php/config.php');

session_start();

$mycenterflag = 'none';
$loginflag = 'block';

if(!isset($_SESSION['UID'])){
    echo"<script>alert('请登录后再访问此页面');history.go(-1);</script>";
}
else{
    $mycenterflag = 'block';
    $loginflag = 'none';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/Style.css" />
    <base target="_self" />
    <title>我的收藏</title>
</head>

<body>
    <nav class="shadowed" name="top">
        <div class="container">
            <div class="my-container-nav">
                <div class="left-nav">
                    <div class="logo"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <a class="highlight_off" href="../index.php">首页</a>
                    <a class="highlight_off" href="./Browser.php">浏览页</a>
                    <a class="highlight_off" href="Search.php">搜索页</a>
                </div>


                <div class="right-nav" style="display: <?php echo $mycenterflag;?>">
                    <a class="dropdown-nav">&nbsp;个人中心&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                    <div class="dropdown-content-nav shadowed">
                        <a href="Upload.php"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;上传</a>
                        <a href="MyPhoto.php"><i class="fa fa-image"></i>&nbsp;&nbsp;我的照片</a>
                        <a href="Favor.php"><i class="fa fa-star"></i>&nbsp;&nbsp;我的收藏</a>
                        <a href="php/logout.php"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;登出</a>
                    </div>
                </div>

                <div class="right-nav" style="display: <?php echo $loginflag;?>">
                    <a class="highlight_off" href="Login.php"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;登录</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="my-container">
        <div class="my-box green-thin-border">
            <div class="my-row title-box text-intent-default">我的收藏</div>

            <div class="my-photo-box">
                <div class="my-img-box">
                    <a href="Detail.php">
                        <img src="../img/normal/medium/9494282329.jpg" alt="收藏图片" />
                    </a>
                </div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>

                    <div class="my-btn-box">
                        <div class="delete-btn" name="delete_btn_1" onclick="alert('删除成功')">删除</div>
                    </div>
                </div>
            </div>

            <div class="my-photo-box">
                <div class="my-img-box">
                    <a href="Detail.php">
                        <img src="../img/normal/medium/8152048712.jpg" alt="收藏图片" />
                    </a>
                </div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>

                    <div class="my-btn-box">
                        <div class="delete-btn" name="delete_btn_1" onclick="alert('删除成功')">删除</div>
                    </div>
                </div>
            </div>

            <div class="my-photo-box">
                <div class="my-img-box">
                    <a href="Detail.php">
                        <img src="../img/normal/medium/6592914823.jpg" alt="收藏图片" />
                    </a>
                </div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>

                    <div class="my-btn-box">
                        <div class="delete-btn" name="delete_btn_1" onclick="alert('删除成功')">删除</div>
                    </div>
                </div>
            </div>

            <div class="my-photo-box">
                <div class="my-img-box">
                    <a href="Detail.php">
                        <img src="../img/normal/medium/8710289254.jpg" alt="收藏图片" />
                    </a>
                </div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>

                    <div class="my-btn-box">
                        <div class="delete-btn" name="delete_btn_1" onclick="alert('删除成功')">删除</div>
                    </div>
                </div>
            </div>

            <div class="my-page-number">
                <a href=""><i class="fa fa-angle-double-left"></i></a>
                <a href="">1</a>
                <a href="">2</a>
                <a href="">3</a>
                <a href="">4</a>
                <a href="">5</a>
                <a href=""><i class="fa fa-angle-double-right"></i></a>
            </div>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>

</html>

