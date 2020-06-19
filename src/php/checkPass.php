<?php
require_once('./config.php');
session_start();

function validLogin(){
    $result = NULL;

    $password = sha1($_GET['password']);

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sql = "SELECT * FROM traveluser WHERE UserName=:user";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user',$_GET['username']);
    $statement->execute();

    if($statement->rowCount() > 0){
        $row = $statement->fetch();
        $salt = $row['SALT'];
        $password = sha1($_GET['password'] . $salt);
        if($password === $row['SALTEDPASSHASH']){
            $result = $row['UID'];
        }
    }

    return $result;
}

if (isset($_GET['username']) && $_GET['username'] !== "" && isset($_GET['password']) && $_GET['password'] !== "") {
    $UID = validLogin();
    if($UID !== NULL){
        $_SESSION['UID'] = $UID;
        echo 'true';
    }
    else{
        echo 'false';
    }
}


?>
