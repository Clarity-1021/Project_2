<?php
require_once('./php/config.php');

session_start();

$mycenterflag = 'none';
$loginflag = 'block';

if(!isset($_SESSION['UserName'])){
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
    <link rel="stylesheet" href="css/Detail.css" />
    <base target="_self" />
    <title>图片详情</title>
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
        <div class="my-box shadowed">
            <div class="my-row title-box text-intent-default">图片详情</div>

            <div class="name-box">
                <div class="img-name">Lorem ipsum dolor.</div>
                <div class="img-author">by Lorem ipsum.</div>
            </div>

            <div class="container">
                <div class="left-box">
                    <img src="../img/normal/medium/6114904363.jpg" alt="图片" />
                </div>

                <div class="right-box">
                    <div class="like-box green-thin-border">
                        <div class="my-row title-box text-intent-default">收藏次数</div>
                        <div class="my-row-last">99</div>
                    </div>

                    <div class="detail-box green-thin-border">
                        <div class="my-row title-box text-intent-default">图片描述</div>
                        <div class="my-row text-intent-default">主题：风景</div>
                        <div class="my-row text-intent-default">拍摄国家：中国</div>
                        <div class="my-row text-intent-default">拍摄城市：上海</div>
                    </div>

                    <a class="like-btn" href="" onclick="alert('收藏成功')">
                        <i class="fa fa-star heart-icon"></i>
                        <span class="heart-txt">收藏</span>
                    </a>
                </div>
            </div>

            <div class="description-box">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi architecto asperiores at, blanditiis distinctio eius, enim hic, incidunt ipsa iure laboriosam laudantium maxime nostrum praesentium quisquam rerum voluptates voluptatibus.
            </div>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>
</html>