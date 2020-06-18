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
function queryTitle($title){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM travelimage WHERE Title LIKE :tit";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':tit',$title);
    $statement->execute();

    return $statement;
}

//主题、国家和城市联合查找
function queryThree($Content, $CountryCodeISO, $CityCode){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM travelimage WHERE Content=:content UNION SELECT * FROM travelimage WHERE CountryCodeISO=:iso UNION SELECT * FROM travelimage WHERE CityCode=:citycode";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':content',$Content);
    $statement->bindValue(':iso',$CountryCodeISO);
    $statement->bindValue(':citycode',$CityCode);
    $statement->execute();

    return $statement;
}

//熱門主題、國家或城市查找
function queryOne($column, $value){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM travelimage WHERE ' . $column . '=:val';
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

//通过主题、国家和城市搜索输出所有图片
function outputImagesByFilter($page, $pageSize, $Content, $CountryCodeISO, $CityCode){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM travelimage WHERE Content=:content UNION SELECT * FROM travelimage WHERE CountryCodeISO=:iso UNION SELECT * FROM travelimage WHERE CityCode=:citycode LIMIT '. $page .', ' . $pageSize;
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':content',$Content);
    $statement->bindValue(':iso',$CountryCodeISO);
    $statement->bindValue(':citycode',$CityCode);
    $statement->execute();

    //输出照片
    while ($row = $statement->fetch()){
        outputSingleImg($row);
    }
}

//通过熱門主题、国家或城市搜索输出所有图片
function outputImagesByHot($page, $pageSize, $column, $value){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM travelimage WHERE '. $column .'=:val LIMIT '. $page .', ' . $pageSize;
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':val',$value);
    $statement->execute();

    //输出照片
    while ($row = $statement->fetch()){
        outputSingleImg($row);
    }
}

//用CountryCodeISO查询国家
function queryCountry($ISO){
    $result = NULL;

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

//输出热门国家
function outputHotCountries($num){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT CountryCodeISO,count(*) as sum FROM travelimage group by CountryCodeISO ORDER by sum DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    $countryNum = $statement->rowCount();
    $countryNum = ($countryNum < $num) ? $countryNum : $num;

    while ($row = $statement->fetch()) {
        $hotCountry = queryCountry($row['CountryCodeISO']);

        if($hotCountry !== NULL){
            echo '<div class="my-row text-intent-default">';
            echo '<a href="./Browser.php?HotCountry=' . $row['CountryCodeISO'] . '">' . $hotCountry . '</a>';
            echo '</div>';
            $countryNum--;
            if ($countryNum === 0) {
                break;
            }
        }
    }
}

//输出热门主题
function outputHotThemes($num){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT Content,count(*) as sum FROM travelimage group by Content ORDER by sum DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    $themeNum = $statement->rowCount();
    $themeNum = ($themeNum < $num) ? $themeNum : $num;

    while ($row = $statement->fetch()) {
        echo '<div class="my-row text-intent-default">';
        echo '<a href="./Browser.php?HotTheme='. $row['Content'] .'">' . $row['Content'] . '</a>';
        echo '</div>';
        $themeNum--;
        if ($themeNum === 0) {
            break;
        }
    }
}

//用GeoNameID查询城市
function queryCity($GeoNameID){
    $result = NULL;

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

//输出热门国家
function outputHotCities($num){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT CityCode,count(*) as sum FROM travelimage group by CityCode ORDER by sum DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    $cityNum = $statement->rowCount();
    $cityNum = ($cityNum < $num) ? $cityNum : $num;

    while ($row = $statement->fetch()) {
        $hotCity = queryCity($row['CityCode']);

        if($hotCity !== NULL){
            echo '<div class="my-row text-intent-default">';
            echo '<a href="./Browser.php?HotCity=' . $row['CityCode'] . '">' . $hotCity . '</a>';
            echo '</div>';
            $cityNum--;
            if ($cityNum === 0) {
                break;
            }
        }
    }
}

//输出所有主题选项
function outputThemeOptions(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM imagetheme ORDER BY Content";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    while ($row = $statement->fetch()){
        echo '<option value="' . $row['Content'] . '">' . $row['Theme'] . '</option>';
    }
}

//输出所有国家选项
function outputCountryOptions(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM geocountries ORDER BY CountryName";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    while ($row = $statement->fetch()){
        echo '<option value="' . $row['ISO'] . '">' . $row['CountryName'] . '</option>';
    }
}
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
            </div>

            <div class="hot-content shadowed">
                <div class="my-row title-box text-intent-default">热门主题</div>
                <?php outputHotThemes(3);?>
            </div>

            <div class="hot-country shadowed">
                <div class="my-row title-box text-intent-default">热门国家</div>
                <?php outputHotCountries(6);?>
            </div>

            <div class="hot-city shadowed">
                <div class="my-row title-box text-intent-default">热门城市</div>
                <?php outputHotCities(4);?>
            </div>
        </div>

        <div class="col-right">
            <div class="filter">
                <div class="my-row title-box text-intent-default">筛选</div>

                <form id="filter_form" name="filter_form" action="" method="get">
                    <div class="filter-select-box">

                        <div class="input-select">
                            <select class="input-box rounded" name="theme" id="theme">
                                <option value="0">主题</option>
                                <?php outputThemeOptions();?>
                            </select>
                        </div>

                        <div class="input-select">
                            <select class="input-box rounded" name="country" onChange="setCities(this.value);" id="country" >
                                <option value="0">国家</option>
                                <?php outputCountryOptions();?>
                            </select>
                        </div>

                        <div class="input-select">
                            <select class="input-box rounded" name="city" id="city">
                                <option value="0">城市</option>
                            </select>
                        </div>

                        <div class="input-select">
                            <div id="filter_btn" class="my-btn" onclick="filter()">筛选</div>
                        </div>
                        <script>
                            function filter() {
                                document.getElementById('filter_form').submit();
                            }

                            function setCities(country){
                                if (country === "0"){
                                    setCityOptions(new Object());
                                }
                                else {
                                    let xmlhttp;
                                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                                        xmlhttp = new XMLHttpRequest();
                                    } else { // code for IE6, IE5
                                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                    }
                                    xmlhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            let cities = JSON.parse(this.responseText);
                                            console.log(cities);
                                            setCityOptions(cities);
                                        }
                                    };
                                    let url = "./php/outputCityOptions.php?country=" + country + "&sid=" + Math.random();
                                    xmlhttp.open("GET", url, true);
                                    xmlhttp.send();
                                }
                            }

                            function setCityOptions(cities) {
                                let citySelect = document.getElementById('filter_form').city;
                                citySelect.length = 1;
                                if (Object.keys(cities).length === 0){
                                    return ;
                                }

                                let optCount = 1;
                                for(let key in cities){
                                    citySelect.options[optCount] = new Option();
                                    citySelect.options[optCount].value = key;
                                    citySelect.options[optCount].text = cities[key];
                                    optCount++;
                                }
                            }
                        </script>
                    </div>
                </form>

                <div class="filter-result-box">
                    <?php
                    $pageSize = 16;//每页展示图片个数
                    $queryResult = -1;//查询结果

                    if(isset($_GET['title']) && $_GET['title'] !== ""){
                        $title = trim($_GET['title']);//去前后空格
                        $title = '%' . $title . '%';
                        $queryResult = queryTitle($title);
                    }
                    else if(isset($_GET['theme']) && isset($_GET['country']) && isset($_GET['city'])){
                        $queryResult = queryThree($_GET['theme'], $_GET['country'], $_GET['city']);
                    }
                    else if(isset($_GET['HotTheme'])){
                        $queryResult = queryOne('Content', $_GET['HotTheme']);
                    }
                    else if(isset($_GET['HotCountry'])){
                        $queryResult = queryOne('CountryCodeISO', $_GET['HotCountry']);
                    }
                    else if(isset($_GET['HotCity'])){
                        $queryResult = queryOne('CityCode', $_GET['HotCity']);
                    }

                    if($queryResult !== -1){
                        $pageNum = getPageNum($queryResult, $pageSize);//总页数

                        if($pageNum == 0){
                            echo '<div style="text-align: center; width: 100%; color: gray">无结果</div>';
                        }
                        else{
                            $pageVal = 1;//当前页
                            if (isset($_GET['page']) && ($_GET['page'] > 1) && ($_GET['page'] < 6)) {
                                $pageVal = $_GET['page'];
                            }
                            $page = ($pageVal - 1) * $pageSize;
                            $originQuery = '';

                            if(isset($_GET['title'])){
                                outputImagesByTitle($page, $pageSize, $title);
                                $originQuery = '?title=' . $_GET['title'];
                            }
                            else if(isset($_GET['theme']) && isset($_GET['country']) && isset($_GET['city'])){
                                outputImagesByFilter($page, $pageSize, $_GET['theme'], $_GET['country'], $_GET['city']);
                                $originQuery = '?theme=' . $_GET['theme'] . '&country=' . $_GET['country'] . '&city=' . $_GET['city'];
                            }
                            else if(isset($_GET['HotTheme'])){
                                outputImagesByHot($page, $pageSize, 'Content', $_GET['HotTheme']);
                                $originQuery = '?HotTheme=' . $_GET['HotTheme'];
                            }
                            else if(isset($_GET['HotCountry'])){
                                outputImagesByHot($page, $pageSize, 'CountryCodeISO', $_GET['HotCountry']);
                                $originQuery = '?HotCountry=' . $_GET['HotCountry'];
                            }
                            else if(isset($_GET['HotCity'])){
                                outputImagesByHot($page, $pageSize, 'CityCode', $_GET['HotCity']);
                                $originQuery = '?HotCity=' . $_GET['HotCity'];
                            }

                            $prePage = $pageVal - 1;
                            $nextPage = $pageVal + 1;

                            //输出页码
                            echo '<div class="page-number">';
                            if ($pageVal !== 1){
                                echo '<a class="my-page-num" href="./Browser.php' . $originQuery . '&page=' . $prePage . '"><i class="fa fa-angle-double-left"></i></a>';
                            }
                            for($i = 1; $i <= $pageNum; $i++){
                                echo '<a class="my-page-num"';
                                if ($i == $pageVal){
                                    echo ' style="color: black"';
                                }
                                echo ' href="./Browser.php' . $originQuery . '&page=' . $i . '">' . $i . '</a>';
                            }
                            if($pageVal != $pageNum){
                                echo '<a class="my-page-num" href="./Browser.php' . $originQuery . '&page=' . $nextPage . '"><i class="fa fa-angle-double-right"></i></a>';
                            }
                            echo '</div>';
                        }
                    }
                    else{
                        echo '<div style="text-align: center; width: 100%; color: gray">未浏览</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>
</html>