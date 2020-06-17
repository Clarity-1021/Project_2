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

<body>
<script>
    let cities = {'Afghanistan':['\'Unabah','Ab-e Kamari','Adraskan','Afaki','Aibak','Alah Say','Aliabad','Amanzi','Anar Darah','Andkhoy','Aq Kupruk','Aqchah','Art Khwajah','Asadabad','Ashkasham','Asmar','Babasakhib','Bagh-e Maidan','Baghlan','Bagrami','Baharak','Bal Chiragh','Bala Murghab','Balkh','Bamyan','Banu','Baraki Barak','Barg-e Matal','Basawul','Bazar-e Talah','Bazar-e Tashkan','Bazarak','Bulolah','Burkah','Chaghcharan','Chah Ab','Chahar Bagh','Chahar Burj','Chahar Qal`ah','Chakaran','Chakaray','Chandal Ba\'i','Charikar','Charkh','Chimtal','Chinar','Chiras','Chisht-e Sharif','Chowney','Cool urhajo','Dahan-e Jarf','Dandar','Dangam','Darayim','Darqad','Darzab','Dasht-e Archi','Dasht-e Qal`ah','De Narkhel Kelay','Deh Khwahan','Deh-e Now','Deh-e Salah','Dehdadi','Dehi','Doshi','Dowlat Shah','Dowlatabad','Dowlatyar','Dowr-e Rabat','Du Lainah','Du Qal`ah','Duab','Dwah Manday','Faizabad','Farah','Farkhar','Fayzabad','Gardez','Gereshk','Ghazni','Ghoriyan','Ghormach','Ghulam `Ali','Ghurayd Gharame','Gomal Kelay','Goshtah','Guzarah','Hafiz Moghul','Haji Khel','Herat','Hukumat-e Nad `Ali','Hukumat-e Shinkai','Hukumati Azrah','Hukumati Dahanah-ye Ghori','Ibrahim Khan','Imam Sahib','Injil','Istalif','Jabal os Saraj','Jalalabad','Jalrez','Jani Khel','Jawand','Jurm','Kabul','Kafir Qala','Kai','Kajran','Kalafgan','Kalakan','Kalan Deh','Kandahar','Kanday','Karbori','Karukh','Kazhah','Khadir','Khafizan','Khakiran','Khamyab','Khan Neshin','Khanabad','Khanaqah','Khandud','Khash','Khayr Kot','Khinj','Khinjan','Khoshamand','Khoshi','Khost','Khudaydad Khel','Khugyani','Khulbisat','Khulm','Khwajah Du Koh','Khwajah Ghar','Kiraman','Kishk-e Nakhud','Kotowal','Kuhsan','Kunduz','Kushk','Kushk-e Kuhnah','Kushkak','Lab-Sar','Langar','Larkird','Lash','Lash-e Juwayn','Lashkar Gah','La`l','Maidan Khulah','Mama Khel','Mandol','Manogay','March','Mardian','Markaz-e Hukumat-e Darweshan','Markaz-e Hukumat-e Sultan-e Bakwah','Markaz-e Sayyidabad','Markaz-e Woluswali-ye Achin','Mashhad','Maydanshakhr','Maymana','Maymay','Mazar-e Sharif','Mehtar Lam','Mingajik','Mir Bachah Kot','Mirabad','Miran','Miray','Mizan `Alaqahdari','Muhammad Aghah Wuluswali','Muqer','Musa Qal`ah','Muta Khan','Nahrin','Narang','Naray','Nayak','Nikeh','Nili','Now Dahanak','Now Zad','Nurgal','Nusay','Okak','Omnah','Pachir wa Agam','Paghman','Panjab','Parun','Pas Pul','Pasaband','Pashmul','Pasnay','Pul-e Hisar','Pul-e Khumri','Pul-e Sangi','Pul-e `Alam','Qadis','Qala i Naw','Qalat','Qal`ah-ye Farsi','Qal`ah-ye Kuf','Qal`ah-ye Kuhnah','Qal`ah-ye Na`im','Qal`ah-ye Shahi','Qal`ah-ye Shahr','Qarah Bagh','Qarah Bagh Bazar','Qaram Qol','Qaranghu Toghai','Qarawul','Qarchi Gak','Qarghah\'i','Qarqin','Qaryeh-ye Owbeh','Qashqal','Quchanghi','Qurghan','Rabat-e Sangi-ye Pa\'in','Ramak','Ru-ye Sang','Rudbar','Rustaq','Sang Atesh','Sang-e Charak','Sang-e Mashah','Sangalak-i-Kaisar','Sangar Saray','Sangin','Sar Chakan','Sar Kani','Sar-e Pul','Sar-e Tayghan','Sarfiraz Kala','Sarobi','Sayad','Sayagaz','Shahr-e Safa','Shahrak','Shahran','Shaykh Amir Kelay','Shayrwani-ye Bala','Sheywah','Shibirghan','Shindand','Shwak','Siyahgird','Sozmah Qal`ah','Sperah','Spin Boldak','Ster Giyan','Sultanpur-e `Ulya','Surkh Bilandi','Tagab','Tagaw-Bay','Taloqan','Taqchah Khanah','Tarinkot','Taywarah','Tir Pul','Titan','Tormay','Tsamkani','Tsaperai','Tsowkey','Tukzar','Tulak','Urgun','Uruzgan','Washer','Wuleswali Bihsud','Wuleswali Sayyid Karam','Wuluswali `Alingar','Wutahpur','Yahya Khel','Yangi Qal`ah','Zamto Kelay','Zarah Sharan','Zaranj','Zargaran','Zarghun Shahr','Zaybak','Zerok-Alakadari','Ziarat-e Shah Maqsud','Zindah Jan','Ziraki','Zorkot','Zurmat','`Alaqahdari Atghar','`Alaqahdari Dishu','`Alaqahdari Gelan','`Alaqahdari Kiran wa Munjan','`Alaqahdari Sarobi','`Alaqahdari Shah Joy','`Alaqahdari Yosuf Khel','`Alaqahdari-ye Almar','`Ali Khel','`Ali Sher `Alaqahdari'],'Aland Islands':['Braendoe','Eckeroe','Finstroem','Foegloe','Geta','Hammarland','Jomala','Koekar','Kumlinge','Lemland','Lumparland','Mariehamn','Saltvik','Sottunga','Sund','Vardoe'],'Albania':['Aliko','Allkaj','Aranitas','Armen','Arras','Arren','Bajram Curri','Baldushk','Ballaban','Ballagat','Balldreni i Ri','Ballsh','Barmash','Baz','Belsh','Berat','Berdica e Madhe','Berxull','Berzhite','Bicaj','Bilisht','Blerim','Blinisht','Bogove','Bradashesh','Brataj','Bubq','Bubullime','Bucimas','Bujan','Bulqize','Burrel','Bushat','Bushtrice','Buz','Bytyc','Cakran','Carshove','Cepan','Cerava','Cerrik','Clirim','Corovode','Cudhi Zall','Cukalat','Dajc','Dajt','Dardhas','Delvine','Derjan','Dermenas','Dervician','Dhiver','Dishnice','Divjake','Drenove','Durres','Dushk','Elbasan','Erseke','Fajze','Farka e Madhe','Fier','Fier-Cifci','Fier-Shegan','Fierze','Finiq','Frakulla e Madhe','Frasher','Fratar','Funare','Fushe-Arrez','Fushe-Bulqize','Fushe-Cidhne','Fushe-Kruje','Fushe-Lure','Fushe-Muhurr','Fushekuqe','Gjegjan','Gjepalaj','Gjerbes','Gjergjan','Gjinaj','Gjinar','Gjirokaster','Gjocaj','Gjorica e Siperme','Golaj','Golem','Gose e Madhe','Gostime','Grabjan','Gracen','Gradishte','Gramsh','Grekan','Greshice','Grude-Fushe','Gruemire','Guri i Zi','Gurra e Vogel','Hajmel','Hasan','Hekal','Helmas','Himare','Hocisht','Hot','Hotolisht','Hysgjokaj','Iballe','Ishem','Kacinar','Kajan','Kakavije','Kalenje','Kalis','Kallmet','Kallmeti i Madh','Kamez','Karbunara e Vogel','Kardhiq','Karine','Kashar','Kastrat','Kastriot','Katundi i Ri','Kavaje','Kelcyre','Klos','Kodovjat','Kokaj','Kolc','Kolonje','Kolsh','Kombesi','Konispol','Koplik','Korce','Kote','Kozare','Krahes','Krrabe','Kruje','Krume','Krutja e Poshtme','Kryevidh','Kthella e Eperme','Kuc','Kucove','Kukes','Kukur','Kuman','Kurbnesh','Kurjan','Kushove','Kutalli','Kute','Labinot-Fushe','Labinot-Mal','Lac','Lazarat','Lekaj','Lekas','Lekbibaj','Lenias','Leshnje','Leskovik','Levan','Lezhe','Libofshe','Libohove','Libonik','Librazhd','Librazhd-Qender','Liqenas','Lis','Livadhja','Llugaj','Luftinje','Lukove','Lunik','Lushnje','Luzi i Vogel','Macukull','Maliq','Maminas','Mamurras','Manze','Maqellare','Markat','Martanesh','Mbrostar-Ure','Melan','Memaliaj','Mesopotam','Milot','Miras','Moglice','Mollaj','Mollas','Ndroq','Ngracan','Nicaj-Shale','Nicaj-Shosh','Nikel','Novosele','Odrie','Orenje','Orikum','Orosh','Ostreni i Math','Otllak','Pajove','Paper','Paskuqan','Patos','Patos Fshat','Peqin','Permet','Perondi','Perparim','Perrenjas','Perrenjas-Fshat','Peshkopi','Petran','Petrele','Peza e Madhe','Picar','Pirg','Pishaj','Piskove','Pogradec','Pojan','Polican','Polis-Gostime','Porocan','Portez','Poshnje','Potom','Preze','Proger','Progonat','Proptisht','Puke','Qafemal','Qelez','Qerret','Qestorat','Qukes-Skenderbe','Rajce','Remas','Roshnik','Roskovec','Rrape','Rrasa e Siperme','Rrashbull','Rreshen','Rrogozhine','Rubik','Rukaj','Ruzhdie','Sarande','Saraqinishte','Selenice','Selishte','Selite','Sevaster','Shales','Shengjergj','Shengjin','Shenkoll','Shenmeri','Sheze','Shijak','Shirgjan','Shishtavec','Shkoder','Shtiqen','Shupenze','Shushice','Sinaballaj','Sinje','Skenderbegas','Skore','Sllove','Stebleve','Stravaj','Strum','Suc','Suke','Sukth','Sult','Surroj','Synej','Tepelene','Terbuf','Thumane','Tirana','Tomin','Topojan','Topoje','Trebinje','Trebisht-Mucine','Tregan','Tunje','Udenisht','Ujmisht','Ulez','Ungrej','Ura Vajgurore','Valbone','Vaqarr','Vau i Dejes','Velabisht','Velcan','Velipoje','Vendresha e Vogel','Vergo','Vertop','Vithkuq','Vllahine','Vlore','Vore','Voskop','Voskopoje','Vranisht','Vreshtas','Vukatane, Vukatan','Xarre','Xhafzotaj','Xiber-Murrize','Zall-Bastar','Zall-Dardhe','Zall-Herr','Zall-Rec','Zapod','Zavaline','Zejmen','Zerqan','Zharrez','Zhepe'],'Algeria':['\'Ain Abid','\'Ain Arnat','\'Ain Benian','\'Ain Boucif','\'Ain Deheb','\'Ain el Bell','\'Ain el Berd','\'Ain el Hadjar','\'Ain el Hammam','\'Ain el Melh','\'Ain el Turk','\'Ain Merane','\'Ain Temouchent','Abou el Hassan','Adrar','Aflou','Ain Beida','Ain Bessem','Ain Defla','Ain el Bya','Ain Fakroun','Ain Kercha','Ain Oussera','Ain Sefra','Ain Smara','Ain Taya','Ain Touta','Akbou','Algiers','Amizour','Ammi Moussa','Annaba','Aoulef','Arbatache','Arhribs','Arris','Azazga','Azzaba','Bab Ezzouar','BABOR - VILLE','Baraki','Barbacha','Barika','Batna','Bechar','Bejaia','Ben Mehidi','Beni Amrane','Beni Douala','Beni Mered','Beni Mester','Beni Saf','Bensekrane','Berrahal','Berriane','Berrouaghia','Besbes','Bir el Ater','Bir el Djir','Birine','Birkhadem','Biskra','Blida','Boghni','Bordj Bou Arreridj','Bordj el Kiffan','Bordj Ghdir','Bordj Zemoura','Bou Arfa','Bou Hanifia el Hamamat','Bou Ismail','Bou Tlelis','Boudjima','Boudouaou','Boufarik','Bougaa','Bougara','Bouinan','Bouira','Boukadir','Boumahra Ahmed','Boumerdas','Brezina','Chabet el Ameur','Charef','Chebli','Chelghoum el Aid','Chemini','Cheraga','Cheria','Chetouane','Chiffa','Chlef','Chorfa','Constantine','Dar Chioukh','Dar el Beida','Debila','Dellys','Didouche Mourad','Djamaa','Djebilet Rosfa','Djelfa','Djidiouia','Douera','Draa Ben Khedda','Draa el Mizan','Drean','Ech Chettia','El Abadia','El Abiodh Sidi Cheikh','El Achir','El Affroun','El Amria','El Aouinet','El Attaf','El Bayadh','El Eulma','El Hadjar','El Hadjira','el hed','El Idrissia','El Kala','El Khroub','El Kseur','El Malah','El Oued','El Tarf','Es Senia','Feraoun','Freha','Frenda','Guelma','Hadjout','Hamma Bouziane','Hammam Bou Hadjar','Hammamet','Hassi Messaoud','Heliopolis','Hennaya','I-n-Salah','Ighram','Illizi','Isser','Jijel','Kerkera','Khemis el Khechna','Khemis Miliana','Khenchela','Kolea','Ksar Chellala','Ksar el Boukhari','L\'Arba','L\'Arbaa Nait Irathen','Laghouat','Lakhdaria','M\'Sila','Makouda','Mansoura','Mansourah','Mascara','Mazouna','Medea','Meftah','Megarine','Mehdia','Mekla','Melouza','Merouana','Mers el Kebir','Meskiana','Messaad','Metlili Chaamba','Mila','Mostaganem','Mouzaia','Naama','Naciria','Nedroma','Oran','Ouargla','Oued el Abtal','Oued el Alleug','Oued Fodda','Oued Rhiou','Oued Sly','Ouled Mimoun','Ouled Moussa','Oum el Bouaghi','Oumache','Ras el Aioun','Ras el Oued','Reggane','Reghaia','Reguiba','Relizane','Remchi','Robbah','Rouached','Rouiba','Rouissat','Saida','Salah Bey','Saoula','Sebdou','Seddouk','Sedrata','Setif','Sfizef','Sidi Abdelli','Sidi Aissa','Sidi Akkacha','Sidi Amrane','Sidi Bel Abbes','Sidi ech Chahmi','Sidi Khaled','Sidi Merouane','Sidi Moussa','Sidi Okba','Sig','Skikda','Smala','Sougueur','Souk Ahras','Souma','Sour el Ghozlane','Tadmait','Tamalous','Tamanrasset','Tazoult-Lambese','Tebesbest','Tebessa','Telerghma','Thenia','Theniet el Had','Tiaret','Timimoun','Timizart','Tindouf','Tipasa','Tirmitine','Tissemsilt','Tizi Gheniff','Tizi Ouzou','Tizi Rached','Tizi-n-Tleta','Tlemcen','Tolga','Touggourt','Zemoura','Zeralda','Zeribet el Oued','`Ain el Hadjel']}
</script>
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

                    <div class="select-box">
                        <div class="input-select">
                            <select class="input-box rounded" name="theme" id="theme">
                                <option value="0">主题</option>
                                <option value="Scenery">Scenery</option>
                                <option value="City">City</option>
                                <option value="People">People</option>
                                <option value="Animal">Animal</option>
                                <option value="Building">Building</option>
                                <option value="Wonder">Wonder</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="input-select">
                            <select class="input-box rounded" name="country" onChange="set_city(this, this.form.city);" id="country" >
                                <option value="0">国家</option>
                            </select>
                        </div>

                        <div class="input-select">
                            <select class="input-box rounded" name="city" id="city">
                                <option value="0">城市</option>
                            </select>
                        </div>
                    </div>

                    <script>
                        // 给国家赋值
                        let countrySelect = document.getElementById('upload_form').country;
                        let optCount = 1;
                        for(let key in cities){
                            console.log(key);
                            countrySelect.options[optCount] = new Option();
                            countrySelect.options[optCount].text = key;
                            countrySelect.options[optCount].value = key;
                            optCount++;
                        }

                        // 用国家选值联动城市
                        function set_city(country, city)
                        {
                            let pv, cv;
                            let i, ii;

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

<!--                    拍摄国家：<br />-->
<!--                    <input type="text" name="country" /><br />-->
<!--                    拍摄城市：<br />-->
<!--                    <input type="text" name="city" /><br />-->

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