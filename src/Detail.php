<?php
require_once('./php/config.php');

session_start();

$mycenterflag = 'none';
$loginflag = 'block';

if(!isset($_SESSION['UID'])){
    echo "<script>alert('请登录后再访问此页面');history.go(-1);</script>";
}
else{
    $mycenterflag = 'block';
    $loginflag = 'none';
}

//用UID找作者的用户名
function queryAuthor($UID){
    $result = '无';

    if($UID !== NULL){
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM traveluser WHERE UID=:uid";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':uid',$UID);
        $statement->execute();

        if($statement->rowCount()>0) {
            $row = $statement->fetch();
            $result = $row['UserName'];
        }
    }

    return $result;
}

//用ImageID查询总收藏次数
function queryFavorNum($ImageID){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM travelimagefavor WHERE ImageID=:imgid";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':imgid',$ImageID);
    $statement->execute();

    return $statement->rowCount();
}

//用CountryCodeISO查询国家
function queryCountry($ISO){
    $result = '无';

    if($ISO !== NULL){
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM geocountries WHERE ISO=:iso";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':iso',$ISO);
        $statement->execute();

        if($statement->rowCount()>0) {
            $row = $statement->fetch();
            $result = $row['CountryName'];
        }
    }

    return $result;
}

//用GeoNameID查询城市
function queryCity($GeoNameID){
    $result = '无';

    if($GeoNameID !== NULL){
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM geocities WHERE GeoNameID=:gnid";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':gnid',$GeoNameID);
        $statement->execute();

        if($statement->rowCount()>0) {
            $row = $statement->fetch();
            $result = $row['AsciiName'];
        }
    }

    return $result;
}

//用ImageID和UID查询是否我收藏过
function queryIsFavor($ImageID, $UID){
    $result = false;

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM travelimagefavor WHERE ImageID=:imgid and UID=:uid";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':imgid',$ImageID);
    $statement->bindValue(':uid',$UID);
    $statement->execute();

    if($statement->rowCount()>0) {
        $result = true;
    }
    return $result;
}

$ImageID = $_GET['ImageID'];

//用ImageID找这个图片
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM travelimage WHERE ImageID=:imgid";
$statement = $pdo->prepare($sql);
$statement->bindValue(':imgid',$ImageID);
$statement->execute();

if($statement->rowCount()>0) {
    $row = $statement->fetch();
}
else{
    echo "<script>alert('没有此图片');history.go(-1);</script>";
}

//获取标题
$title = ($row['Title'] === NULL) ? '无' : $row['Title'];
//获取作者
$auther = queryAuthor($row['UID']);
//获取收藏次数
$favorNum = queryFavorNum($row['ImageID']);
//获取主题
$theme = ($row['Content'] === NULL) ? '无' : $row['Content'];
//获取国家
$country = queryCountry($row['CountryCodeISO']);
//获取城市
$city = queryCity($row['CityCode']);
//获取描述
$description = ($row['Description'] === NULL) ? '无' : $row['Description'];
//获取图片PATH
$path = '../img/travel-images/medium/' . $row['PATH'];
//获取UID
$uid = $_SESSION['UID'];
//获取我是否收藏过这个图片
$isFavor = queryIsFavor($row['ImageID'], $uid);

$likeBtnStyle = $isFavor ? 'isFavor' : 'notFavor';
$notText = $isFavor ? '已' : '未';
$favorTitle = $isFavor ? '点击取消收藏' : '点击加入收藏';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($isFavor){// 已收藏->取消收藏
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM travelimagefavor WHERE ImageID=:imgid and UID=:uid";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':imgid',$ImageID);
        $statement->bindValue(':uid',$uid);
        $statement->execute();
    }
    else{// 未收藏->加入收藏
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO travelimagefavor (UID, ImageID) VALUES (:uid, :imgid)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':imgid',$ImageID);
        $statement->bindValue(':uid',$uid);
        $statement->execute();
    }

    $favorNum = queryFavorNum($row['ImageID']);
    $isFavor = queryIsFavor($row['ImageID'], $uid);
    $likeBtnStyle = $isFavor ? 'isFavor' : 'notFavor';
    $notText = $isFavor ? '已' : '未';
    $favorTitle = $isFavor ? '点击取消收藏' : '点击加入收藏';
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
                <div class="img-name"><?php echo $title;?></div>
                <div class="img-author"><?php echo $auther;?></div>
            </div>

            <div class="container">
                <div class="left-box">
                    <img src="<?php echo $path;?>" alt="<?php echo $title;?>" />
                </div>

                <div class="right-box">
                    <div class="like-box green-thin-border">
                        <div class="my-row title-box text-intent-default">收藏次数</div>
                        <div class="my-row-last"><?php echo $favorNum;?></div>
                    </div>

                    <div class="detail-box green-thin-border">
                        <div class="my-row title-box text-intent-default">图片描述</div>
                        <div class="my-row text-intent-default">主题：<?php echo $theme;?></div>
                        <div class="my-row text-intent-default">拍摄国家：<?php echo $country;?></div>
                        <div class="my-row text-intent-default">拍摄城市：<?php echo $city;?></div>
                    </div>

                    <form id="handleFavor_form" name="handleFavor_form" action="" method="post">
                        <div title="<?php echo $favorTitle;?>" class="like-btn <?php echo $likeBtnStyle;?>" onclick="handleFavor()">
                            <i class="fa fa-star heart-icon"></i>
                            <span class="heart-txt"><?php echo $notText;?>收藏</span>
                        </div>
                    </form>

                    <script>
                        function handleFavor() {
                            document.getElementById('handleFavor_form').submit();
                        }
                    </script>
                </div>
            </div>

            <div class="description-box"><?php echo $description;?></div>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>
</html>