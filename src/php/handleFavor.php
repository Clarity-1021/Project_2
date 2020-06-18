<?php
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
