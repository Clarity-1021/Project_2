<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/Style.css" />
    <link rel="stylesheet" href="../css/Home.css" />
    <base target="_self" />
    <title>首页</title>
</head>


<body>
    <nav class="shadowed" name="top">
        <div class="container">
            <div class="my-container-nav">
                <div class="left-nav">
                    <div class="logo"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <a class="highlight_on" href="Home.php">首页</a>
                    <a class="highlight_off" href="Browser.php">浏览页</a>
                    <a class="highlight_off" href="Search.php">搜索页</a>
                </div>

                <div class="right-nav">
                    <a class="dropdown-nav">&nbsp;个人中心&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                    <div class="dropdown-content-nav shadowed">
                        <a href="Upload.php"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;上传</a>
                        <a href="MyPhoto.php"><i class="fa fa-image"></i>&nbsp;&nbsp;我的照片</a>
                        <a href="Favor.php"><i class="fa fa-star"></i>&nbsp;&nbsp;我的收藏</a>
                        <a href="../../index.php"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;登出</a>
                    </div>
                </div>

                <div class="right-nav">
                    <a class="highlight_off" href="../../index.php"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;登录</a>
                </div>

                <script>

                </script>
            </div>
        </div>
    </nav>

    <div class="my-container">
        <img src="../../img/normal/medium/9496560520.jpg" class="shadowed" alt="头图" width="100%" />

        <div class="photo-box-outer">
            <div class="photo-box shadowed">
                <a href="Detail.php">
                    <img src="../../img/normal/medium/5856654945.jpg" class="shadowed-lg" alt="热门图片" />
                </a>

                <h4>Lorem, ipsum dolor.</h4>

                <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
            </div>

            <div class="photo-box shadowed">
                <a href="Detail.php">
                    <img src="../../img/normal/medium/5856697109.jpg" class="shadowed-lg" alt="热门图片" />
                </a>

                <h4>Lorem, ipsum dolor.</h4>

                <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
            </div>

            <div class="photo-box shadowed">
                <a href="Detail.php">
                    <img src="../../img/normal/small/8711645510.jpg" class="shadowed-lg" alt="热门图片" />
                </a>

                <h4>Lorem, ipsum dolor.</h4>

                <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
            </div>

            <div class="photo-box shadowed">
                <a href="Detail.php">
                    <img src="../../img/normal/small/6114850721.jpg" class="shadowed-lg" alt="热门图片" />
                </a>

                <h4>Lorem, ipsum dolor.</h4>

                <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
            </div>

            <div class="photo-box shadowed">
                <a href="Detail.php">
                    <img src="../../img/normal/medium/8152020963.jpg" class="shadowed-lg" alt="热门图片" />
                </a>

                <h4>Lorem, ipsum dolor.</h4>

                <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
            </div>

            <div class="photo-box shadowed">
                <a href="Detail.php">
                    <img src="../../img/normal/small/6114904363.jpg" class="shadowed-lg" alt="热门图片" />
                </a>

                <h4>Lorem, ipsum dolor.</h4>

                <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
            </div>
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
                    <img src="../../img/WeChat.JPG" alt="微信二维码" width="100%" />
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
        <a class="assist-icon" href="" onclick="alert('刷新成功')">
            <i class="fa fa-refresh"></i>
        </a>
    </div>

</body>
</html>