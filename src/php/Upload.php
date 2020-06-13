<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/Style.css" />
    <link rel="stylesheet" href="../css/Upload.css" />
    <script src="../js/jQuery.min.js"></script>
    <base target="_self" />
    <title>上传</title>
</head>

<body>
    <nav class="shadowed" name="top">
        <div class="container">
            <div class="my-container-nav">
                <div class="left-nav">
                    <div class="logo"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <a class="highlight_off" href="Home.php">首页</a>
                    <a class="highlight_off" href="Browser.php">浏览页</a>
                    <a class="highlight_off" href="Search.php">搜索页</a>
                </div>
                <div class="right-nav">
                    <a class="dropdown-nav">&nbsp;个人中心&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                    <div class="dropdown-content-nav shadowed">
                        <a href="Upload.php"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;上传</a>
                        <a href="MyPhoto.php"><i class="fa fa-image"></i>&nbsp;&nbsp;我的照片</a>
                        <a href="Favor.php"><i class="fa fa-star"></i>&nbsp;&nbsp;我的收藏</a>
                        <a href="../../index.php"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;登入</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="my-container">
        <div class="my-box shadowed">
            <div class="my-row title-box text-intent-default">上传</div>
            <form name="upload_form" id="upload_form" action="MyPhoto.php">
                <div class="photo-box">
                    <img src="" id="upload_img" alt="上传图片" />
                </div>

                <div class="upload-btn-box">
                    <input type="file" name="upload_fire" id="upload_fire" />
                </div>

                <script>
                    $("#upload_fire").change(function(){
                        var objUrl = getObjectURL(this.files[0]) ;
                        console.log("objUrl = "+objUrl) ;
                        if (objUrl)
                        {
                            $("#upload_img").attr("src", objUrl);
                            $("#upload_img").removeClass("hide");
                        }
                    }) ;
                    //建立一個可存取到該file的url
                    function getObjectURL(file)
                    {
                        var url = null ;
                        if (window.createObjectURL != undefined)
                        { // basic
                            url = window.createObjectURL(file) ;
                        }
                        else if (window.URL != undefined)
                        {
                            // mozilla(firefox)
                            url = window.URL.createObjectURL(file) ;
                        }
                        else if (window.webkitURL != undefined) {
                            // webkit or chrome
                            url = window.webkitURL.createObjectURL(file) ;
                        }
                        return url ;
                    }
                </script>

                <div class="submit-box">
                    图片标题：<br />
                    <input type="text" name="title" /><br />
                    图片描述：<br />
                    <textarea rows="6" name="description" class="my-description-txt"></textarea><br />
                    拍摄国家：<br />
                    <input type="text" name="country" /><br />
                    拍摄城市：<br />
                    <input type="text" name="city" /><br />

                    <div id="submit_btn" class="my-btn">提交</div>
                </div>
            </form>

            <script>
                $(function(){
                    $("#submit_btn").click(function () {
                        alert('提交成功');
                        document:upload_form.submit();
                    });
                });
            </script>
        </div>
    </div>

    <div class="my-footer">
        <p>Copyright &copy; 2019-2021 Web fundamental. All Rights Reserved. 备案号：18307130251</p>
    </div>
</body>
</html>