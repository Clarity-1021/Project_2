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

if(isset($_GET['ImageID'])){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'DELETE FROM travelimagefavor WHERE ImageID=:imgid and UID=' . $_SESSION['UID'];
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':imgid',$_GET['ImageID']);
    $statement->execute();
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

            <?php

            //通过UID搜索我收藏过的图片
            function queryMyFavors($UID){
                $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM `travelimagefavor` WHERE UID=:uid";
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':uid',$UID);
                $statement->execute();

                return $statement;
            }

            //通过查找出的总图片个数获得总页数
            function getPageNum($statement, $pageSize){
                $result = 0;

                if($statement->rowCount()>0) {
                    $imgNum = $statement->rowCount();
                    $result = ceil($imgNum / $pageSize);
                    $result = ($result < 5) ? $result : 5;
                }

                return $result;
            }

            //输出单个图片
            function outputSingleImg($ImageID){
                $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT * FROM travelimage WHERE ImageID=:imgid';
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':imgid',$ImageID);
                $statement->execute();

                if($statement->rowCount() > 0){
                    $row = $statement->fetch();
                    $imgTitle = ($row['Title'] === NULL) ? '无' : $row['Title'];
                    $imgDescription = ($row['Description'] === NULL) ? '无' : $row['Description'];

                    echo '<div class="my-photo-box shadowed">';
                    echo '<div class="my-img-box">';
                    echo '<a href="./Detail.php?ImageID=' . $row['ImageID'] . '">';
                    echo '<img src="../img/travel-images/medium/' . $row['PATH'] . '" alt="' . $imgTitle . '" />';
                    echo '</a>';
                    echo '</div>';
                    echo '<div class="my-description-box">';
                    echo '<div class="my-txt-box">';
                    echo '<h3>' . $imgTitle . '</h3>';
                    echo '<p>' . $imgDescription . '</p>';
                    echo '</div>';
                    echo '<div class="my-btn-box">';
                    echo '<a class="delete-btn" name="delete_btn_1" href="./Favor.php?ImageID=' . $row['ImageID'] . '">删除</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            //通过UID搜索输出所有图片
            function outputImages($page, $pageSize, $UID){
                $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT * FROM `travelimagefavor` WHERE UID=:uid LIMIT '. $page .', ' . $pageSize;
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':uid',$UID);
                $statement->execute();

                //输出照片
                while ($row = $statement->fetch()){
                    outputSingleImg($row['ImageID']);
                }
            }

            $pageSize = 4;//每页展示图片个数
            $uid = $_SESSION['UID'];
            $queryResult = queryMyFavors($uid);

            $pageNum = getPageNum($queryResult, $pageSize);//总页数

            if($pageNum == 0){
                echo '<div class="my-photo-box">';
                echo '<div style="text-align: center; width: 100%; color: gray">无图片</div>';
                echo '</div>';
            }
            else{
                $pageVal = 1;//当前页
                if (isset($_GET['page']) && ($_GET['page'] > 1) && ($_GET['page'] < 6)) {
                    $pageVal = $_GET['page'];
                }
                $page = ($pageVal - 1) * $pageSize;

                outputImages($page, $pageSize, $uid);

                $prePage = $pageVal - 1;
                $nextPage = $pageVal + 1;

                //输出页码
                echo '<div class="my-page-number">';
                if ($pageVal !== 1){
                    echo '<a href="./Favor.php?page=' . $prePage . '"><i class="fa fa-angle-double-left"></i></a>';
                }
                for($i = 1; $i <= $pageNum; $i++){
                    echo '<a';
                    if ($i == $pageVal){
                        echo ' style="color: black"';
                    }
                    echo ' href="./Favor.php?page=' . $i . '">' . $i . '</a>';
                }
                if($pageVal != $pageNum){
                    echo '<a href="./Favor.php?page=' . $nextPage . '"><i class="fa fa-angle-double-right"></i></a>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>

</html>

