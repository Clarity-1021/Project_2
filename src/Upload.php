<?php
require_once('./php/config.php');
session_start();
$mycenterflag = 'none';
$loginflag = 'block';

if(!isset($_SESSION['UID'])){
    echo"<script>alert('请登录后再访问此页面');history.go(-1);</script>";
}
else {
    $mycenterflag = 'block';
    $loginflag = 'none';
}

//输出单个国家选项
function outputSingleCountryOption($row, $isModify, $country){
    echo '<option';
    if ($isModify && ($row['ISO'] === $country)){
        echo ' selected';
    }
    echo ' value="' . $row['ISO'] . '">' . $row['CountryName'] . '</option>';
}

//输出所有国家选项
function outputCountryOptions($isModify, $country){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM geocountries ORDER BY CountryName";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    while ($row = $statement->fetch()){
        outputSingleCountryOption($row, $isModify, $country);
    }
}

//输出单个主题选项
function outputSingleThemeOption($row, $isModify, $theme){
    echo '<option';
    if ($isModify && ($row['Content'] === $theme)){
        echo ' selected';
    }
    echo ' value="' . $row['Content'] . '">' . $row['Theme'] . '</option>';
}

//输出所有主题选项
function outputThemeOptions($isModify, $theme){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM imagetheme ORDER BY Content";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    while ($row = $statement->fetch()){
        outputSingleThemeOption($row, $isModify, $theme);
    }
}

//输出单个城市选项
function outputSingleCityOption($row, $city){
    echo '<option';
    if ($row['GeoNameID'] === $city){
        echo ' selected';
    }
    echo ' value="' . $row['GeoNameID'] . '">' . $row['AsciiName'] . '</option>';
}

//输出所有城市选项
function outputCityOptions($country, $city){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM `geocities` WHERE CountryCodeISO=:iso ORDER BY AsciiName";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':iso',$country);
    $statement->execute();

    while ($row = $statement->fetch()){
        outputSingleCityOption($row, $city);
    }
}

function test_input($data) {
    $data = trim($data);//去前后空格
    $data = stripslashes($data);//删除输入的反斜杠
    $data = htmlspecialchars($data);//把符号转为HTML实体
    return $data;
}

$inModify = false;
if(isset($_GET['ImageID'])){
    $ImageID = $_GET['ImageID'];

    //用ImageID找这个图片
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM travelimage WHERE ImageID=:imgid and UID=' . $_SESSION['UID'];
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':imgid',$ImageID);
    $statement->execute();

    if($statement->rowCount()>0) {
        $row = $statement->fetch();
    }
    else{
        echo "<script>alert('这不是你上传的图片，你不能修改');history.go(-1);</script>";
    }

    //获取标题
    $title = ($row['Title'] === NULL) ? '无' : $row['Title'];
    //获取描述
    $description = ($row['Description'] === NULL) ? '无' : $row['Description'];
    //获取主题
    $theme = $row['Content'];
    //获取国家
    $country = $row['CountryCodeISO'];
    //获取城市
    $city = $row['CityCode'];
    //获取图片PATH
    $path = '../img/travel-images/medium/' . $row['PATH'];

    $isModify = true;
}
$displayChooseImg = $isModify ? 'style="display: none"' : '';

$fileHint = 'hidden';
$fileErr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$isModify){//上传
        if ($_FILES["file"]["error"] > 0){
            $fileHint = 'visible';
            $fileErr = "上传失败,请重新提交";
        }
        else {
            if (file_exists("../img/travel-images/medium/" . $_SESSION['UID'] . "/" . $_FILES["file"]["name"])) {
                $fileHint = 'visible';
                $fileErr = "图片名称已存在，请修改图片名称";
            }
            else{
                //把图片保存到文件夹
                $flag = true;
                $myDir = "../img/travel-images/medium/" . $_SESSION['UID'];
                if(!is_dir($myDir)){
                    if(!mkdir($myDir,0777,true)){
                        $fileHint = 'visible';
                        $fileErr = "上传失败，请重新提交";
                        $flag = false;
                    }
                }
                if($flag !== false){
                    $title = test_input($_POST["title"]);
                    $description = test_input($_POST["description"]);
                    $theme = $_POST["theme"];
                    $country = $_POST["country"];
                    $city = $_POST["city"];
                    $path = $_SESSION['UID'] . "/" . $_FILES["file"]["name"];

                    move_uploaded_file($_FILES["file"]["tmp_name"], "../img/travel-images/medium/" . $path);

                    $uid = $_SESSION['UID'];

                    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO travelimage (Title, Description, Content, CountryCodeISO, CityCode, PATH, UID) VALUES (:tit, :descpt, :content, :countryiso, :citycode, :path, :uid)";
                    $statement = $pdo->prepare($sql);
                    $statement->bindValue(':tit',$title);
                    $statement->bindValue(':descpt',$description);
                    $statement->bindValue(':content',$theme);
                    $statement->bindValue(':countryiso',$country);
                    $statement->bindValue(':citycode',$city);
                    $statement->bindValue(':path',$path);
                    $statement->bindValue(':uid',$uid);
                    $statement->execute();

                    header("Location: ./MyPhoto.php");
                }
            }
        }
    }
    else{//修改
        $titleNew = test_input($_POST["title"]);
        if($titleNew !== $title){
            updateOne('Title', $titleNew, $ImageID);
        }
        $descriptionNew = test_input($_POST["description"]);
        if ($descriptionNew  !== $description){
            updateOne('Description', $descriptionNew, $ImageID);
        }
        $themeNew = $_POST["theme"];
        if ($themeNew !== $description){
            updateOne('Content', $themeNew, $ImageID);
        }
        $countryNew = $_POST["country"];
        if ($countryNew !== $country){
            updateOne('CountryCodeISO', $countryNew, $ImageID);
        }
        $cityNew = $_POST["city"];
        if ($cityNew !== $city){
            updateOne('CityCode', $cityNew, $ImageID);
        }

        header("Location: ./MyPhoto.php");
    }
}

function updateOne($column, $val, $ImageID){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'UPDATE travelimage SET ' . $column . '=:val WHERE ImageID=:imgid';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':imgid',$ImageID);
    $statement->bindValue(':val',$val);
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
    <link rel="stylesheet" href="css/Upload.css" />
    <script src="js/jQuery.min.js"></script>
    <base target="_self" />
    <title>上传</title>
</head>

<body onload="hasEmpty();">
    <nav class="shadowed" name="top">
        <div class="container">
            <div class="my-container-nav">
                <div class="left-nav">
                    <div class="logo"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <a class="highlight_off" href="../index.php">首页</a>
                    <a class="highlight_off" href="Browser.php">浏览页</a>
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
            <div class="my-row title-box text-intent-default">上传</div>

            <div class="photo-box">
                <img src="<?php echo $path;?>" id="upload_img" alt="<?php if ($title === ""){echo $title;}else{echo "上传图片";}?>" />
            </div>

            <form name="upload_form" id="upload_form" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode !== 13;">
                <div class="upload-btn-box" <?php echo $displayChooseImg;?>>
                    <div class="red pr-5" id="fileStar">*</div>
                    <input type="file" onchange="checkImg();" name="file" id="file" />
                </div>

                <div class="hint-message" id="fileHint"></div>

                <script>
                    $("#file").change(function(){
                        var objUrl = getObjectURL(this.files[0]) ;
                        if (objUrl) {
                            $("#upload_img").attr("src", objUrl);
                        }
                    }) ;

                    //建立一個可存取到該file的url
                    function getObjectURL(file){
                        var url = null ;
                        if (window.createObjectURL != undefined) { // basic
                            url = window.createObjectURL(file) ;
                        }
                        else if (window.webkitURL != undefined) {
                            // webkit or chrome
                            url = window.webkitURL.createObjectURL(file) ;
                        }
                        else if (window.URL != undefined) {
                            // mozilla(firefox)
                            url = window.URL.createObjectURL(file) ;
                        }
                        return url ;
                    }
                </script>

                <div class="submit-box">
                    <span class="red" id="titleStar">*</span> 图片标题：<br />
                    <input onchange="hasEmpty()" type="text" name="title" value="<?php echo $title;?>" /><br />
                    <span class="red" id="descriptionStar">*</span> 图片描述：<br />
                    <textarea onchange="hasEmpty()" rows="6" name="description" class="my-description-txt"><?php echo $description;?></textarea><br />

                    <div class="select-box">
                        <div class="red" id="themeStar">* </div>
                        <div class="input-select">
                            <select onchange="hasEmpty();" class="input-box rounded" name="theme" id="theme">
                                <option value="0">主题</option>
                                <?php outputThemeOptions($isModify, $theme);?>
                            </select>
                        </div>

                        <div class="red" id="countryStar">* </div>
                        <div class="input-select">
                            <select class="input-box rounded" name="country" id="country" onchange="setCities(this.value);">
                                <option value="0">国家</option>
                                <?php outputCountryOptions($isModify, $country);?>
                            </select>
                        </div>

                        <div class="red" id="cityStar">* </div>
                        <div class="input-select" id="cityOptions">
                            <select onchange="hasEmpty();" class="input-box rounded" name="city" id="city">
                                <option value="0">城市</option>
                                <?php if($isModify){outputCityOptions($country, $city);}?>
                            </select>
                        </div>
                    </div>

                    <div class="hint-message" id="emptyMsg" style="visibility: hidden"><i class="fa fa-info-circle" aria-hidden="true"></i>  请输入完整信息</div>
                    <div class="hint-message" id="emptyMsg" style="visibility: <?php echo $fileHint;?>"><i class="fa fa-info-circle" aria-hidden="true"></i>  <?php echo $fileErr;?></div>

                    <div id="submit_btn" onclick="onSubmit();"<?php if($isModify){echo ' class="modify-btn" style="width: 110px">修改';}else{ echo 'class="my-btn">提交';}?></div>
                </div>
            </form>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>

<script>
    function onSubmit(){
        let isModify = (document.getElementById('submit_btn').className === "modify-btn");

        let hasEmpty = this.hasEmpty();
        this.emptyHint(hasEmpty);
        if(!hasEmpty){
            if (!isModify){//上传
                let checkImg = this.checkImg();
                if (checkImg){
                    document.getElementById('upload_form').submit();
                }
                else {
                    emptyHint(!checkImg);
                }
            }
            else {//修改
                document.getElementById('upload_form').submit();
            }
        }
    }

    function checkImg() {
        let file = document.getElementById('file').value;
        if(file === "" || file === null){
            document.getElementById('fileStar').style.visibility = 'visible';
            return false;
        }
        else{
            let logo = "<i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> ";
            if (file.lastIndexOf('.') === -1){
                document.getElementById('fileHint').innerHTML = logo + "图片路径不正确";
                document.getElementById('fileStar').style.visibility = 'visible';
                return false;
            }
            let validForm = ".jpg|.jpeg|.gif|.png|";
            let imgForm = file.substring(file.lastIndexOf(".")).toLowerCase();
            if(validForm.indexOf(imgForm + "|") === -1){
                document.getElementById('fileHint').innerHTML = logo + "图片格式仅允许jpg、jpeg、png和gif";
                document.getElementById('fileStar').style.visibility = 'visible';
                return false;
            }
            let imgSize = document.getElementById('file').files[0].size/(1024*1024);
            if (imgSize > 1){
                document.getElementById('fileHint').innerHTML = logo + "图片大小不能大于1M";
                document.getElementById('fileStar').style.visibility = 'visible';
                return false;
            }
            document.getElementById('fileStar').style.visibility = 'hidden';
            document.getElementById('fileHint').innerHTML = "";
            return true;
        }
    }

    function emptyHint(hasEmpty) {
        if(hasEmpty){
            document.getElementById('emptyMsg').style.visibility = 'visible';
        }
        else {
            document.getElementById('emptyMsg').style.visibility = 'hidden';
        }
    }

    function hasEmpty() {
        let result = false;

        let title = document.getElementById('upload_form').title.value;
        if(title === ""){
            result = true;
            document.getElementById('titleStar').style.visibility = 'visible';
        }
        else {
            document.getElementById('titleStar').style.visibility = 'hidden';
        }

        let description = document.getElementById('upload_form').description.value;
        if(description === ""){
            result = true;
            document.getElementById('descriptionStar').style.visibility = 'visible';
        }
        else {
            document.getElementById('descriptionStar').style.visibility = 'hidden';
        }

        let theme = document.getElementById('upload_form').theme.value;
        if(theme === "0"){
            result = true;
            document.getElementById('themeStar').style.visibility = 'visible';
        }
        else {
            document.getElementById('themeStar').style.visibility = 'hidden';
        }

        let country = document.getElementById('upload_form').country.value;
        if(country === "0"){
            result = true;
            document.getElementById('countryStar').style.visibility = 'visible';
        }
        else {
            document.getElementById('countryStar').style.visibility = 'hidden';
        }

        let city = document.getElementById('upload_form').city.value;
        if(city === "0"){
            result = true;
            document.getElementById('cityStar').style.visibility = 'visible';
        }
        else {
            document.getElementById('cityStar').style.visibility = 'hidden';
        }

        return result;
    }

    function setCities(country){
        if (country === "0"){
            setCityOptions(new Object());
            this.hasEmpty();
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
        let citySelect = document.getElementById('upload_form').city;
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
        this.hasEmpty();
    }
</script>



</html>