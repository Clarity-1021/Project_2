<?php
require_once('./php/config.php');
session_start();
$mycenterflag = 'none';
$loginflag = 'block';

if(isset($_SESSION['UserName'])){
    $mycenterflag = 'block';
    $loginflag = 'none';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/Style.css" />
    <link rel="stylesheet" href="css/Search.css" />
    <script src="js/jQuery.min.js"></script>
    <base target="_self" />
    <title>搜索页</title>
</head>

<body>
    <nav class="shadowed" name="top">
        <div class="container">
            <div class="my-container-nav">
                <div class="left-nav">
                    <div class="logo"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <a class="highlight_off" href="../index.php">首页</a>
                    <a class="highlight_off" href="Browser.php">浏览页</a>
                    <a class="highlight_on" href="Search.php">搜索页</a>
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
            <form id="filter_form" name="filter_form" action="">
                <div class="my-row title-box text-intent-default">筛选条件</div>

                <div class="filter-box">
                    <input checked type="radio" id="mode_title" name="filter_mode" />标题筛选<br />
                    <input type="text" id="title_txt" name="title" /><br />
                    <input type="radio" id="mode_description" name="filter_mode" />描述筛选<br />
                    <textarea rows="6" id="description_txt" name="description" class="my-description-txt"></textarea>
                    <div id="filter_btn" class="my-btn">筛选</div>
                </div>
            </form>

            <script>
                $(function(){
                    $("#filter_btn").click(function () {
                        alert('筛选成功');
                        document:filter_form.submit();
                    });
                });
            </script>
        </div>

        <div class="my-box">
            <div class="my-row title-box text-intent-default">搜索结果</div>

            <div class="my-photo-box">
                <div class="my-img-box"><a href="Detail.php"><img src="../img/normal/medium/6114904363.jpg" alt="搜索结果图片" /></a></div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>
                </div>
            </div>

            <div class="my-photo-box">
                <div class="my-img-box"><a href="Detail.php"><img src="../img/normal/medium/9494470337.jpg" alt="搜索结果图片" /></a></div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>
                </div>
            </div>

            <div class="my-photo-box">
                <div class="my-img-box"><a href="Detail.php"><img src="../img/normal/medium/8152045872.jpg" alt="搜索结果图片" /></a></div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>
                </div>
            </div>

            <div class="my-photo-box">
                <div class="my-img-box"><a href="Detail.php"><img src="../img/normal/medium/9493997865.jpg" alt="搜索结果图片" /></a></div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
                    </div>
                </div>
            </div>

            <div class="my-photo-box">
                <div class="my-img-box"><a href="Detail.php"><img src="../img/normal/medium/5857398054.jpg" alt="搜索结果图片" /></a></div>

                <div class="my-description-box">
                    <div class="my-txt-box">
                        <h3>Lorem ipsum dolor.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus corporis debitis dolorem earum incidunt laboriosam minus recusandae sapiente tempora ullam! Cum eos fuga natus, necessitatibus repudiandae sapiente sunt temporibus ullam?</p>
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