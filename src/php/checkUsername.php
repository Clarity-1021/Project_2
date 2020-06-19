<?php
require_once('./config.php');

function test_input($data) {
    $data = trim($data);//去前后空格
    $data = stripslashes($data);//删除输入的反斜杠
    $data = htmlspecialchars($data);//把符号转为HTML实体
    return $data;
}

if (isset($_GET['username']) && $_GET['username'] !== "") {
    $username = test_input($_GET["username"]);

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sql = "SELECT * FROM traveluser WHERE UserName=:user";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user',$username);
    $statement->execute();

    //检查用户名是否已存在
    if($statement->rowCount() > 0){
        echo 'false';
    }
    else{
        echo 'true';
    }
}

?>