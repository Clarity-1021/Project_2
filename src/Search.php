<?php
require_once('./php/config.php');
session_start();
$mycenterflag = 'none';
$loginflag = 'block';

if(isset($_SESSION['UID'])){
    $mycenterflag = 'block';
    $loginflag = 'none';
}

//模糊搜索图片标题
function queryOne($column, $value){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM travelimage WHERE ' . $column . ' LIKE :val';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':val',$value);
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
function outputSingleImg($row){
    $imgTitle = ($row['Title'] === NULL) ? '无' : $row['Title'];
    $imgDescription = ($row['Description'] === NULL) ? '无' : $row['Description'];

    echo '<div class="my-photo-box">';
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
    echo '</div>';
    echo '</div>';
}

//通过标题或描述模糊搜索输出所有图片
function outputImages($page, $pageSize, $column, $value){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM travelimage WHERE '. $column .' LIKE :val LIMIT '. $page .', ' . $pageSize;
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':val',$value);
    $statement->execute();

    //输出照片
    while ($row = $statement->fetch()){
        outputSingleImg($row);
    }
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
            <form id="filter_form" name="filter_form" action="" method="get">
                <div class="my-row title-box text-intent-default">筛选条件</div>

                <div class="filter-box">
                    <input checked type="radio" id="mode_title" name="filter_mode" value="title" onchange="inputDisabled()" />标题筛选<br />
                    <input type="text" id="title_txt" name="title"/><br />

                    <input type="radio" id="mode_description" name="filter_mode" value="description" onchange="inputDisabled()" />描述筛选<br />
                    <textarea rows="6" id="description_txt" name="description" class="my-description-txt"></textarea>

                    <div id="filter_btn" class="my-btn" onclick="onSubmit();">筛选</div>
                    <script>
                        inputDisabled();

                        function onSubmit() {
                            document.getElementById('filter_form').submit();
                        }

                        function inputDisabled() {
                            let model = document.getElementById('filter_form').filter_mode.value;
                            console.log(model);
                            if(model === 'title'){
                                document.getElementById('description_txt').disabled = true;
                                document.getElementById('title_txt').disabled = false;
                            }
                            else {
                                document.getElementById('description_txt').disabled = false;
                                document.getElementById('title_txt').disabled = true;
                            }
                        }
                    </script>
                </div>
            </form>
        </div>

        <div class="my-box">
            <div class="my-row title-box text-intent-default">搜索结果</div>
            <?php

            $pageSize = 4;//每页展示图片个数
            $queryResult = -1;//查询结果

            if(isset($_GET['filter_mode'])){
                if($_GET['filter_mode'] === "title" && isset($_GET['title']) && $_GET['title'] !== ""){
                    $title = trim($_GET['title']);//去前后空格
                    $title = '%' . $title . '%';
                    $queryResult = queryOne('Title', $title);
                }
                elseif ($_GET['filter_mode'] === "description" && isset($_GET['description']) && $_GET['description'] !== ""){
                    $description = trim($_GET['description']);//去前后空格
                    $description = '%' . $description . '%';
                    $queryResult = queryOne('Description', $description);
                }
            }

            if($queryResult !== -1){
                $pageNum = getPageNum($queryResult, $pageSize);//总页数

                if($pageNum == 0){
                    echo '<div class="my-photo-box">';
                    echo '<div style="text-align: center; width: 100%; color: gray">无结果</div>';
                    echo '</div>';
                }
                else{
                    $pageVal = 1;//当前页
                    if (isset($_GET['page']) && ($_GET['page'] > 1) && ($_GET['page'] < 6)) {
                        $pageVal = $_GET['page'];
                    }
                    $page = ($pageVal - 1) * $pageSize;
                    $originQuery = '';

                    if(isset($_GET['filter_mode'])){
                        if($_GET['filter_mode'] === "title"){
                            outputImages($page, $pageSize, 'Title', $title);
                            $originQuery = '?filter_mode=title&title=' . $_GET['title'];
                        }
                        elseif ($_GET['filter_mode'] === "description"){
                            outputImages($page, $pageSize, 'Description', $description);
                            $originQuery = '?filter_mode=description&description=' . $_GET['description'];
                        }

                        $prePage = $pageVal - 1;
                        $nextPage = $pageVal + 1;

                        //输出页码
                        echo '<div class="my-page-number">';
                        if ($pageVal !== 1){
                            echo '<a href="./Search.php' . $originQuery . '&page=' . $prePage . '"><i class="fa fa-angle-double-left"></i></a>';
                        }
                        for($i = 1; $i <= $pageNum; $i++){
                            echo '<a';
                            if ($i == $pageVal){
                                echo ' style="color: black"';
                            }
                            echo ' href="./Search.php' . $originQuery . '&page=' . $i . '">' . $i . '</a>';
                        }
                        if($pageVal != $pageNum){
                            echo '<a href="./Search.php' . $originQuery . '&page=' . $nextPage . '"><i class="fa fa-angle-double-right"></i></a>';
                        }
                        echo '</div>';
                    }
                }
            }
            else{
                echo '<div class="my-photo-box">';
                echo '<div style="text-align: center; width: 100%; color: gray">未搜索</div>';
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