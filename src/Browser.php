<?php
require_once('./php/config.php');
session_start();
$mycenterflag = 'none';
$loginflag = 'block';

if(isset($_SESSION['UserName'])){
    $mycenterflag = 'block';
    $loginflag = 'none';
}
//header('Location: ./Browser.php?title=asd&page=1');

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/Style.css" />
    <link rel="stylesheet" href="css/Browser.css" />
    <script src="js/jQuery.min.js"></script>
    <base target="_self" />
    <title>浏览页</title>
</head>

<body>
    <nav class="shadowed" name="top">
        <div class="container">
            <div class="my-container-nav">
                <div class="left-nav">
                    <div class="logo"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <a class="highlight_off" href="../index.php">首页</a>
                    <a class="highlight_on" href="Browser.php">浏览页</a>
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

    <div class=container>
        <div class="col-left">
            <div class="search-by-title shadowed">
                <div class="search-hint">浏览标题</div>

                <form id="browserTitle_form" name="browserTitle_form" action="./Browser.php" method="get">
                    <div class="search-box">
                        <input type="text" id="search_txt" name="title" class="search-txt" value="" placeholder="输入标题" />
                        <div id="search_btn" class="search-btn" onclick="browserTitle();"><i class="fa fa-search" aria-hidden="true"></i></div>
                    </div>

                    <script>
                        function browserTitle(){
                            document.getElementById('browserTitle_form').submit();
                        }
                    </script>
                </form>

                <script>
                    
                    function browserTheme() {
                        document.getElementById('browserTheme_form').submit();
                    }
                    
                    function browserHotCountry() {
                        document.getElementById('browserHotCountry_form').submit();
                    }
                    
                    function browserHotCity() {
                        document.getElementById('browserHotCity_form').submit();
                    }
                    
                    function filter() {
                        document.getElementById('filter_form').submit();
                    }
                    
                    
                </script>
            </div>

            <div class="hot-content shadowed">
                <div class="my-row title-box text-intent-default">热门主题</div>
                <form id="browserTheme_form" name="browserTheme_form" action="" method="post">
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">海边</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">山林</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">乡村</a></div>
                </form>
            </div>

            <div class="hot-country shadowed">
                <div class="my-row title-box text-intent-default">热门国家</div>
                <form id="browserHotCountry_form" name="browserHotCountry_form" action="" method="post">
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">意大利</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">古巴</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">芬兰</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">纳米比亚</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">那不勒斯</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">比利时</a></div>
                </form>
            </div>

            <div class="hot-city shadowed">
                <div class="my-row title-box text-intent-default">热门城市</div>
                <form id="browserHotCity_form" name="browserHotCity_form" action="" method="post">
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">上海</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">赫尔辛基</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">奥斯陆</a></div>
                    <div class="my-row text-intent-default"><a href="" onclick="alert('浏览成功')">哥本哈根</a></div>
                </form>
            </div>
        </div>

        <div class="col-right">
            <div class="filter">
                <div class="my-row title-box text-intent-default">筛选</div>

                <form name="filter_form" action="" method="">
                    <div class="filter-select-box">

                        <div class="input-select">
                            <select class="input-box rounded" name="theme" id="theme">
                                <option value="0">主题</option>
                                <option value="海边">海边</option>
                                <option value="山林">山林</option>
                                <option value="市内">市内</option>
                                <option value="田间">田间</option>
                            </select>
                        </div>

                        <div class="input-select">
                            <select class="input-box rounded" name="country" onChange="set_city(this, this.form.city);" id="country" >
                                <option value="0">国家</option>
                                <option value="中国">中国</option>
                                <option value="日本">日本</option>
                                <option value="意大利">意大利</option>
                                <option value="美国">美国</option>
                            </select>
                        </div>

                        <div class="input-select">
                            <select class="input-box rounded" name="city" id="city">
                                <option value="0">城市</option>
                            </select>
                        </div>

                        <div class="input-select">
                            <div id="filter_btn" class="my-btn">筛选</div>
                        </div>

                        <script>
                        cities = new Object();
                        cities['中国']=new Array('上海','昆明','北京','烟台');
                        cities['日本']=new Array('东京', '大阪', '镰仓');
                        cities['意大利']=new Array('罗马','米兰','威尼斯','佛罗伦萨');
                        cities['美国']=new Array('纽约','旧金山', '华盛顿');
                        function set_city(country, city)
                        {
                            var pv, cv;
                            var i, ii;

                            pv=country.value;
                            cv=city.value;

                            city.length=1;

                            if(pv=='0') return;
                            if(typeof(cities[pv])=='undefined') return;

                            for(i=0; i<cities[pv].length; i++)
                            {
                                ii = i+1;
                                city.options[ii] = new Option();
                                city.options[ii].text = cities[pv][i];
                                city.options[ii].value = cities[pv][i];
                            }

                        }
                    </script>
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

                <div class="filter-result-box">
                    <?php

                    //通过查找出的总图片个数获得总页数
                    function getPageNum($title, $pageSize){
                        $result = 0;

                        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT * FROM travelimage WHERE Title LIKE :tit";
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(':tit',$title);
                        $statement->execute();

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
                        echo '<div class="photo-box">';
                        echo '<a href="./Detail.php?ImageID=' . $row['ImageID'] . '">';
                        echo '<img src="../img/travel-images/medium/' . $row['PATH'] . '" alt="' . $imgTitle . '" />';
                        echo '</a>';
                        echo '</div>';
                    }

                    //通过标题模糊搜索输出所有图片
                    function outputImagesByTitle($page, $pageSize, $title){
                        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM travelimage WHERE Title LIKE :tit LIMIT '. $page .', ' . $pageSize;
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(':tit',$title);
                        $statement->execute();

                        //输出照片
                        while ($row = $statement->fetch()){
                            outputSingleImg($row);
                        }
                    }

                    if(isset($_GET['title'])){
                        $title = trim($_GET['title']);//去前后空格
                        $title = '%' . $title . '%';

                        $pageSize = 16;//每页展示图片个数
                        $pageNum = getPageNum($title, $pageSize);//总页数

                        if($pageNum == 0){
                            echo '<div style="text-align: center; width: 100%; color: gray">无结果</div>';
                        }
                        else{
                            $pageVal = 1;//当前页
                            if (isset($_GET['page']) && ($_GET['page'] > 1) && ($_GET['page'] < 6)) {
                                $pageVal = $_GET['page'];
                            }
                            $page = ($pageVal - 1) * $pageSize;

                            outputImagesByTitle($page, $pageSize, $title);

                            $prePage = $pageVal - 1;
                            $nextPage = $pageVal + 1;
                            if ($pageVal === 1){
                                $prePage = 1;
                            }
                            if($pageVal == $pageNum){
                                $nextPage = $pageVal;
                            }

                            //输出页码
                            echo '<div class="page-number">';
                            echo '<a class="my-page-num" href="./Browser.php?title=' . $_GET['title'] . '&page=' . $prePage . '"><i class="fa fa-angle-double-left"></i></a>';
                            for($i = 1; $i <= $pageNum; $i++){
                                echo '<a class="my-page-num"';
                                if ($i === $pageVal){
                                    echo ' style="color: black"';
                                }
                                echo ' href="./Browser.php?title=' . $_GET['title'] . '&page=' . $i . '">' . $i . '</a>';
                            }
                            echo '<a class="my-page-num" href="./Browser.php?title=' . $_GET['title'] . '&page=' . $nextPage . '"><i class="fa fa-angle-double-right"></i></a>';
                            echo '</div>';
                        }
                    }


                    ?>

<!--                    <div class="photo-box">-->
<!--                        <a href="Detail.php">-->
<!--                            <img src="../img/travel-images/medium/" alt="筛选结果图片" >-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/222222.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/8152020963.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/8711645510.jpg" alt="筛选结果图片" ></a></div>-->
<!---->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/5855191275.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/5855735700.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/5856654945.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/9493997865.jpg" alt="筛选结果图片" ></a></div>-->
<!---->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/5855209453.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/5855221959.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/9494282329.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/9494464567.jpg" alt="筛选结果图片" ></a></div>-->
<!---->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/5856697109.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/8152045872.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/5857398054.jpg" alt="筛选结果图片" ></a></div>-->
<!--                    <div class="photo-box"><a href="Detail.php"><img src="../img/normal/medium/9494470337.jpg" alt="筛选结果图片" ></a></div>-->

<!--                    <div class="page-number">-->
<!--                        <a class="my-page-num" href=""><i class="fa fa-angle-double-left"></i></a>-->
<!--                        <a class="my-page-num" href="">1</a>-->
<!--                        <a class="my-page-num" style="color: black" href="">2</a>-->
<!--                        <a class="my-page-num" href="">3</a>-->
<!--                        <a class="my-page-num" href="">4</a>-->
<!--                        <a class="my-page-num" href="">5</a>-->
<!--                        <a class="my-page-num" href=""><i class="fa fa-angle-double-right"></i></a>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>
</html>