<?php
require_once('./src/php/config.php');
session_start();
$mycenterflag = 'none';
$loginflag = 'block';

if(isset($_SESSION['UID'])){
    $mycenterflag = 'block';
    $loginflag = 'none';
}

//查找热门图片的id
function outputHotImages() {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT ImageID,count(*) as sum FROM travelimagefavor group by ImageID ORDER by sum DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    $imageNum = $statement->rowCount();
    $imageNum = ($imageNum < 6) ? $imageNum : 6;

    while ($row = $statement->fetch()) {
        if ($row['ImageID'] !== NULL) {
            findHotImage($row['ImageID']);
        }
        $imageNum--;
        if ($imageNum === 0) {
            break;
        }
    }
}

//通过图片id查找图片的信息
function findHotImage($imageID) {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM travelimage WHERE ImageID=:imgid";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':imgid',$imageID);
    $statement->execute();

    if($statement->rowCount()>0) {
        $row = $statement->fetch();
        outputSingleImage($row);
    }
}

//随机选取6个图片
function outputRandomImages() {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM travelimage WHERE ImageID >= (SELECT floor(RAND() * (SELECT MAX(ImageID) FROM travelimage))) ORDER BY ImageID LIMIT 6;";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    $imageNum = ($statement->rowCount() < 6) ? ($statement->rowCount()) : 6;

    while ($row = $statement->fetch()) {
        if ($imageNum === 0) {
            break;
        }
        $imageNum--;
        outputSingleImage($row);
    }
}

//展示图片
function outputSingleImage($row) {
    $title = ($row['Title'] === NULL) ? '无' : $row['Title'];
    $description = ($row['Description'] === NULL) ? '无' : $row['Description'];

    echo '<div class="photo-box shadowed">';
    echo '<a href="./src/Detail.php?ImageID=' . $row['ImageID'] . '">';
    echo '<img src="./img/travel-images/medium/' . $row['PATH'] . '" class="shadowed-lg" alt="' . $title . '" />';
    echo '</a>';
    echo '<h4>' . $title . '</h4>';
    echo '<div class="description">' . $description . '</div>';
    echo '</div>';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="src/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="src/css/Style.css" />
    <link rel="stylesheet" href="src/css/index.css" />
    <base target="_self" />
    <title>首页</title>
</head>

<body>
    <nav class="shadowed" name="top">
        <div class="container">
            <div class="my-container-nav">
                <div class="left-nav">
                    <div class="logo"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <a class="highlight_on" href="./index.php">首页</a>
                    <a class="highlight_off" href="./src/Browser.php">浏览页</a>
                    <a class="highlight_off" href="./src/Search.php">搜索页</a>
                </div>

                <div class="right-nav" style="display: <?php echo $mycenterflag;?>">
                    <a class="dropdown-nav">&nbsp;个人中心&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                    <div class="dropdown-content-nav shadowed">
                        <a href="./src/Upload.php"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;上传</a>
                        <a href="./src/MyPhoto.php"><i class="fa fa-image"></i>&nbsp;&nbsp;我的照片</a>
                        <a href="./src/Favor.php"><i class="fa fa-star"></i>&nbsp;&nbsp;我的收藏</a>
                        <a href="src/php/logout.php"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;登出</a>
                    </div>
                </div>

                <div class="right-nav" style="display: <?php echo $loginflag;?>">
                    <a class="highlight_off" href="./src/Login.php"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;登录</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="my-container">
        <img src="img/normal/medium/9496560520.jpg" class="shadowed" alt="头图" width="100%" />

        <div class="photo-box-outer" id="displayImgs">
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                outputRandomImages();
            }
            else{
                outputHotImages();
            }
            ?>
        </div>
    </div>

    <footer class="shadowed">
        <div class="my-container-footer">
            <div class="footer-box-left">
                <div class="detail">使用条款</div>
                <div class="detail">关于</div>
                <div class="detail">隐私保护</div>
                <div class="detail">联系我们</div>
                <div class="detail">Cookie</div>
            </div>

            <div class="footer-box-right">
                <div class="inner-box-left">
                    <div class="small-icon"><i class="fa fa-weibo"></i></div>
                    <div class="small-icon"><i class="fa fa-instagram"></i></div>
                    <div class="small-icon"><i class="fa fa-envelope-o"></i></div>
                    <div class="small-icon"><i class="fa fa-qrcode"></i></div>
                </div>
                <div class="inner-box-right">
                    <img src="img/WeChat.JPG" alt="微信二维码" width="100%" />
                </div>
            </div>

            <div class="my-footer">
                <br />
                <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
            </div>
        </div>
    </footer>

    <div class="bottom-box">
        <a class="assist-icon" href="#top">
            <i class="fa fa-chevron-up"></i>
        </a>

        <form id="randomIMG_form" name="randomIMG_form" action="" method="post">
            <div class="assist-icon" id="refresh_btn" onclick="onRefresh();">
                <i class="fa fa-refresh"></i>
            </div>
        </form>

        <script>
            function onRefresh(){
                document.getElementById('randomIMG_form').submit();
            }
        </script>

    </div>

</body>
</html>